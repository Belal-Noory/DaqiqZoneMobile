<?php
// session_start();
require "../../init.php";

// if (isset($_SESSION["bussiness_user"])) {
//     $loged_user = json_decode($_SESSION["bussiness_user"]);
// }

$product = new Products();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add new sales
    if (isset($_POST["data"])) {
        parse_str($_POST["data"],$formData);
        $date = date("Y-m-d");
        $name = helper::test_input($formData["name"]);
        $quantity = helper::test_input($formData["quantity"]);

        // Call add function
        $res = $product->add([$name,$quantity,$date]);
        echo $res;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // get all sales
    if (isset($_GET["getproductsDetails"])) {
        $data = $product->getProductsDetails();
        echo json_encode($data->fetchAll(PDO::FETCH_OBJ));
    }
}
