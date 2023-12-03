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

<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/select2/css/select2.min.css">

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/animate.css">

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/dataTables.bootstrap4.min.css">

<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/fontawesome/css/fontawesome.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/fontawesome/css/all.min.css">

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
<style type="text/css">
    .error{color: #ff0000!important;}
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
<h4>Add Brand</h4>
<h6>Create new Brand</h6>
</div>
</div>

<form action="<?php echo isset($edit_data[0]['id']) ? base_url().'brand/form_action/'.$edit_data[0]['id'] : base_url().'brand/form_action';?>" method="post" enctype="multipart/form-data" id="brand_form">
<div class="card">

<div class="card-body">
    <div class="row">

        <div class="col-lg-6 col-sm-6 col-12">
<div class="form-group">
<label>Brand Name <span style="color:red;">*</span></label>
<input type="text" name="brand_name" id="brand_name" value="<?php echo isset($edit_data[0]['brand_name']) ? $edit_data[0]['brand_name'] : '';?>" placeholder="Brand Name">
</div>
</div>

<div class="col-lg-6 col-sm-6 col-12">
<div class="form-group">
<label>Description</label>
<textarea class="form-control" name="description" id="description" value="<?php echo isset($edit_data[0]['description']) ? $edit_data[0]['description'] : '';?>" placeholder="Description"></textarea>
</div>
</div>


<div class="col-lg-6 col-sm-6 col-12">
<div class="custom-file-container" data-upload-id="myFirstImage">
<label>Brand Logo <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
<label class="custom-file-container__custom-file">
<input type="file" class="custom-file-container__custom-file__custom-file-input" accept="image/*" name="brand_logo" id="brand_logo">
<input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
<input type="hidden" name="saved_brand_logo" value="<?php echo isset($edit_data[0]['brand_logo']) && !empty($edit_data[0]['brand_logo']) ? $edit_data[0]['brand_logo'] : '';?>" />
<span class="custom-file-container__custom-file__custom-file-control"></span>
</label>
<div class="custom-file-container__image-preview"></div>
</div>
</div>

<div class="col-lg-12">
    <div class="text-end">
<button type="submit" class="btn btn-primary">Submit</button>
</div>
<!-- <a href="javascript:void(0);" class="btn btn-submit me-2">Submit</a>
<a href="categorylist.html" class="btn btn-cancel">Cancel</a> -->
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

<script src="<?php echo base_url();?>assets/plugins/select2/js/select2.min.js"></script>

<script src="<?php echo base_url();?>assets/plugins/fileupload/fileupload.min.js"></script>

<script src="<?php echo base_url();?>assets/js/bootstrap.bundle.min.js"></script>

<script src="<?php echo base_url();?>assets/js/script.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>

<script type="text/javascript">
    $('#brand_form').validate({
  rules: {
    brand_name: 'required',
    
    // user_email: {
    //   required: true,
    //   email: true,
    // },
    // psword: {
    //   required: true,
    //   minlength: 8,
    // }
  },
  messages: {
    brand_name: 'This field is required',
    
    // user_email: 'Enter a valid email',
    // psword: {
    //   minlength: 'Password must be at least 8 characters long'
    // }
  },
  submitHandler: function(form) {
    form.submit();
  }
});
</script>

</body>
</html>