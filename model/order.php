<?php

require_once "model/model.php";
require_once "model/customer.php";
require_once "model/deliveryAdd.php";
require_once "model/orderItem.php";

class Order extends Model {
    private $id;
    private $customer_id;
    private $registered;
    private $delivery_add_id;
    private $payment_type;
    private $date;
    private $status;
    private $session;
    private $total;

    private $customer;
    private $delivery_add;

    private $items;

    /**
     * Create a new Order
     * Obligatory : NONE
     */
    public function __construct($data)
    {
        if (isset($data["id"]))
            $this->id = $data["id"];
        
        if (isset($data["customer_id"]))
        {
            $this->customer_id = $data["customer_id"];
            $this->customer = Customer::select_customer_by_id($this->customer_id);
        }
        else if (isset($data["customer"]))
        {
            $this->customer = $data["customer"];
            $this->customer_id = $this->customer->get_id();
        }

        if (isset($data["registered"]))
            $this->registered = $data["registered"];
        else if (isset($_SESSION["user"]))
            $this->registered = 1;
        else
            $this->registered = 0;

        if (isset($data["delivery_add_id"]))
        {
            $this->delivery_add_id = $data["delivery_add_id"];
            $this->delivery_add = DeliveryAdd::select_delivery_address_by_id($this->delivery_add_id);
        }
        else if (isset($data["delivery_add"]))
        {
            $this->delivery_add = $data["delivery_add"];
            $this->delivery_add_id = $this->delivery_add->get_id();
        }
        
        if (isset($data["payment_type"]))
            $this->payment_type = $data["payment_type"];

        if (isset($data["date"]))
            $this->date = $data["date"];
        else
            $this->date = date("Y-m-d");
        
        if (isset($data["status"]))
            $this->status = $data["status"];
        else
            $this->status = 0;
        
        if (isset($data["session"]))
            $this->session = $data["session"];
        else
            $this->session = session_id();
        
        if (isset($data["total"]))
            $this->total = $data["total"];
        else
            $this->total = self::calculate_total();

        if (!isset($this->items))
            $this->items = OrderItem::select_items_by_order($this->id);
    }

    public function get_id()
    {
        if (isset($this->id))
            return $this->id;
        else
            throw new Exception("No ID set for this order. You need to insert it in the database first");
    }

    public function get_customer_id()
    {
        if (isset($this->customer_id))
            return $this->customer_id;
        else
            throw new Exception("No customer set for this order.");
    }
    
    public function get_customer()
    {
        if (isset($this->customer))
            return $this->customer;
        else
            throw new Exception("No customer set for this order.");
    }
    
    public function get_registered()
    {
        return $this->registered;
    }
    
    public function get_delivery_add_id()
    {
        if (isset($this->delivery_add_id))
            return $this->delivery_add_id;
        else
            throw new Exception("No delivery address set for this order.");
    }
    
    public function get_delivery_add()
    {
        if (isset($this->delivery_add))
            return $this->delivery_add;
        else
            throw new Exception("No delivery address set for this order.");
    }
    
    public function get_payment_type()
    {
        if (isset($this->payment_type))
            return $this->payment_type;
        else
            throw new Exception("No payment type set for this order.");
    }
    
    public function get_date()
    {
        return $this->date;
    }
    
    public function get_status()
    {
        return $this->status;
    }
    
    public function get_session()
    {
        return $this->session;
    }
    
    public function get_total()
    {
        return $this->total;
    }

    public function get_items()
    {
        return $this->items;
    }

    private function calculate_total()
    {
        if (!isset($this->items))
            $this->items = OrderItem::select_items_by_order($this->id);
        
        $total = 0;
        foreach ($this->items as $item)
        {
            $total = $total + $item->get_product()->get_price() * $item->get_quantity();
        }

        return $total;
    }

    public function insert()
    {
        $query = "";
        if (isset($this->customer_id)) {
            $query = "INSERT INTO orders (customer_id, registered, status, session, total)
                        VALUES ('".$this->customer_id."', '".$this->registered."', '".$this->status."', '".session_id()."', '".$this->total."')";
        }
        else {
            $query = "INSERT INTO orders (customer_id, registered, status, session, total)
                        VALUES ('-1', '".$this->registered."', '".$this->status."', '".session_id()."', '".$this->total."')";
        }

        $ret = self::insert_get_id($query);
        $this->id = $ret;

        if ($ret == 0 || $ret = '0')
            return false;

        return $ret;
    }

    public function get_index_if_product_in_order($p)
    {
        $counter = 0;
        foreach($this->items as $item) {
            // Same product
            if ($p->get_id() == $item->get_product()->get_id()) {
                return $counter;
            }
            $counter++;
        }

        return -1;
    }

    public function add_or_update_item($item)
    {
        $ind = $this->get_index_if_product_in_order($item->get_product());

        // Not already present
        if ($ind == -1) {
            array_push($this->items, $item);
        }
        else {
            $this->items[$ind]->updateQuantity($this->items[$ind]->get_quantity() + $item->get_quantity());
        }

        $this->calculate_total();
    }

    public function delete_product($product)
    {
        $ind = $this->get_index_if_product_in_order($product);

        if ($ind == -1){
            throw new Exception("Can not delete a product that is not in the shopping cart");
        }
        else {
            unset($this->items[$ind]);
        }

        $this->calculate_total();
    }

    public function insert_items()
    {
        
    }
}