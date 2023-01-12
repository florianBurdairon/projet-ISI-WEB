<?php

require_once "model/model.php";
require_once "model/customer.php";
require_once "model/deliveryAdd.php";

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

    public function __construct($data)
    {
        $this->id = $data["id"];
        $this->customer_id = $data["customer_id"];
        $this->registered = $data["registered"];
        $this->delivery_add_id = $data["delivery_add_id"];
        $this->payment_type = $data["payment_type"];
        $this->date = date("Y-m-d");
        $this->status = $data["status"];
        $this->session = session_id();
        $this->total = $data["total"];

        $this->customer = Customer::select_customer_by_id($this->customer_id);
        $this->delivery_add = DeliveryAdd::select_delivery_add_by_id($this->delivery_add_id);
        $this->items = OrderItem::select_items_by_order($this->id);
    }
}