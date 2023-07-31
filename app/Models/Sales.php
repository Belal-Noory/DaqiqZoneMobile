<?php

class Sales
{
    // Database class
    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }

    public function add($params)
    {
        $query = "INSERT INTO sales(customer,bill_num,date,product,price,quantity) VALUES(?,?,?,?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    public function update($params)
    {
        $query = "UPDATE sales SET customer = ?,bill_num = ?,date = ?, product = ?, price = ?, quantity = ? WHERE SID = ?";
        $result = $this->conn->Query($query, $params);
        return $result->rowCount();
    }


    public function getAllSales()
    {
        $query = "SELECT * FROM sales";
        $result = $this->conn->Query($query);
        return $result;
    }

    public function getSale($ID)
    {
        $query = "SELECT * FROM sales WHERE SID = ?";
        $result = $this->conn->Query($query, [$ID]);
        return $result;
    }

}
