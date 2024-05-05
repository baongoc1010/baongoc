<?php
    session_start();
    include("../connection.php"); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>shopping cart - Bootdey.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style type="text/css">
        .img-cart {
            display: block;
            max-width: 100px;
            height: auto;
            margin-left: auto;
            margin-right: auto;
        }
        table tr th{
            text-align: center;
        }
        table tr td {
            border: 1px solid #FFFFFF;
            text-align: center;
        }
        .table>tbody>tr>td{
            vertical-align: middle;
        }

        table tr th {
            background: #eee;
        }
        h3{
            font-weight: 600;
        }
        .panel-shadow {
            box-shadow: rgba(0, 0, 0, 0.3) 7px 7px 7px;
        }
        .info-form{
            padding: 10px;
            background: #f1f1f1;
            border-radius: 20px;
        }
        .info-form .delivery-wrapper{
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: #FFFFFF;
            border-radius: 10px;
        }
        .delivery-wrapper .method{
            display: flex;
            align-items: center;
        }
        .delivery-wrapper h4{
            margin-left: 10px;
            font-weight: 600;
        }
        .mb{
            margin-bottom: 20px;
            padding: 10px;
        }
        .order-info{
            padding: 10px;
        }
        .order-info div{
            display: block;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            margin: 10px 0;
            color: #31708f;
        }
        .order-info div span{
            color: #000;
            font-weight: bold;
        }
    </style>
</head>

<body>
    
    <div class="container bootstrap snippets bootdey">
        <div class="col-md-12 col-sm-8 content">
            <div class="row">
                <div class="col-md-12">
                    <ol class="breadcrumb">
                        <li><a href="../trangchu.php">Trang chủ</a></li>
                        <li class="active">Chi tiết đơn hàng</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info panel-shadow">
                        <div class="panel-heading">
                            <?php
                                $nguoidat = $_SESSION['name'];
                                $sql = "SELECT * FROM dondathang WHERE Nguoidathang = '$nguoidat'";
                                $result = mysqli_query($connect, $sql);
                                $row = $result->fetch_assoc();
                                
                             ?>
                            <h3>
                                Đơn đặt hàng : #<?= $row['Sohoadon'] ?>
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr> 
                                            <th>Sản phẩm</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Số lượng</th>
                                            <th>Giá</th>
                                            <th>Tạm tính</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                                $total_products = 0;
                                                $total_quantity = 0;
                                                $total_price = 0;
                                                if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
                                                    foreach($_SESSION['cart'] as $key => $products){
                                                        $masp = $products[0];
                                                        $hinhanh = $products[1];
                                                        $tensp = $products[2];
                                                        $gia = $products[3];
                                                        $soluong = $products[4];
                                                // Tính tổng số sản phẩm
                                                $total_products++;

                                                // Tính tổng số lượng
                                                $total_quantity += $soluong;

                                                // Tính tổng tiền cho từng sản phẩm
                                                $product_total_price = $gia * $soluong;

                                                // Tính tổng tiền của toàn bộ đơn hàng
                                                $total_price += $product_total_price;
                                            ?>
                                            <tr>
                                                <td><img src="../images/<?= $hinhanh ?>" class="img-cart"></td>
                                                <td><strong><?= $tensp ?></strong></td>
                                                <td>
                                                    <div class="form-inline">
                                                        <input class="form-control" type="text" value="<?= $soluong ?>" min="1" name = "quantity" readonly>
                                                    </div>
                                                </td>
                                                <td><?= number_format((int)$gia, 0, ".", ".") ?>đ</td>
                                                <td><?= number_format($product_total_price, 0, ".", ".") ?>đ</td>
                                            </tr>
                                            <?php
                                                }
                                            } else {
                                                // Hiển thị thông báo khi giỏ hàng trống
                                                echo '<tr><td colspan="5">Giỏ hàng trống</td></tr>';
                                            }
                                            ?>
                                    </tbody>
                                </table>
                                <div class="order-info">
                                    <div>Ngày đặt hàng : <span><?= $row['ngaydathang'] ?></span></div>
                                    <div>Họ tên người đặt : <span><?= $row['Nguoidathang'] ?></span></div>
                                    <div>Số điện thoại : <span><?= $row['SDT'] ?></span></div>
                                    <div>Địa chỉ: <span><?= $row['diachi'] ?></span></div>
                                    <div>Hình thức nhận hàng : <span><?= $row['phuongthuc'] ?></span></div>
                                </div>
                            </div>
                        </div>
                        <a href="../trangchu.php" class="btn btn-success mb"><span class="glyphicon glyphicon-arrow-left"></span>&nbsp;Tiếp tục mua hàng</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javascript">

    </script>
</body>

</html>







