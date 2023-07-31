<?php
require "init.php";
$product = new Products();
$allProductData = $product->getAllProducts();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daqiq Zone</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    </link>
    <link href="assets/fonts/bootstrap-icons.min.css" rel="stylesheet">
    </link>
    <link href="assets/css/style.css" rel="stylesheet">
    </link>
    <link href="assets/dist/css/tabulator_bootstrap5.min.css" rel="stylesheet">
    </link>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.20/jspdf.plugin.autotable.min.js"></script>
    <style>
        #main {
            max-height: 90vh;
            min-height: 90vh;
        }
    </style>
</head>

<body>
    <!-- Image and text -->
    <nav class="navbar navbar-light bg-primary" dir="rtl">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <span class="text-white">DAQIQ ZONE</span>
            </a>
        </div>
    </nav>
    <div class="d-flex flex-column justify-content-center align-items-center m-0 text-white p-5" style="background: dodgerblue;">
        <img src="assets/images/logo.jpg" alt="" width="200" height="200" class="d-inline-block align-text-top" style="border-radius: 50%;">
        <h1>خوش آمدید</h1>
        <span>لطفآ در ابتدا همه اجناس خود را در سیستم اضعافه کنید.</span>
        <button class="btn btn-warning btn-sm m-2" dir="rtl" type="button" data-bs-toggle="modal" data-bs-target="#addnewProduct">
            <i class="bi bi-plus"></i>
            جنس جدید
        </button>
    </div>

    <div class="container" id="main">
        <div class="card mt-2">
            <h5 class="card-header" dir="rtl">
                <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#addnewSales">
                    <i class="bi bi-plus-circle"></i>
                    فروش جدید
                </button>

                <button class="btn btn-warning btn-sm" type="button" id="btnprint">
                    <i class="bi bi-printer"></i>
                    چاپ
                </button>

                <button class="btn btn-success btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#productDetails">
                    <i class="bi bi-plus"></i>
                    معلومات اجناس
                </button>
            </h5>
            <div class="card-body">
                <div id="allsalesTable" dir="rtl"></div>
            </div>
        </div>
    </div>

    <!-- Modal Sales -->
    <div class="modal fade" id="addnewSales" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">افزودن فروشات جدید</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" dir="rtl">
                    <form class="row g-3 needs-validation" id="addsaleform" novalidate>
                        <div class="col-md-6">
                            <label for="date" class="form-label">تاریخ</label>
                            <input type="date" class="form-control" name="date" required>
                        </div>
                        <div class="col-md-6">
                            <label for="bill_num" class="form-label">نمبر بیل</label>
                            <input type="text" class="form-control" name="bill_num" placeholder="شماره بیل" required>
                        </div>
                        <div class="col-12">
                            <label for="customer" class="form-label">مشتری</label>
                            <input type="text" class="form-control" name="customer" placeholder="مشتری" required>
                        </div>
                        <div class="col-12">
                            <label for="product" class="form-label">مادل جنس</label>
                            <select name="product" id="product" class="form-control">
                                <?php
                                if ($allProductData->rowCount() > 0) {
                                    $allProducts = $allProductData->fetchAll(PDO::FETCH_OBJ);
                                    foreach ($allProducts as $pro) {
                                        echo "<option value='$pro->name'>$pro->name</option>";
                                    }
                                } else {
                                    echo "<option value='0'>لطفآ جنس را اضعافه کنید</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="price" class="form-label">قمیت</label>
                            <input type="text" class="form-control" name="price" placeholder="قمیت" required>
                        </div>
                        <div class="col-md-6">
                            <label for="quantity" class="form-label">مقدار</label>
                            <input type="text" class="form-control" name="quantity" placeholder="مقدار" required>
                        </div>
                        <input type="hidden" name="addnewsale" value="true">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary" id="btnadd">ثبت</button>
                            <div class="spinner-border text-primary d-none" role="status" id="loading">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Product -->
    <div class="modal fade" id="addnewProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">افزودن اجناس جدید</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" dir="rtl">
                    <form class="row g-3 needs-validation" id="addProductform" novalidate>
                        <div class="col-12">
                            <label for="name" class="form-label">نام جنس</label>
                            <input type="text" class="form-control" name="name" placeholder="نام جنس" required>
                        </div>
                        <div class="col-12">
                            <label for="quantity" class="form-label">مقدار</label>
                            <input type="text" class="form-control" name="quantity" placeholder="مقدار" required>
                        </div>
                        <input type="hidden" name="addnewproduct" value="true">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary" id="btnaddProduct">ثبت</button>
                            <div class="spinner-border text-primary d-none" role="status" id="loading">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Product Details -->
    <div class="modal fade" id="productDetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">افزودن اجناس جدید</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="allProductsTable" dir="rtl"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="toast-container
                position-absolute
                bottom-0 end-0 m-4" style="z-index: 1000;">
        <!-- Add Sale Toast -->
        <div class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true" id="toast">
            <div class="d-flex">
                <div class="toast-body">
                    فروش جدید موفقانه اضعافه شد.
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>

        <!--  Add Prodcut Toast -->
        <div class="toast align-items-center text-white bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true" id="toastP">
            <div class="d-flex">
                <div class="toast-body">
                    جنس جدید موفقانه اضعافه شد.
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/dist/js/tabulator.min.js"></script>
    <script src="assets/js/toPDF.js"></script>
    <script src="assets/js/jsPDF.js"></script>


    <script>
        $(document).ready(() => {

            $("#btnprint").on("click", function() {
                console.log("first")
                // Download Data
                table.print(false,true);
            });

            var myModal = new bootstrap.Modal(document.getElementById('addnewSales'), {
                keyboard: false,
                backdrop: false,
            });

            var myModalProduct = new bootstrap.Modal(document.getElementById('addnewProduct'), {
                keyboard: false,
                backdrop: false,
            });

            var table = new Tabulator("#allsalesTable", {
                layout: "fitColumns",
                pagination: "local",
                paginationSize: 5,
                paginationSizeSelector: [5, 10, 15, 20],
                paginationCounter: "rows",
                printAsHtml:true,
                printRowRange:"selected",
                printStyled:true,
                printHeader:`<div class='row m-0'>
                                <img src='assets/images/logo.jpg' alt='' width='100' class='d-inline-block align-text-top col-6'>
                                <div class='col-6' style='text-align:right'>
                                    <h1>دقیق موبایل زون</h1>
                                    <h1>Daqiq Mobile Zone</h1>
                                    <span>آدرس: گلبهار سنتر منزل سوم دوکان نمبر (C90)</span>
                                    <div style='text-align:right'>
                                        <i class="bi bi-whatsapp"></i>
                                        <span>+93 (0) 786 177 424</span>
                                        <span>موبایل:</span
                                    </div>
                                </div>
                            </div>`,
                printFooter:"<h2>Thank You ;)<h2>",
                columns: [{
                        title: "شماره",
                        field: "SID",
                        sorter: "string",
                        formatter:"rowSelection", titleFormatter:"rowSelection", hozAlign:"center", headerSort:false,
                    },
                    {
                        title: "مشتری",
                        field: "customer",
                        sorter: "string",
                        headerFilter: true,
                        headerFilterPlaceholder: "جستجو"
                    },
                    {
                        title: "نمبر بیل",
                        field: "bill_num",
                        headerFilter: true,
                        headerFilterPlaceholder: "جستجو"
                    },
                    {
                        title: "تاریخ",
                        field: "date",
                        sorter: "date",
                        headerFilter: true,
                        headerFilterPlaceholder: "جستجو"
                    },
                    {
                        title: "مادل",
                        field: "product",
                        sorter: "string",
                        headerFilter: true,
                        headerFilterPlaceholder: "جستجو",
                        width: '600'
                    },
                    {
                        title: "قیمت",
                        field: "price",
                        sorter: "string"
                    },
                    {
                        title: "مقدار",
                        field: "quantity",
                        sorter: "string"
                    }
                ],
                ajaxURL: "./app/Controllers/sales.php", //ajax URL
                ajaxParams: {
                    allsales: "true"
                }, //ajax parameters
            });

            var tableProduct = new Tabulator("#allProductsTable", {
                layout: "fitDataFill",
                columns: [{
                        title: "شماره",
                        field: "PID",
                        sorter: "string"
                    },
                    {
                        title: "جنس",
                        field: "name",
                        sorter: "string",
                        headerFilter: true,
                        headerFilterPlaceholder: "جستجو",
                        width: 200,
                    },
                    {
                        title: "تعداد",
                        field: "product",
                        headerFilter: true,
                        headerFilterPlaceholder: "جستجو",
                        sorter: "number"
                    },
                    {
                        title: "فروخته شده",
                        field: "sold",
                        headerFilter: true,
                        headerFilterPlaceholder: "جستجو"
                    },
                    {
                        title: "تعداد جنس فعلی",
                        field: "result",
                    },
                ],
                ajaxURL: "./app/Controllers/products.php", //ajax URL
                ajaxParams: {
                    getproductsDetails: "true"
                }, //ajax parameters
            });

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')
            var toast = new bootstrap.Toast(document.getElementById("toast"));
            var toastP = new bootstrap.Toast(document.getElementById("toastP"));

            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        event.preventDefault()
                        event.stopPropagation()
                        if (!form.checkValidity()) {
                            form.classList.add('was-validated');
                        } else {
                            //  Add New Product
                            if ($(form).attr('id') == "addProductform") {
                                $(form).children("div.col-12").children("#btnaddProduct").addClass("d-none");
                                $(form).children("div.col-12").children("#loading").removeClass("d-none");
                                formdata = $(form).serialize();
                                $.post("./app/Controllers/products.php", {
                                    data: formdata
                                }, function(res) {
                                    console.log(res);
                                    if (res > 0) {
                                        $(form).children("div.col-12").children("#btnaddProduct").removeClass("d-none");
                                        $(form).children("div.col-12").children("#loading").addClass("d-none");
                                        myModalProduct.hide();
                                        toastP.show();
                                    }
                                })
                            }

                            //  Add New Sale
                            if ($(form).attr('id') == "addsaleform") {
                                $(form).children("div.col-12").children("#btnadd").addClass("d-none");
                                $(form).children("div.col-12").children("#loading").removeClass("d-none");
                                formdata = $(form).serialize();
                                $.post("./app/Controllers/sales.php", {
                                    data: formdata
                                }, function(res) {
                                    console.log(res);
                                    if (res > 0) {
                                        $(form).children("div.col-12").children("#btnadd").removeClass("d-none");
                                        $(form).children("div.col-12").children("#loading").addClass("d-none");
                                        myModal.hide();
                                        toast.show();
                                        table.replaceData("./app/Controllers/sales.php");
                                    }
                                })
                            }
                        }
                    }, false)
                });
        });
    </script>
</body>

</html>