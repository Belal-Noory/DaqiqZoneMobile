<?php

class Products
{
    // Database class
    private $conn;

    public function __construct()
    {
        $this->conn = new Connection();
    }

    public function add($params)
    {
        $query = "INSERT INTO product(name,quantity,date) VALUES(?,?,?)";
        $result = $this->conn->Query($query, $params, true);
        return $result;
    }

    public function update($params)
    {
        $query = "UPDATE product SET name = ?,quantity = ?,date = ? WHERE PID = ?";
        $result = $this->conn->Query($query, $params);
        return $result->rowCount();
    }


    public function getAllProducts()
    {
        $query = "SELECT * FROM product";
        $result = $this->conn->Query($query);
        return $result;
    }

    public function getProduct($ID)
    {
        $query = "SELECT * FROM product WHERE PID = ?";
        $result = $this->conn->Query($query, [$ID]);
        return $result;
    }

    public function getProductsDetails()
    {
        $query = "SELECT 
        p.PID,
        p.name AS 'name',
        p.quantity as product,
        sum(s.quantity) AS 'sold',
        p.quantity - sum(s.quantity) as 'result'
    FROM 
        product p
    LEFT JOIN 
        sales s ON p.name = s.product
    GROUP BY 
        p.PID, p.name";
        $result = $this->conn->Query($query);
        return $result;
    }
}
