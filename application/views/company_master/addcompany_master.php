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
    #listOfEntries tbody tr td{white-space:normal;}
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
<h4>Edit company</h4>

</div>
</div>

<form action="<?php echo isset($edit_data[0]['id']) ? base_url().'company/form_action/'.$edit_data[0]['id'] : base_url().'company/form_action';?>" method="post" enctype="multipart/form-data" id="product_form">
<div class="card">

<div class="card-body">
    <div class="row">

    <div class="col-lg-3 col-sm-6 col-12">
<div class="form-group">
<label>Company Name</label>
<input type="text" class="form-control" name="name" id="name" placeholder="Company Name" value="<?php echo isset($edit_data[0]['name']) ? $edit_data[0]['name'] : '';?>">
</div>
</div>

        <div class="col-lg-3 col-sm-6 col-12">
<div class="form-group">
<label>Tag line</label>
<input type="text" class="form-control" name="tagline" id="tagline" placeholder="Tag line" value="<?php echo isset($edit_data[0]['tagline']) ? $edit_data[0]['tagline'] : '';?>">
</div>
</div>
       
<div class="col-lg-3 col-sm-6 col-12">
<div class="form-group">
<label>Mobile No</label>
<input type="text" class="form-control" name="phone" id="phone" placeholder="Mobile No" value="<?php echo isset($edit_data[0]['phone']) ? $edit_data[0]['phone'] : '';?>">
</div>
</div>

<div class="col-lg-3 col-sm-6 col-12">
<div class="form-group">
<label>Email</label>
<input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo isset($edit_data[0]['email']) ? $edit_data[0]['email'] : '';?>">
</div>
</div>

<div class="col-lg-3 col-sm-6 col-12">
<div class="form-group">
<label>GST No</label>
<input type="text" class="form-control" name="gst_no" id="gst_no" placeholder="GST No" value="<?php echo isset($edit_data[0]['gst_no']) ? $edit_data[0]['gst_no'] : '';?>">
</div>
</div>

<div class="col-lg-4 col-sm-4 col-12">
<div class="form-group">
<label>Office Address</label>
<textarea class="form-control" name="office_address" id="office_address" placeholder="Office Address"><?php echo isset($edit_data[0]['office_address']) ? $edit_data[0]['office_address'] : '';?></textarea>
</div>
</div>

<div class="col-lg-4 col-sm-4 col-12">
<div class="form-group">
<label>Showroom Address</label>
<textarea class="form-control" name="showroom_address" id="showroom_address" placeholder="Showroom Address"><?php echo isset($edit_data[0]['showroom_address']) ? $edit_data[0]['showroom_address'] : '';?></textarea>
</div>
</div>

<div class="col-lg-6 col-sm-6 col-12">
<div class="custom-file-container" data-upload-id="myFirstImage">
<label>Company Logo <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
<label class="custom-file-container__custom-file">
<input type="file" class="custom-file-container__custom-file__custom-file-input" accept="image/*" name="company_logo" id="company_logo">
<input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
<input type="hidden" name="saved_company_logo" value="<?php echo isset($edit_data[0]['company_logo']) && !empty($edit_data[0]['company_logo']) ? $edit_data[0]['company_logo'] : '';?>" />
<span class="custom-file-container__custom-file__custom-file-control"></span>
</label>
<div class="custom-file-container__image-preview"></div>
</div>
</div>





<div class="col-lg-6 col-sm-6 col-12">
<div class="custom-file-container" data-upload-id="mySecondImage">
<label>QR Code <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
<label class="custom-file-container__custom-file">
<input type="file" class="custom-file-container__custom-file__custom-file-input" accept="image/*" name="qr_code" id="qr_code">

<input type="hidden" name="saved_qr_code" value="<?php echo isset($edit_data[0]['qr_code']) && !empty($edit_data[0]['qr_code']) ? $edit_data[0]['qr_code'] : '';?>" />
<span class="custom-file-container__custom-file__custom-file-control"></span>
</label>
<div class="custom-file-container__image-preview"></div>
</div>
</div>

<div class="col-lg-12">
    <div class="text-end">
<button type="submit" class="btn btn-primary">Submit</button>
</div>

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
    $('#product_form').validate({
  rules: {
  	category_id:'required',
    product_name: 'required',
    sub_category_id: 'required',
    brand_id: 'required',
    sku_code: 'required',
    price: 'required',
    // image: 'required',
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
  	category_id: 'This field is required',
    product_name: 'This field is required',
    sub_category_id: 'This field is required',
    brand_id: 'This field is required',
    sku_code: 'This field is required',
    price: 'This field is required',
    // image: 'This field is required',
    // user_email: 'Enter a valid email',
    // psword: {
    //   minlength: 'Password must be at least 8 characters long'
    // }
  },
  submitHandler: function(form) {
    form.submit();
  }
});


    $('#category_id').change(function(){
        if($(this).val() != '')
        {
            var category_id = $(this).val();
            $.ajax({
                url: "<?php echo base_url();?>products/fetch_sub_cat",
                type: "POST",
                data: {
                    category_id: category_id
                },
                
                cache: false,
                async:false,
                success:function(response) 
                {
                    var json = JSON.parse(response);
                    
                    if(Object.keys(json).length > 0)
                    {
                        var html = '';

                        $.each(json, function(key ,value){
                            html += '<option value="'+value.id+'">'+value.sub_category_name+'</option>';
                        });

                        $('#sub_category_id').append(html);
                        <?php
                            if(isset($edit_data[0]['sub_category_id']))
                            {
                                ?>
                                    var sub_category_id = '<?php echo $edit_data[0]['sub_category_id'];?>';
                                    $("#sub_category_id").val(sub_category_id).change();
                                <?php
                            }
                        ?>
                    }
                }
            });
        }
    });

    $(document).ready(function(){
        <?php
            if(isset($edit_data[0]['category_id']))
            {
                ?>
                    var category_id = '<?php echo $edit_data[0]['category_id'];?>';
                    $('#category_id').trigger('change');
                <?php
            }
        ?>
    });
</script>

</body>
</html>