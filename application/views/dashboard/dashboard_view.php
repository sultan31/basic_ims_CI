<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<meta name="description" content="POS - Bootstrap Admin Template">
<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive">
<meta name="author" content="Dreamguys - Bootstrap Admin Template">
<meta name="robots" content="noindex, nofollow">
<title>Dreams Pos admin template</title>

<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>assets/img/favicon.jpg">

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/animate.css">

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/dataTables.bootstrap4.min.css">

<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/fontawesome/css/fontawesome.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/fontawesome/css/all.min.css">

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
</head>
<body>
<div id="global-loader">
<div class="whirly-loader"> </div>
</div>

<div class="main-wrapper">

<?php $this->load->view('common/header');?>


<?php $this->load->view('common/sidebar');?>

<div class="page-wrapper">
<div class="content">
<div class="row">
<div class="col-lg-3 col-sm-6 col-12">
<div class="dash-widget">
<div class="dash-widgetimg">
<span><img src="<?php echo base_url();?>assets/img/icons/dash1.svg" alt="img"></span>
</div>
<div class="dash-widgetcontent">
<h5><i class="fa fa-inr"></i><span class="counters" data-count="307144.00">307,144.00</span></h5>
<h6>Total Purchase Due</h6>
</div>
</div>
</div>
<div class="col-lg-3 col-sm-6 col-12">
<div class="dash-widget dash1">
<div class="dash-widgetimg">
<span><img src="<?php echo base_url();?>assets/img/icons/dash2.svg" alt="img"></span>
</div>
<div class="dash-widgetcontent">
<h5><span class="counters" data-count="4385.00">4,385.00</span></h5>
<h6>Total Sales Due</h6>
</div>
</div>
</div>
<div class="col-lg-3 col-sm-6 col-12">
<div class="dash-widget dash2">
<div class="dash-widgetimg">
<span><img src="<?php echo base_url();?>assets/img/icons/dash3.svg" alt="img"></span>
</div>
<div class="dash-widgetcontent">
    <?php
        $total_due_amount = $this->db->query('SELECT SUM(`due_amount`) as total_due_amount FROM `sale`')->row_array()['total_due_amount'];
    ?>
<h5><span class="counters" data-count="<?php echo $total_due_amount;?>"><?php echo $total_due_amount;?></span></h5>
<h6>Total Sale Due</h6>
</div>
</div>
</div>
<div class="col-lg-3 col-sm-6 col-12">
<div class="dash-widget dash3">
<div class="dash-widgetimg">
<span><img src="<?php echo base_url();?>assets/img/icons/dash4.svg" alt="img"></span>
</div>
<div class="dash-widgetcontent">
    <?php
        $total_sale_amount = $this->db->query('SELECT SUM(`grand_total`) as total_sale_amount FROM `sale`')->row_array()['total_sale_amount'];
    ?>
<h5><span class="counters" data-count="<?php echo $total_sale_amount;?>"><?php echo $total_sale_amount;?></span></h5>
<h6>Total Sale Amount</h6>
</div>
</div>
</div>
<div class="col-lg-3 col-sm-6 col-12 d-flex">
<div class="dash-count">
<div class="dash-counts">
<h4><?php echo $this->db->select('id')->get('customer')->num_rows();?></h4>
<h5>Customers</h5>
</div>
<div class="dash-imgs">
<i data-feather="user"></i>
</div>
</div>
</div>
<div class="col-lg-3 col-sm-6 col-12 d-flex">
<div class="dash-count das1">
<div class="dash-counts">
<h4>100</h4>
<h5>Suppliers</h5>
</div>
<div class="dash-imgs">
<i data-feather="user-check"></i>
</div>
</div>
</div>
<div class="col-lg-3 col-sm-6 col-12 d-flex">
<div class="dash-count das2">
<div class="dash-counts">
<h4>100</h4>
<h5>Purchase Invoice</h5>
</div>
<div class="dash-imgs">
<i data-feather="file-text"></i>
</div>
</div>
</div>
<div class="col-lg-3 col-sm-6 col-12 d-flex">
<div class="dash-count das3">
<div class="dash-counts">
<h4><?php echo $this->db->select('id')->get('sale')->num_rows();?></h4>
<h5>Sales Invoice</h5>
</div>
<div class="dash-imgs">
<i data-feather="file"></i>
</div>
</div>
</div>
</div>

<div class="row">
<div class="col-lg-7 col-sm-12 col-12 d-flex">
<div class="card flex-fill">
<div class="card-header pb-0 d-flex justify-content-between align-items-center">
<h5 class="card-title mb-0">Purchase & Sales</h5>
<div class="graph-sets">
<ul>
<li>
<span>Sales</span>
</li>
<li>
<span>Purchase</span>
</li>
</ul>
<div class="dropdown">
<button class="btn btn-white btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
 2022 <img src="<?php echo base_url();?>assets/img/icons/dropdown.svg" alt="img" class="ms-2">
</button>
<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
<li>
<a href="javascript:void(0);" class="dropdown-item">2022</a>
</li>
<li>
<a href="javascript:void(0);" class="dropdown-item">2021</a>
</li>
<li>
<a href="javascript:void(0);" class="dropdown-item">2020</a>
</li>
</ul>
</div>
</div>
</div>
<div class="card-body">
<div id="sales_charts"></div>
</div>
</div>
</div>
<div class="col-lg-5 col-sm-12 col-12 d-flex">
<div class="card flex-fill">
<div class="card-header pb-0 d-flex justify-content-between align-items-center">
<h4 class="card-title mb-0">Recently Added Products</h4>
<div class="dropdown">
<a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false" class="dropset">
<i class="fa fa-ellipsis-v"></i>
</a>
<ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
<li>
<a href="<?php echo base_url();?>products" class="dropdown-item">Product List</a>
</li>
<li>
<a href="<?php echo base_url();?>products/addproduct" class="dropdown-item">Product Add</a>
</li>
</ul>
</div>
</div>
<div class="card-body">
<div class="table-responsive dataview">
<table class="table datatable ">
<thead>
<tr>
<th>Sno</th>
<th>Products</th>
<th>Price</th>
</tr>
</thead>
<tbody>
    <?php
       $products = $this->db->query('SELECT id, product_name, price, image FROM `products` ORDER BY id DESC LIMIT 5');
       if($products->num_rows() > 0)
       {
            $products = $products->result_array();
            $counter = 0;
            foreach($products as $p)
            {
                $counter++;
                $image = !empty($p['image']) ? '<img src="'.base_url().$this->config->item('upload_url').'/'.$this->config->item('product_upload_url').'/'.$p['image'].'" alt="'.$p['product_name'].'_'.$p['id'].'">' : '';
                echo '<tr>
                <td>'.$counter.'</td>
                <td class="productimgname">
                <a href="'.base_url().'products" class="product-img">
                '.$image.'
                </a>
                <a href="'.base_url().'products">'.$p['product_name'].'</a>
                </td>
                <td>'.$p['price'].'</td>
                </tr>';
            }
       }
    ?>
    <!-- <tr>
    <td>1</td>
    <td class="productimgname">
    <a href="productlist.html" class="product-img">
    <img src="<?php echo base_url();?>assets/img/product/product22.jpg" alt="product">
    </a>
    <a href="productlist.html">Apple Earpods</a>
    </td>
    <td>$891.2</td>
    </tr> -->
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
<div class="card mb-0">
<div class="card-body">
<h4 class="card-title">Expired Products</h4>
<div class="table-responsive dataview">
<table class="table datatable ">
<thead>
<tr>
<th>SNo</th>
<th>Product Code</th>
<th>Product Name</th>
<th>Brand Name</th>
<th>Category Name</th>
<th>Expiry Date</th>
</tr>
</thead>
<tbody>
<tr>
<td>1</td>
<td><a href="javascript:void(0);">IT0001</a></td>
<td class="productimgname">
<a class="product-img" href="productlist.html">
<img src="<?php echo base_url();?>assets/img/product/product2.jpg" alt="product">
</a>
<a href="productlist.html">Orange</a>
</td>
<td>N/D</td>
<td>Fruits</td>
<td>12-12-2022</td>
</tr>
<tr>
<td>2</td>
<td><a href="javascript:void(0);">IT0002</a></td>
<td class="productimgname">
<a class="product-img" href="productlist.html">
<img src="<?php echo base_url();?>assets/img/product/product3.jpg" alt="product">
</a>
<a href="productlist.html">Pineapple</a>
</td>
<td>N/D</td>
<td>Fruits</td>
<td>25-11-2022</td>
</tr>
<tr>
<td>3</td>
<td><a href="javascript:void(0);">IT0003</a></td>
<td class="productimgname">
<a class="product-img" href="productlist.html">
<img src="<?php echo base_url();?>assets/img/product/product4.jpg" alt="product">
</a>
<a href="productlist.html">Stawberry</a>
</td>
<td>N/D</td>
<td>Fruits</td>
<td>19-11-2022</td>
</tr>
<tr>
<td>4</td>
<td><a href="javascript:void(0);">IT0004</a></td>
<td class="productimgname">
<a class="product-img" href="productlist.html">
<img src="<?php echo base_url();?>assets/img/product/product5.jpg" alt="product">
</a>
<a href="productlist.html">Avocat</a>
</td>
<td>N/D</td>
<td>Fruits</td>
<td>20-11-2022</td>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
</div>
</div>


<script src="<?php echo base_url();?>assets/js/jquery-3.6.0.min.js"></script>

<script src="<?php echo base_url();?>assets/js/feather.min.js"></script>

<script src="<?php echo base_url();?>assets/js/jquery.slimscroll.min.js"></script>

<script src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/js/dataTables.bootstrap4.min.js"></script>

<script src="<?php echo base_url();?>assets/js/bootstrap.bundle.min.js"></script>

<script src="<?php echo base_url();?>assets/plugins/apexchart/apexcharts.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/apexchart/chart-data.js"></script>

<script src="<?php echo base_url();?>assets/js/script.js"></script>
</body>
</html>