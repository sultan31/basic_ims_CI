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

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-datetimepicker.min.css">

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
<h4>Add Invoice</h4>
<h6>Add your new invoice</h6>
</div>
</div>
<div class="card">
    <form action="<?php echo isset($edit_data[0]['id']) ? base_url().'sale/form_action/'.$edit_data[0]['id'] : base_url().'sale/form_action/';?>" method="post" id="sale_form">
<div class="card-body">


<div class="row">
<div class="col-lg-3 col-sm-6 col-12">
<div class="form-group">
<label>Customer <span style="color:red;">*</span></label>
<div class="row">
<div class="col-lg-10 col-sm-10 col-10">
<select class="select" name="customer_id" id="customer_id">
<option value="">Choose</option>
<?php
    $customer = $this->api_model->get_columns('customer', 'id, name');
    if(!empty($customer))
    {
        foreach($customer as $c)
        {
            $selected = isset($edit_data[0]['customer_id']) && $edit_data[0]['customer_id'] == $c['id'] ? 'selected' : '';
            echo '<option value="'.$c['id'].'" '.$selected.'>'.$c['name'].'</option>';
        }
    }
?>
</select>
</div>
<!-- <div class="col-lg-2 col-sm-2 col-2 ps-0">
<div class="add-icon">
<span><img src="<?php echo base_url();?>assets/img/icons/plus1.svg" alt="img"></span>
</div>
</div> -->
</div>
</div>
</div>
<div class="col-lg-3 col-sm-6 col-12">
<div class="form-group">
<label>Date <span style="color:red;">*</span></label>
<div class="input-groupicon">
<input type="text" placeholder="Choose Date" class="datetimepicker" name="sale_date" id="sale_date" value="<?php echo isset($edit_data[0]['sale_date']) && $edit_data[0]['sale_date'] != '' ? date('d-m-Y', strtotime($edit_data[0]['sale_date'])) : '';?>">
<a class="addonset">
<img src="<?php echo base_url();?>assets/img/icons/calendars.svg" alt="img">
</a>
</div>
</div>
</div>
<!-- <div class="col-lg-3 col-sm-6 col-12">
<div class="form-group">
<label>Supplier</label>
<select class="select">
<option>Choose</option>
<option>Supplier Name</option>
</select>
</div>
</div> -->
<!-- <div class="col-lg-12 col-sm-6 col-12">
<div class="form-group">
<label>Product Name</label>
<div class="input-groupicon">
<input type="text" placeholder="Please type product code and select...">
<div class="addonset">
<img src="<?php echo base_url();?>assets/img/icons/scanners.svg" alt="img">
</div>
</div>
</div>
</div>
 -->



</div>

<div class="row">
    <label class="col-lg-2 col-sm-2 col-2" style="text-align: right;" for="product_name">Product Name</label>
    <div class="col-lg-6 col-sm-6 col-6">
<div class="form-group">

<div class="input-groupicon">
    <select class="select" id="product_name" name="product_name">
        <option>Choose</option>
        <?php
                $products = $this->db->select('id, product_name')->get_where('products')->result_array();
                if(!empty($products))
                {
                    foreach ($products as $key => $value) 
                    {
                        echo '<option value="'.$value['id'].'">'.$value['product_name'].'</option>';
                    }
                    
                }
        ?>
    </select>
<div class="addonset">
<img src="<?php echo base_url();?>assets/img/icons/scanners.svg" alt="img">
</div>
</div>
</div>
</div>

<div class="col-lg-4 col-sm-4 col-4">
    <button class="btn btn-success" id="add_button">Add</button>
</div>
</div>

<div class="row">
<div class="table-responsive mb-3">
<table class="table">
<thead>
    <tr>
        <th>#</th>
        <th>Product Name</th>
        <th>QTY</th>
        <th>Price</th>
        <th>Unit</th>
        <th>CGST</th>
        <th>SGST</th>
        <th>Subtotal</th>
        <th>Action</th>
    </tr>
</thead>
<tbody id="table_body">
    <?php
        if(isset($sale_items) && !empty($sale_items))
        {
            $products = $this->api_model->get_columns('products', 'id, product_name,image');
            $product_names = array_column($products, 'product_name');
            $product_ids = array_column($products, 'id');
            $product_images = array_column($products, 'image');

            $counter = 0;
            foreach ($sale_items as $key => $value) 
            {
                $counter++;
                ?>

                <tr class="product_row" id="'.$value['id'].'">
                    <td><?php echo $counter;?></td>
                    <td class="productimgname">
                    <input type="hidden" name="product_id[]" value="<?php echo $value['product_id'];?>">
                    <?php
                        echo !empty($product_images[array_search($value['product_id'], $product_ids)]) ? '<a class="product-img">
                            <img src="'.base_url().$this->config->item('upload_url').'/'.$this->config->item('product_upload_url').'/'.$product_images[array_search($value['product_id'], $product_ids)].'" alt="'.$product_images[array_search($value['product_id'], $product_ids)].'">
                    </a>' : '';
                    ?>
                    
                    <a href="javascript:void(0);"><?php echo $product_names[array_search($value['product_id'], $product_ids)];?></a>
                    </td>
                    <td><input type="text" name="hsn_code[]" class="form-control hsn_code" value="<?php echo $value['hsn_code'];?>" readonly></td>
                    <td><input type="hidden" class="hidden_xQty" value="<?php echo $value['qty'];?>">
                    <input type="text" name="pQty[]" class="form-control xQty" value="<?php echo $value['qty'];?>" style="width:50px"></td>
                    <td><input type="text" name="pPrice[]" class="form-control xPrice" value="<?php echo $value['price'];?>" readonly></td>
                    <td><input type="text" name="pUnit[]" class="form-control xUnit" value="<?php echo $value['unit'];?>" readonly></td>
                    <td><input type="text" name="item_cgst[]" class="form-control item_cgst" value="<?php echo $value['item_cgst'];?>">
                            <input type="hidden" name="item_cgst_amt[]" class="form-control item_cgst_amt" value="<?php echo $value['item_cgst_amt'];?>"></td>
                    <td><input type="text" name="item_sgst[]" class="form-control item_sgst" value="<?php echo $value['item_sgst'];?>">
                            <input type="hidden" name="item_sgst_amt[]" class="form-control item_sgst_amt" value="<?php echo $value['item_sgst_amt'];?>"></td>
                    <td><input type="text" name="pAmount[]" class="form-control xAmount" readonly = "readonly" value="<?php echo $value['sub_total'];?>"></td>
                    <td>
                    <a href="javascript:void(0);" class="delete_item"><img src="<?php echo base_url().'assets/img/icons/delete.svg';?>" alt="svg"></a>
                    </td>
                </tr>
                <?php
            }
        }
        
    ?>
<!-- <tr>
    <td>1</td>
    <td class="productimgname">
    <a class="product-img">
    <img src="<?php echo base_url();?>assets/img/product/product7.jpg" alt="product">
    </a>
    <a href="javascript:void(0);">Apple Earpods</a>
    </td>
    <td>1.00</td>
    <td>15000.00</td> -->
    <!-- <td>0.00</td>
    <td>0.00</td> -->
    <!-- <td>1500.00</td>
    <td>
    <a href="javascript:void(0);" class="delete-set"><img src="<?php echo base_url();?>assets/img/icons/delete.svg" alt="svg"></a>
    </td>
</tr> -->




</tbody>
<tfoot>
                                    
                                    <tr>
                                        <td colspan="8" style="text-align:right;">CGST:</td>
                                        
                                        <td colspan="3">
                                            <input type="text" name="totalCGstTax" class="form-control totalCGstTax" readonly = "readonly" placeholder="CGST Amt" value="<?php echo isset($edit_data[0]['totalCGstTax']) ? $edit_data[0]['totalCGstTax'] : 0;?>">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="8" style="text-align:right;">SGST:</td>
                                       
                                        <td colspan="3">
                                            <input type="text" name="totalSGstTax" class="form-control totalSGstTax" readonly = "readonly" placeholder="SGST Amt" value="<?php echo isset($edit_data[0]['totalSGstTax']) ? $edit_data[0]['totalSGstTax'] : 0;?>">
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td colspan="8" style="text-align:right;">Total:</td>
                                        
                                        <td colspan="3">
                                            <input type="text" name="xTotalPay" class="form-control xTotalPay" id="xTotalPay" readonly = "readonly" placeholder="Final Amount" value="<?php echo isset($edit_data[0]['grand_total']) ? $edit_data[0]['grand_total'] : 0;?>">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="8" style="text-align:right;">Discount:</td>
                                       
                                        <td colspan="3">
                                            <input type="text" name="dAmount" id="dAmount" class="form-control dAmount" placeholder="Disc Amt" value="<?php echo isset($edit_data[0]['discount']) ? $edit_data[0]['discount'] : 0;?>">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="8" style="text-align:right;">Final Total:</td>
                                       
                                        <td colspan="3">
                                            <input type="text" name="final_total" id="final_total" class="form-control final_total" placeholder="Final Total" value="<?php echo isset($edit_data[0]['final_total']) ? $edit_data[0]['final_total'] : 0;?>">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="8" style="text-align:right;">Total Paid:</td>
                                        
                                        <td colspan="3">
                                            <input type="text" name="xTotalPaid" class="form-control xTotalPaid" id="xTotalPaid" placeholder="Total Paid Amount" value="<?php echo isset($edit_data[0]['paid_amount']) ? $edit_data[0]['paid_amount'] : 0;?>" onblur="setPaid(this.value);">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td colspan="8" style="text-align:right;">Balance:</td>
                                        
                                        <td colspan="3">
                                            <input type="text" name="xBalance" class="form-control xBalance" id="xBalance" readonly = "readonly" value="<?php echo isset($edit_data[0]['due_amount']) ? $edit_data[0]['due_amount'] : 0;?>" placeholder="Balance">
                                        </td>
                                    </tr>
                                </tfoot>
</table>
</div>
</div>
<div class="row">
    <!-- <div class="col-lg-3 col-sm-6 col-12">
    <div class="form-group">
    <label>Order Tax</label>
    <input type="text">
    </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
    <div class="form-group">
    <label>Discount</label>
    <input type="text">
    </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
    <div class="form-group">
    <label>Shipping</label>
    <input type="text">
    </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-12">
    <div class="form-group">
    <label>Status</label>
    <select class="select">
    <option>Choose Status</option>
    <option>Completed</option>
    <option>Inprogress</option>
    </select>
    </div>
    </div> -->
    <!-- <div class="row">
    <div class="col-lg-6 ">
    <div class="total-order w-100 max-widthauto m-auto mb-4">
    <ul>
    <li>
    <h4>Order Tax</h4>
    <h5>$ 0.00 (0.00%)</h5>
    </li>
    <li>
    <h4>Discount	</h4>
    <h5>$ 0.00</h5>
    </li>
    </ul>
    </div>
    </div>
    <div class="col-lg-6 ">
    <div class="total-order w-100 max-widthauto m-auto mb-4">
    <ul>
    <li>
    <h4>Shipping</h4>
    <h5>$ 0.00</h5>
    </li>
    <li class="total">
    <h4>Grand Total</h4>
    <h5>$ 0.00</h5>
    </li>
    </ul>
    </div>
    </div>
    </div> -->
<div class="col-lg-12">
<button type="submit" class="btn btn-primary">Submit</button>

</div>
</div>
</div>

</form>
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

<script src="<?php echo base_url();?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url();?>assets/js/bootstrap-datetimepicker.min.js"></script>

<script src="<?php echo base_url();?>assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/sweetalert/sweetalerts.min.js"></script>

<script src="<?php echo base_url();?>assets/js/script.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>

<script type="text/javascript">
    $('#sale_form').validate({
  rules: {
    customer_id: 'required',
    customer_id: 'required',
  },
  messages: {
    customer_id: 'This field is required',
    customer_id: 'This field is required',

  },
  submitHandler: function(form) {
    form.submit();
  }
});
</script>
<script type="text/javascript"> 
    
    $('#add_button').click(function(e){
        e.preventDefault();
        var prod_id = $('#product_name').val();
        var counter = $('#table_body tr').length + 1;
        
        $.ajax({
            url: '<?php echo base_url();?>sale/get_product_detail',
            type: 'POST',
            data: {'prod_id': prod_id, 'counter':counter},
            dataType:'json',
            success: function (result) {
            
                if(result.status == 1)
                {
                    $('#table_body').append(result.html);
                    calculate_total();
                }
                else
                {
                    alert(result.message);
                }                

            },
        });
    });

    $(document).on('click', '.delete_item', function(e){
        e.preventDefault();
        $(this).parents('tr').remove();
        calculate_total();
    });


    $(document).on('blur','.xQty, .xPrice, .item_cgst, .item_sgst',function(){

        calculate_total();
    });


    function calculate_total()
    {
        var Total_cgst_amt = 0; 
        var Total_sgst_amt = 0;
        var Total_amount = 0;
        var Total_final_amount = 0;
        $('.product_row').each(function()
        {
            
            Qty = parseFloat($(this).find('.xQty').val());
            var actual_qty = parseFloat($(this).find('.hidden_xQty').val());
            // console.log('actual_qty = '+actual_qty);
            // console.log('Qty = '+Qty);
            // if(Qty > actual_qty)
            // {
            //     alert('Qty Exceeds!');
            //     alert('Only '+parseFloat($(this).find('.hidden_xQty').val())+' Available!');
            //     return false;
            // }
                Price = $(this).find('.xPrice').val();
                cgst = parseFloat($(this).find('.item_cgst').val());
                sgst = parseFloat($(this).find('.item_sgst').val());

                Amount = Qty * Price;
                cgst_amt = (Amount * cgst) / 100;
                sgst_amt = (Amount * sgst) / 100;

                Total_cgst_amt += cgst_amt;
                Total_sgst_amt += sgst_amt;

                Gst = cgst_amt + sgst_amt;

                $(this).find('.item_cgst_amt').val(cgst_amt);
                $(this).find('.item_sgst_amt').val(sgst_amt);

                Amount = Amount + Gst;
                Amount = Math.round(Amount);
                $(this).find('.xAmount').val(parseFloat(Amount).toFixed(2));

                Total_amount += Amount;
                
                var discount_amt = parseFloat($('#dAmount').val());

                // console.log('Total_final_amount = '+Total_final_amount);
                // console.log('discount_amt = '+discount_amt);

                Total_final_amount = Total_amount - discount_amt;

                // console.log('Total_final_amount = '+Total_final_amount);

                $('.totalCGstTax').val(parseFloat(Total_cgst_amt).toFixed(2));
                $('.totalSGstTax').val(parseFloat(Total_sgst_amt).toFixed(2));
                $('.xTotalPay').val(parseFloat(Total_final_amount).toFixed(2));
                $('.final_total').val(parseFloat(Total_final_amount).toFixed(2));
                $('#xBalance').val(parseFloat(Total_final_amount).toFixed(2));
            

        });
    }

    $(document).on('blur', '#dAmount', function(e) {
        e.preventDefault();
        calculate_total();
    });

    function setPaid(paid_amount)
    {
        var xTotalPay = parseFloat($('#final_total').val());
        if(paid_amount != '' && paid_amount != 0 && paid_amount <= xTotalPay)
        {
            paid_amount = parseFloat(paid_amount);
            
            var balance = xTotalPay - paid_amount;
            $('#xBalance').val(parseFloat(balance).toFixed(2));

        }
    }
</script>
</body>
</html>