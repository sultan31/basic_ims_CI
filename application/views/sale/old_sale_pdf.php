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

     #items_table tr td{border:1px solid #000;}
</style>
</head>
<body>
<div id="global-loader">
<div class="whirly-loader"> </div>
</div>

<div class="main-wrapper" style="display:table;padding:0;border:1px solid #000;margin:0 auto;">
<?php
        $sale_data = $this->api_model->get_one_detail('sale', $sale_id);
        $customer_data = $this->api_model->get_one_detail('customer', $sale_data[0]['customer_id']);
        $sale_items = $this->api_model->fetch_related_data('sale_items', $sale_id, 'sale_id');
    ?>

<?php //$this->load->view('common/header');?>


<?php //$this->load->view('common/sidebar');?>

<div class="page-wrapper" style="margin: 0;padding:0;">
<div class="content">

<div class="card">
<div class="card-body">
<table style="width: 100%;line-height: inherit;text-align: left;">
<tbody><tr>
<td style="padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
<font style="vertical-align: inherit;margin-bottom:25px;"><font style="vertical-align: inherit;font-size:14px;color:#7367F0;font-weight:600;line-height: 35px; ">Customer Info</font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> <?php echo $customer_data[0]['name'];?></font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="3a4d5b565117535417594f494e55575f487a5f425b574a565f14595557"><?php echo $customer_data[0]['email'];?></a></font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> <?php echo $customer_data[0]['phone'];?></font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> <?php echo $customer_data[0]['address'];?></font></font><br>
</td>
<td style="padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
<font style="vertical-align: inherit;margin-bottom:25px;"><font style="vertical-align: inherit;font-size:14px;color:#7367F0;font-weight:600;line-height: 35px; ">Company Info</font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> DGT </font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="9ffefbf2f6f1dffae7fef2eff3fab1fcf0f2">[email&#160;protected]</a></font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">6315996770</font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> 3618 Abia Martin Drive</font></font><br>
</td>
<td style="padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
<font style="vertical-align: inherit;margin-bottom:25px;"><font style="vertical-align: inherit;font-size:14px;color:#7367F0;font-weight:600;line-height: 35px; ">Invoice Info</font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> Invoice No </font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> Payment Status</font></font><br>
 <font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> Status</font></font><br>
</td>
<td style="padding:5px;vertical-align:top;text-align:right;padding-bottom:20px">
<font style="vertical-align: inherit;margin-bottom:25px;"><font style="vertical-align: inherit;font-size:14px;color:#7367F0;font-weight:600;line-height: 35px; ">&nbsp;</font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"><?php echo $sale_data[0]['voucher_no'];?> </font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#2E7D32;font-weight: 400;"> <?php echo $sale_data[0]['payment'] == 1 ? 'Paid' : 'Due';?></font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#2E7D32;font-weight: 400;"> <?php echo $sale_data[0]['status'] == 1 ? 'Completed' : 'Pending';?></font></font><br>
</td>
</tr>
</tbody></table>
<div class="card-sales-split">
    
<h2>Invoice No : <?php echo $sale_data[0]['voucher_no'];?></h2>

</div>
<div class="invoice-box table-height" style="max-width: 1600px;width:100%;overflow: auto;margin:15px auto;padding: 0;font-size: 14px;line-height: 24px;color: #555;">
<table cellpadding="0" cellspacing="0" style="width: 100%;line-height: inherit;text-align: left;">
<tbody><tr class="top">
<td colspan="6" style="padding: 5px;vertical-align: top;">
<table style="width: 100%;line-height: inherit;text-align: left;">
<tbody><tr>
<td style="padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
<font style="vertical-align: inherit;margin-bottom:25px;"><font style="vertical-align: inherit;font-size:14px;color:#7367F0;font-weight:600;line-height: 35px; ">Customer Info</font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> <?php echo $customer_data[0]['name'];?></font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="3a4d5b565117535417594f494e55575f487a5f425b574a565f14595557"><?php echo $customer_data[0]['email'];?></a></font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> <?php echo $customer_data[0]['phone'];?></font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> <?php echo $customer_data[0]['address'];?></font></font><br>
</td>
<td style="padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
<font style="vertical-align: inherit;margin-bottom:25px;"><font style="vertical-align: inherit;font-size:14px;color:#7367F0;font-weight:600;line-height: 35px; ">Company Info</font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> DGT </font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="9ffefbf2f6f1dffae7fef2eff3fab1fcf0f2">[email&#160;protected]</a></font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;">6315996770</font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> 3618 Abia Martin Drive</font></font><br>
</td>
<td style="padding:5px;vertical-align:top;text-align:left;padding-bottom:20px">
<font style="vertical-align: inherit;margin-bottom:25px;"><font style="vertical-align: inherit;font-size:14px;color:#7367F0;font-weight:600;line-height: 35px; ">Invoice Info</font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> Invoice No </font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> Payment Status</font></font><br>
 <font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"> Status</font></font><br>
</td>
<td style="padding:5px;vertical-align:top;text-align:right;padding-bottom:20px">
<font style="vertical-align: inherit;margin-bottom:25px;"><font style="vertical-align: inherit;font-size:14px;color:#7367F0;font-weight:600;line-height: 35px; ">&nbsp;</font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#000;font-weight: 400;"><?php echo $sale_data[0]['voucher_no'];?> </font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#2E7D32;font-weight: 400;"> <?php echo $sale_data[0]['payment'] == 1 ? 'Paid' : 'Due';?></font></font><br>
<font style="vertical-align: inherit;"><font style="vertical-align: inherit;font-size: 14px;color:#2E7D32;font-weight: 400;"> <?php echo $sale_data[0]['status'] == 1 ? 'Completed' : 'Pending';?></font></font><br>
</td>
</tr>
</tbody></table>
</td>
</tr>


<!-- <tr class="details" style="border-bottom:1px solid #E9ECEF ;">
<td style="padding: 10px;vertical-align: top; display: flex;align-items: center;">
<img src="<?php echo base_url();?>assets/img/product/product1.jpg" alt="img" class="me-2" style="width:40px;height:40px;">
Macbook pro
</td>
<td style="padding: 10px;vertical-align: top; ">
1.00
</td>
<td style="padding: 10px;vertical-align: top; ">
1500.00
</td>
<td style="padding: 10px;vertical-align: top; ">
0.00
</td>
<td style="padding: 10px;vertical-align: top; ">
0.00
</td>
<td style="padding: 10px;vertical-align: top; ">
1500.00
</td>
</tr> -->


</tbody></table>

<table id="items_table">
<tr class="">
    <td style="color:#000;padding: 5px;vertical-align: middle;font-weight: bold;font-size: 13px;padding: 10px; ">
    S.N
    </td>
    <td style="color:#000;padding: 5px;vertical-align: middle;font-weight: bold;font-size: 13px;padding: 10px; ">
    Description of Goods
    </td>
    <td style="color:#000;padding: 5px;vertical-align: middle;font-weight: bold;font-size: 13px;padding: 10px; ">
    HSN/SAC<br> Code
    </td>
    <td style="color:#000;padding: 5px;vertical-align: middle;font-weight: bold;font-size: 13px;padding: 10px; ">
    Qty.
    </td>
    <td style="color:#000;padding: 5px;vertical-align: middle;font-weight: bold;font-size: 13px;padding: 10px; ">
    Unit
    </td>
    <td style="color:#000;padding: 5px;vertical-align: middle;font-weight: bold;font-size: 13px;padding: 10px; ">
    Price
    </td>
    <td style="color:#000;padding: 5px;vertical-align: middle;font-weight: bold;font-size: 13px;padding: 10px; ">
    CGST<br>Rate
    </td>
    <td style="color:#000;padding: 5px;vertical-align: middle;font-weight: bold;font-size: 13px;padding: 10px; ">
    CGST<br>Amount
    </td>
    <td style="color:#000;padding: 5px;vertical-align: middle;font-weight: bold;font-size: 13px;padding: 10px; ">
    SGST <br>Rate
    </td>
    <td style="color:#000;padding: 5px;vertical-align: middle;font-weight: bold;font-size: 13px;padding: 10px; ">
    SGST <br>Amount
    </td>
    <td style="color:#000;padding: 5px;vertical-align: middle;font-weight: bold;font-size: 13px;padding: 10px; ">
    Amount
    </td>
</tr>
<?php
    if(isset($sale_items) && !empty($sale_items))
        {
            $products = $this->api_model->get_columns('products', 'id, product_name,image');
            $product_names = array_column($products, 'product_name');
            $product_ids = array_column($products, 'id');
            $product_images = array_column($products, 'image');

            $total_quantity = array_sum(array_column($sale_items, 'qty'));

            $total_tax_rate = 0;
            $taxable_amt = 0;

            $counter = 0;
            foreach ($sale_items as $key => $value) 
            {
                $total_tax_rate = $value['item_cgst'] + $value['item_sgst'];
                $unit = $value['unit'];
                $image = $product_images[array_search($value['product_id'], $product_ids)];
                $taxable_amt += ($value['qty'] * $value['price']);
                $counter++;
                ?>
                        <tr class="details" style="border-bottom:1px solid #E9ECEF ;">
                            <td style="padding: 10px;vertical-align: top; ">
                            <?php echo $counter;?>
                            </td>
                            <td style="padding: 10px;vertical-align: top;align-items: center;">
                            <?php
                                echo !empty($image) ? '<img src="'.base_url().$this->config->item('upload_url').'/'.$this->config->item('product_upload_url').'/'.$image.'" alt="'.$image.'" class="me-2" style="width:40px;height:40px;">' : '';
                            ?>
                            <?php echo $product_names[array_search($value['product_id'], $product_ids)];?>
                            </td>
                            <td style="padding: 10px;vertical-align: top; ">
                            <?php echo $value['hsn_code'];?>
                            </td>
                            <td style="padding: 10px;vertical-align: top; ">
                            <?php echo $value['qty'];?>
                            </td>
                            <td style="padding: 10px;vertical-align: top; ">
                            <?php echo $value['unit'];?>
                            </td>
                            <td style="padding: 10px;vertical-align: top; ">
                            <?php echo $value['price'];?>
                            </td>
                            <td style="padding: 10px;vertical-align: top; ">
                            <?php echo $value['item_cgst'].' %';?>
                            </td>
                            <td style="padding: 10px;vertical-align: top; ">
                            <?php echo $value['item_cgst_amt'];?>
                            </td>
                            <td style="padding: 10px;vertical-align: top; ">
                            <?php echo $value['item_sgst'].' %';?>
                            </td>
                            <td style="padding: 10px;vertical-align: top; ">
                            <?php echo $value['item_cgst_amt'];?>
                            </td>
                            <td style="padding: 10px;vertical-align: top; ">
                            <?php echo $value['sub_total'];?>
                            </td>
                        </tr>
                
                <?php
            }
        }
?>

<tr class="">
    <td colspan="3" style="color:#000;padding: 5px;vertical-align: middle;font-weight: bold;font-size: 13px;padding: 10px;text-align:center;">
    Grand Total
    </td>

    <td style="color:#000;padding: 5px;vertical-align: middle;font-weight: bold;font-size: 13px;padding: 10px; ">
    <?php echo $total_quantity;?>
    </td>
    <td style="color:#000;padding: 5px;vertical-align: middle;font-weight: bold;font-size: 13px;padding: 10px; ">
    <?php echo $unit;?>
    </td>
    <td colspan="5" style="color:#000;padding: 5px;vertical-align: middle;font-weight: bold;font-size: 13px;padding: 10px; ">
    </td>
    <td style="color:#000;padding: 5px;vertical-align: middle;font-weight: bold;font-size: 13px;padding: 10px; ">
    <?php echo $sale_data[0]['final_total'];?>
    </td>
</tr>

</table>
            
<table>
    <tr class="">
        <td colspan="3" style="color:#000;padding: 5px;vertical-align: middle;font-weight: bold;font-size: 13px;padding: 10px;text-align:center;">
        HSN/SAC
        </td>

        <td style="color:#000;padding: 5px;vertical-align: middle;font-weight: bold;font-size: 13px;padding: 10px; ">
        Tax Rate
        </td>
        <td style="color:#000;padding: 5px;vertical-align: middle;font-weight: bold;font-size: 13px;padding: 10px; ">
        Taxable Amt.
        </td>
        <td colspan="5" style="color:#000;padding: 5px;vertical-align: middle;font-weight: bold;font-size: 13px;padding: 10px; ">
        CGST Amt.
        </td>
        <td style="color:#000;padding: 5px;vertical-align: middle;font-weight: bold;font-size: 13px;padding: 10px; ">
        SGST Amt.
        </td>
        <td style="color:#000;padding: 5px;vertical-align: middle;font-weight: bold;font-size: 13px;padding: 10px; ">
        Total Tax
        </td>
    </tr>

    <tr class="">
        <td colspan="3" style="color:#000;padding: 5px;vertical-align: middle;font-weight: bold;font-size: 13px;padding: 10px;text-align:center;">
        HSN/SAC
        </td>

        <td style="color:#000;padding: 5px;vertical-align: middle;font-weight: bold;font-size: 13px;padding: 10px; ">
        Tax Rate
        </td>
        <td style="color:#000;padding: 5px;vertical-align: middle;font-weight: bold;font-size: 13px;padding: 10px; ">
        Taxable Amt.
        </td>
        <td colspan="5" style="color:#000;padding: 5px;vertical-align: middle;font-weight: bold;font-size: 13px;padding: 10px; ">
        CGST Amt.
        </td>
        <td style="color:#000;padding: 5px;vertical-align: middle;font-weight: bold;font-size: 13px;padding: 10px; ">
        SGST Amt.
        </td>
        <td style="color:#000;padding: 5px;vertical-align: middle;font-weight: bold;font-size: 13px;padding: 10px; ">
        Total Tax
        </td>
    </tr>
</table>


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
<div class="row">
    <div class="col-lg-6 ">
        <div class="total-order w-100 max-widthauto m-auto mb-4">
        <ul>
        <li>
        <h4>CGST</h4>
        <h5><?php echo $sale_data[0]['totalCGstTax'];?></h5>
        </li>
        <li>
        <h4>SGST</h4>
        <h5><?php echo $sale_data[0]['totalSGstTax'];?></h5>
        </li>
        </ul>
        </div>
    </div>
    <div class="col-lg-6 ">
        <div class="total-order w-100 max-widthauto m-auto mb-4">
        <ul>
        <li>
        <h4>Total</h4>
        <h5><?php echo $sale_data[0]['grand_total'];?></h5>
        </li>
        <li class="total">
        <h4>Discount</h4>
        <h5><?php echo $sale_data[0]['discount'];?></h5>
        </li>
        </ul>
        </div>
    </div>

    <div class="col-lg-6 ">
        <div class="total-order w-100 max-widthauto m-auto mb-4">
        <ul>
        <li>
        <h4>Final Total</h4>
        <h5><?php echo $sale_data[0]['final_total'];?></h5>
        </li>
        <!-- <li>
        <h4>SGST</h4>
        <h5><?php echo $sale_data[0]['totalSGstTax'];?></h5>
        </li> -->
        </ul>
        </div>
    </div>
    <div class="col-lg-6 ">
        <div class="total-order w-100 max-widthauto m-auto mb-4">
        <ul>
        <li>
        <h4>Paid</h4>
        <h5><?php echo $sale_data[0]['paid_amount'];?></h5>
        </li>
        <li class="total">
        <h4>Due</h4>
        <h5><?php echo $sale_data[0]['due_amount'];?></h5>
        </li>
        </ul>
        </div>
    </div>
</div>

</div>
</div>
</div>
</div>
</div>
</div>


<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="<?php echo base_url();?>assets/js/jquery-3.6.0.min.js"></script>

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