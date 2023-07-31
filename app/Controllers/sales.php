<?php
// session_start();
require "../../init.php";

// if (isset($_SESSION["bussiness_user"])) {
//     $loged_user = json_decode($_SESSION["bussiness_user"]);
// }

$sales = new Sales();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Add new sales
    if (isset($_POST["data"])) {
        parse_str($_POST["data"],$formData);
        $date = helper::test_input($formData["date"]);
        $bill_num = helper::test_input($formData["bill_num"]);
        $customer = helper::test_input($formData["customer"]);
        $product = helper::test_input($formData["product"]);
        $price = helper::test_input($formData["price"]);
        $quantity = helper::test_input($formData["quantity"]);

        // Call add function
        $res = $sales->add([$customer,$bill_num,$date,$product,$price,$quantity]);
        echo $res;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // get all sales
    if (isset($_GET["allsales"])) {
        $data = $sales->getAllSales();
        echo json_encode($data->fetchAll(PDO::FETCH_OBJ));
    }
}
