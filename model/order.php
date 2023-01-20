<?php

require_once "model/model.php";
require_once "model/customer.php";
require_once "model/deliveryAdd.php";
require_once "model/orderItem.php";
require_once "fpdf/fpdf.php";

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
        
        if (isset($data["registered"]))
            $this->registered = $data["registered"];
        else if (isset($_SESSION["user"]))
            $this->registered = 1;
        else
            $this->registered = 0;

        
        if ($this->registered != 0)
        {
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
        }

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
            throw new Exception("Aucun identifiant pour cette commande");
    }

    public function get_customer_id()
    {
        if (isset($this->customer_id))
            return $this->customer_id;
        else
            throw new Exception("Aucun identifiant client saisi pour cette commande");
    }
    
    public function get_customer()
    {
        if (isset($this->customer))
            return $this->customer;
        else
            throw new Exception("Aucun client associé à cette commande");
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
            throw new Exception("Aucune adresse de livraison associée à cette commande");
    }
    
    public function get_delivery_add()
    {
        if (isset($this->delivery_add))
            return $this->delivery_add;
        else
            throw new Exception("Aucune adresse de livraison associée à cette commande");
    }
    
    public function get_payment_type()
    {
        if (isset($this->payment_type))
            return $this->payment_type;
        else
            throw new Exception("Aucun mode de paiement associé à cette commande");
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
        if ($total != $this->total)
        {
            $this->total = $total;
            $query = "UPDATE orders SET total = '".$this->total."' WHERE id = '".$this->id."'";
            self::execute($query);
        }

        return $total;
    }

    public function set_customer($customer)
    {
        $this->customer = $customer;
        $this->customer_id = $customer->get_id();
        $this->registered = 1;
        
        $query = "UPDATE orders SET customer_id = '".$this->customer_id."', registered = '1' WHERE id = '".$this->id."'";
        self::execute($query);
    }
    
    public function change_address($del_add)
    {
        if (isset($this->delivery_add))
        {
            $this->delivery_add->delete();
        }

        $this->delivery_add = $del_add;

        try {
            $id = $this->delivery_add->get_id();
            $this->delivery_add_id = $id;
        }catch (Exception $e) {
            $this->delivery_add->insert();
            $this->delivery_add_id = $this->delivery_add->get_id();
        }

        $this->status = '1';

        $query = "UPDATE orders SET delivery_add_id = '".$this->delivery_add_id."', status = '".$this->status."' WHERE id = '".$this->id."'";
        self::execute($query);
    }

    public function change_status($status)
    {
        $this->status = $status;

        $query = "UPDATE orders SET status = '".$this->status."' WHERE id = '".$this->id."'";
        self::execute($query);

        $query = "SELECT * FROM orders WHERE id = '".$this->id."'";
        $arr = self::fetchAll($query);
        if(isset($arr[0]) && $arr[0]["status"] == $this->status){
            return true;
        }
        else return false;
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
            $item->insert();
        }
        else {
            $this->items[$ind]->update_quantity($this->items[$ind]->get_quantity() + $item->get_quantity());
            $this->items[$ind]->update_in_db();
        }

        self::calculate_total();
    }

    public function delete_product($product)
    {
        $ind = $this->get_index_if_product_in_order($product);

        if ($ind == -1){
            throw new Exception("Impossible de supprimer un produit qui n'est pas dans le panier");
        }
        else {
            $this->items[$ind]->delete_from_db();

            for ($i = $ind; $i < sizeof($this->items) - 1; $i++)
            {
                $ii = $i + 1;
                $this->items[$i] = $this->items[$ii];
            }
            unset($this->items[sizeof($this->items) - 1]);
        }

        self::calculate_total();
    }

    public function set_payment_type($paymenttype) {
        $this->payment_type = $paymenttype == "paypal" ? "paypal" : "cheque";
    }

    public function paid()
    {
        $query = "UPDATE orders SET status = '2', payment_type = '".$this->payment_type."', date = '".date("Y-m-d")."' WHERE id = '".$this->id."'";
        self::execute($query);
    }

    public function generate_pdf()
    {
        if ($this->status < 2)
            throw new Exception("Impossible de générer une commande avant qu'elle ne soit terminée.");

        $pdf = new FPDF();
        $pdf->SetTitle("Facture N°".$this->id, true);
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->SetFillColor(150, 150, 150);

        // Header :
        $pdf->Image("assets/productimages/Web4ShopHeader.png", 10, 10, 50);
        $pdf->Cell(50);
        $pdf->Cell(40, 20, "Web4Shop", 0, 0, "C");

        $pdf->Ln(30);

        // Client informations
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(0, 20, $this->delivery_add->get_forname()." ".$this->delivery_add->get_surname(), 0, 0, "R");
        $pdf->Ln(7);
        $pdf->Cell(0, 20, iconv("UTF-8", "windows-1252", $this->delivery_add->get_add1()), 0, 0, "R");
        if ($this->delivery_add->get_add2() != null && $this->delivery_add->get_add2() != "") {
            $pdf->Ln(7);
            $pdf->Cell(0, 20, iconv("UTF-8", "windows-1252", $this->delivery_add->get_add2()), 0, 0, "R");
        }
        $pdf->Ln(7);
        $pdf->Cell(0, 20, iconv("UTF-8", "windows-1252", $this->delivery_add->get_postcode()." ".$this->delivery_add->get_city()), 0, 0, "R");
        $pdf->Ln(7);
        $pdf->Cell(0, 20, iconv("UTF-8", "windows-1252", $this->delivery_add->get_email()), 0, 0, "R");
        $pdf->Ln(7);
        $pdf->Cell(0, 20, iconv("UTF-8", "windows-1252", $this->delivery_add->get_phone()), 0, 0, "R");
        $pdf->Ln(15);

        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(190,10,iconv("UTF-8", "windows-1252", '  Facture'), 0, 0, '', true);
        $pdf->Ln(7);
        
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(0, 20, iconv("UTF-8", "windows-1252", "Payé le ".(DateTime::createFromFormat('Y-m-d', $this->date)->format('d/m/Y'))), 0, 0, "L");
        $pdf->Ln(7);
        $pdf->Cell(0, 20, iconv("UTF-8", "windows-1252", "Commande N° ").$this->id, 0, 0, "L");

        if (isset($this->customer_id))
        {
            $pdf->Ln(7);
            $pdf->Cell(0, 20, iconv("UTF-8", "windows-1252", "Client N° ").$this->customer_id, 0, 0, "L");
        }

        $pdf->Ln(25);

        // Products
        $items = $this->items;
        $widths = array(75, 40, 30, 45);
        $pdf->Cell($widths[0], 7, "Produits", 1, 0, 'C');
        $pdf->Cell($widths[1], 7, "Prix unitaire", 1, 0, 'C');
        $pdf->Cell($widths[2], 7, iconv("UTF-8", "windows-1252", "Quantité"), 1, 0, 'C');
        $pdf->Cell($widths[3], 7, "Total", 1, 0, 'C');
        $pdf->Ln();

        foreach($items as $item){
            $pdf->Cell($widths[0], 7, iconv("UTF-8", "windows-1252", $item->get_product()->get_name()), 'LR', 0, 'L');
            $pdf->Cell($widths[1], 7, number_format($item->get_product()->get_price(), 2).chr(128), 'LR', 0, 'R');
            $pdf->Cell($widths[2], 7, $item->get_quantity(), 'LR', 0, 'R');
            $pdf->Cell($widths[3], 7, number_format($item->get_product()->get_price() * $item->get_quantity(), 2).chr(128), 'LR', 0, 'R');
            $pdf->Ln();
        }

        $pdf->Cell($widths[0] + $widths[1] + $widths[2], 7, "Total : ", 'LBTR', 0);
        $pdf->Cell($widths[3], 7, number_format($this->total, 2).chr(128), "LTBR", 0, 'R');
        $pdf->Ln();

        $pdf->Cell(0, 20, "Paiement par ".$this->payment_type.".", 0, 0, "L");
        $pdf->Ln(14);
        $pdf->Cell(0, 20, "Nous vous remercions de votre confiance.", 0, 0, "L");
        $pdf->Ln(7);
        $pdf->Cell(0, 20, "Cordialement,", 0, 0, "L");
        $pdf->Ln(14);
        $pdf->Cell(0, 20, iconv("UTF-8", "windows-1252", "Toute l'équipe de Web4Shop"), 0, 0, "L");

        //$pdf->Cell(array_sum($widths),0,'','T');

        return $pdf;
    }

    public static function check_if_order_for_session($id_session)
    {
        $query = "SELECT * from orders WHERE registered = '0' AND (status = '0' OR status ='1') AND session = '".$id_session."'";
        $ret = self::fetchAll($query);

        if (sizeof($ret) > 0)
            return new Order($ret[0]);
        else
            return false;
    }

    public static function check_if_order_for_customer($customer)
    {
        $query = "SELECT * from orders WHERE registered = '1' AND (status = '0' OR status ='1') AND customer_id = '".$customer->get_id()."'";
        $ret = self::fetchAll($query);

        if (sizeof($ret) > 0)
            return new Order($ret[0]);
        else
            return false;
    }

    public static function select_order_by_id($id)
    {
        $query = "SELECT * FROM orders WHERE id = '".$id."' AND status > 0";
        $arr = self::fetchAll($query);
        if(isset($arr[0])){
            $ret = new Order($arr[0]);
            return $ret;
        }
        else throw new Exception("Cette commande n'existe pas ou n'est pas associée à cet utilisateur.");
    }

    public static function select_order_by_id_customer_id($id, $customer_id)
    {
        $query = "SELECT * FROM orders WHERE id = '".$id."' AND customer_id = '".$customer_id."'AND status > 0";
        $arr = self::fetchAll($query);
        if(isset($arr[0])){
            $ret = new Order($arr[0]);
            return $ret;
        }
        else throw new Exception("Cette commande n'existe pas ou n'est pas associée à cet utilisateur.");
    }

    public static function select_orders()
    {
        $query = "SELECT * FROM orders WHERE status > 0";
        $arr = self::fetchAll($query);

        $ret = array();
        foreach($arr as $order)
            array_push($ret, new Order($order));
        return $ret;
    }

    public static function select_orders_by_customer_id($customer_id)
    {
        $query = "SELECT * FROM orders WHERE status > 0 AND customer_id ='".$customer_id."'";
        $arr = self::fetchAll($query);

        $ret = array();
        foreach($arr as $order)
            array_push($ret, new Order($order));
        return $ret;
    }
}