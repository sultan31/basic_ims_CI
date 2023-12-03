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
<h4>Add Category</h4>
<h6>Create new Category</h6>
</div>
</div>

<form action="<?php echo isset($edit_data[0]['id']) ? base_url().'products/form_action/'.$edit_data[0]['id'] : base_url().'products/form_action';?>" method="post" enctype="multipart/form-data" id="product_form">
<div class="card">

<div class="card-body">
    <div class="row">

    	<div class="col-lg-3 col-sm-6 col-12">
			<div class="form-group">
			<label>Category <span style="color:red;">*</span></label>
			<select class="select" id="category_id" name="category_id">
			<option value="">Choose Category</option>
			<?php
				$category = $this->db->select('id, category_name')->get_where('category')->result_array();
				if(!empty($category))
				{
					foreach ($category as $key => $value) 
					{
                        $selected = isset($edit_data[0]['category_id']) && $edit_data[0]['category_id'] == $value['id'] ? 'selected' : '';
						echo '<option value="'.$value['id'].'" '.$selected.'>'.$value['category_name'].'</option>';
					}
					
				}
			?>
			
			</select>
			</div>
		</div>

        <div class="col-lg-3 col-sm-6 col-12">
            <div class="form-group">
            <label>Sub Category <span style="color:red;">*</span></label>
            <select class="select" id="sub_category_id" name="sub_category_id">
                <option value="">Choose Sub Category</option>

            </select>
            </div>
        </div>
<div class="col-lg-3 col-sm-6 col-12">
<div class="form-group">
<label>Brand</label>
<select class="select" id="brand_id" name="brand_id">
<option value="">Choose Brand</option>
            <?php
                $brand = $this->db->select('id, brand_name')->get_where('brand')->result_array();
                if(!empty($brand))
                {
                    foreach ($brand as $key => $value) 
                    {
                        $selected = isset($edit_data[0]['brand_id']) && $edit_data[0]['brand_id'] == $value['id'] ? 'selected' : '';
                        echo '<option value="'.$value['id'].'" '.$selected.'>'.$value['brand_name'].'</option>';
                    }
                    
                }
            ?>
</select>
</div>
</div>


<div class="col-lg-3 col-sm-6 col-12">
<div class="form-group">
<label>Product Name</label>
<input type="text" class="form-control" name="product_name" id="product_name" placeholder="Product Name" value="<?php echo isset($edit_data[0]['product_name']) ? $edit_data[0]['product_name'] : '';?>">
</div>
</div>

<div class="col-lg-3 col-sm-6 col-12">
<div class="form-group">
<label>HSN Code</label>
<input type="text" class="form-control" name="hsn_code" id="hsn_code" placeholder="HSN Code" value="<?php echo isset($edit_data[0]['hsn_code']) ? $edit_data[0]['hsn_code'] : '';?>">
</div>
</div>


<div class="col-lg-3 col-sm-6 col-12">
<div class="form-group">
<label>Quantity</label>
<input type="text" class="form-control" name="quantity" id="quantity" placeholder="Quantity" value="<?php echo isset($edit_data[0]['quantity']) ? $edit_data[0]['quantity'] : '1';?>" readonly>
</div>
</div>

<div class="col-lg-3 col-sm-6 col-12">
<div class="form-group">
<label>Unit</label>
<input type="text" class="form-control" name="unit" id="unit" placeholder="Unit" value="<?php echo isset($edit_data[0]['unit']) ? $edit_data[0]['unit'] : '';?>">
</div>

</div>

<div class="col-lg-3 col-sm-6 col-12">
<div class="form-group">
<label>Price</label>
<input type="text" class="form-control" name="price" id="price" placeholder="Price" value="<?php echo isset($edit_data[0]['price']) ? $edit_data[0]['price'] : '';?>">
</div>
</div>

<div class="col-lg-6 col-sm-6 col-12">
<div class="form-group">
<label>Description</label>
<textarea class="form-control" name="description" id="description" placeholder="Description"><?php echo isset($edit_data[0]['description']) ? $edit_data[0]['description'] : '';?></textarea>
</div>
</div>



<div class="col-lg-6 col-sm-6 col-12">
<div class="custom-file-container" data-upload-id="myFirstImage">
<label>Category Logo <a href="javascript:void(0)" class="custom-file-container__image-clear" title="Clear Image">x</a></label>
<label class="custom-file-container__custom-file">
<input type="file" class="custom-file-container__custom-file__custom-file-input" accept="image/*" name="image" id="image">
<input type="hidden" name="MAX_FILE_SIZE" value="10485760" />
<input type="hidden" name="saved_image" value="<?php echo isset($edit_data[0]['image']) && !empty($edit_data[0]['image']) ? $edit_data[0]['image'] : '';?>" />
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