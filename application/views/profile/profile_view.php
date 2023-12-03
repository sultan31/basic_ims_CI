<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
<meta name="description" content="POS - Bootstrap Admin Template">
<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects">
<meta name="author" content="Dreamguys - Bootstrap Admin Template">
<meta name="robots" content="noindex, nofollow">
<title>Dreams Pos admin template</title>

<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>assets/img/favicon.jpg">

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/animate.css">

<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/select2/css/select2.min.css">

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/dataTables.bootstrap4.min.css">

<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/fontawesome/css/fontawesome.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/fontawesome/css/all.min.css">

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
<style type="text/css">
     .table-responsive {
         overflow-x: hidden;
     }
</style>
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
<div class="page-header">
<div class="page-title">
<h4>Profile</h4>
<h6>User Profile</h6>
</div>
</div>

<form action="<?php echo base_url().'profile/form_action/'.$id;?>" method="post" enctype="multipart/form-data">

<div class="card">
<div class="card-body">
<div class="profile-set">
<div class="profile-head">
</div>
<div class="profile-top">
<div class="profile-content">
<div class="profile-contentimg">
<img src="<?php echo $user_data[0]['user_photo'] != '' ? base_url().$this->config->item('upload_url').'/'.$this->config->item('profile_upload_url').'/'.$user_data[0]['user_photo'] : base_url().'assets/img/customer/customer5.jpg';?>" alt="img" id="blah">
<div class="profileupload">
<input type="file" id="imgInp" name="user_photo">
<a href="javascript:void(0);"><img src="<?php echo base_url();?>assets/img/icons/edit-set.svg" alt="img"></a>
</div>
</div>
<div class="profile-contentname">
<h2><?php echo $this->session->userdata('full_name');?></h2>
<h4>Updates Your Photo and Personal Details.</h4>
</div>
</div>

</div>
</div>
<div class="row">
<div class="col-lg-6 col-sm-12">
<div class="form-group">
<label>First Name</label>
<input type="text" placeholder="First Name" name="first_name" value="<?php echo $user_data[0]['first_name'];?>">
</div>
</div>
<div class="col-lg-6 col-sm-12">
<div class="form-group">
<label>Last Name</label>
<input type="text" placeholder="Last Name" name="last_name" value="<?php echo $user_data[0]['last_name'];?>">
</div>
</div>
<div class="col-lg-6 col-sm-12">
<div class="form-group">
<label>Email</label>
<input type="text" placeholder="Email" name="email" value="<?php echo $user_data[0]['email'];?>">
</div>
</div>
<div class="col-lg-6 col-sm-12">
<div class="form-group">
<label>Phone</label>
<input type="text" placeholder="Phone" name="mobile_no" value="<?php echo $user_data[0]['mobile_no'];?>">
</div>
</div>

<div class="col-lg-6 col-sm-12">
<div class="form-group">
<label>Password</label>
<div class="pass-group">
<input type="password" class=" pass-input" placeholder="Password" name="password" value="<?php echo $user_data[0]['password'];?>">
<span class="fas toggle-password fa-eye-slash"></span>
</div>
</div>
</div>
<div class="col-12">
<button class="btn btn-primary" type="submit">Submit</button>

</div>
</div>
</div>
</div>

</form>

</div>
</div>
</div>


<script src="<?php echo base_url();?>assets/js/jquery-3.6.0.min.js"></script>

<script src="<?php echo base_url();?>assets/js/feather.min.js"></script>

<script src="<?php echo base_url();?>assets/js/jquery.slimscroll.min.js"></script>

<script src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/js/dataTables.bootstrap4.min.js"></script>

<script src="<?php echo base_url();?>assets/js/bootstrap.bundle.min.js"></script>

<script src="<?php echo base_url();?>assets/plugins/select2/js/select2.min.js"></script>

<script src="<?php echo base_url();?>assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/sweetalert/sweetalerts.min.js"></script>

<script src="<?php echo base_url();?>assets/js/script.js"></script>
</body>
</html>