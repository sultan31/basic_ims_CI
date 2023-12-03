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
<h4>Product List</h4>
<h6>Manage your products</h6>
</div>
<div class="page-btn">
<a href="<?php echo base_url();?>products/addproduct" class="btn btn-added"><img src="<?php echo base_url();?>assets/img/icons/plus.svg" alt="img" class="me-1">Add New Product</a>
</div>
</div>

<div class="card">
<div class="card-body">
<div class="table-top">
<div class="search-set">
<div class="search-path">
<a class="btn btn-filter" id="filter_search">
<img src="<?php echo base_url();?>assets/img/icons/filter.svg" alt="img">
<span><img src="<?php echo base_url();?>assets/img/icons/closes.svg" alt="img"></span>
</a>
</div>
<div class="search-input">
<a class="btn btn-searchset"><img src="<?php echo base_url();?>assets/img/icons/search-white.svg" alt="img"></a>
</div>
</div>
<div class="wordset">
<ul>
<li>
<a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf"><img src="<?php echo base_url();?>assets/img/icons/pdf.svg" alt="img"></a>
</li>
<li>
<a data-bs-toggle="tooltip" data-bs-placement="top" title="excel"><img src="<?php echo base_url();?>assets/img/icons/excel.svg" alt="img"></a>
</li>
<li>
<a data-bs-toggle="tooltip" data-bs-placement="top" title="print"><img src="<?php echo base_url();?>assets/img/icons/printer.svg" alt="img"></a>
</li>
</ul>
</div>
</div>



<div class="table-responsive">
<table class="table" id="listOfEntries">
<thead>
<tr>
<th>
<label class="checkboxs">
<input type="checkbox" id="select-all">
<span class="checkmarks"></span>
</label>
</th>
<th>Product Name</th>
<th>HSN Code</th>
<th>Category </th>
<!-- th>Sub category </th>
 -->
<th>price</th>
<th>Qty</th>
<th>Unit</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<!-- <tr>
    <td>
        <label class="checkboxs">
        <input type="checkbox">
        <span class="checkmarks"></span>
        </label>
    </td>
    <td class="productimgname">
        <a href="javascript:void(0);" class="product-img">
        <img src="<?php echo base_url();?>assets/img/product/product1.jpg" alt="product">
        </a>
        <a href="javascript:void(0);">Macbook pro</a>
    </td>
    <td>PT001</td>
    <td>Computers</td>
    <td>N/D</td>
    <td>1500.00</td>
    
    <td>100.00</td>
    
    <td>
        <a class="me-3" href="product-details.html">
        <img src="<?php echo base_url();?>assets/img/icons/eye.svg" alt="img">
        </a>
        <a class="me-3" href="editproduct.html">
        <img src="<?php echo base_url();?>assets/img/icons/edit.svg" alt="img">
        </a>
        <a class="confirm-text" href="javascript:void(0);">
        <img src="<?php echo base_url();?>assets/img/icons/delete.svg" alt="img">
        </a>
    </td>
</tr> -->

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

<script src="<?php echo base_url();?>assets/plugins/select2/js/select2.min.js"></script>

<script src="<?php echo base_url();?>assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/sweetalert/sweetalerts.min.js"></script>

<script src="<?php echo base_url();?>assets/js/script.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var dataTable = $('#listOfEntries').DataTable({  
           "processing":true,  
           "serverSide":true,  
           "order":[],  
           "ajax":{  
                url:"<?php echo base_url('products/fetch_records'); ?>",  
                type:"POST"  
           },  
           "columnDefs":[  
                {  
                     "targets":[0,1,2, 3, 4,5,6, 7],  
                     "orderable":false,  
                },  
           ], 
           // dom: 'Bfrtip',
           // sDom:'Rfrtlip',



             buttons: [
                 'pageLength','copy', 'csv', 'excel', 'pdf', 'print'
             ] 
      });


    });

     function remove_record(id)
     {
          Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          console.log(result);
            if (result.value) {

               
          
                 $.ajax({
                      type: "POST",
                      url: "<?php echo base_url('products/removeproduct'); ?>",
                      data: {'id':id,},
                      success: function (resData) {
                         var json = JSON.parse(resData);
                         
                         if(json.status == 1){
                              Swal.fire({
                                     title: 'Success!',
                                     text: json.message,
                                     type: 'success',
                                     showCancelButton: true,
                                     showConfirmButton: false,
                                     // confirmButtonColor: '#3085d6',
                                     cancelButtonColor: '#d33',
                                     cancelButtonText: 'Close'
                                 })
                             $('#listOfEntries').DataTable().ajax.reload(); 
                         }
                         
                      }
                  }); 
            }
        });
          
     }
</script>
</body>
</html>