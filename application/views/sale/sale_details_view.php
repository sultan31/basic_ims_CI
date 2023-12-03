<?php

    $Invoice_ID = $this->uri->segment(3);

    $sql = "SELECT i.* FROM sale as i WHERE id = '$Invoice_ID'";

    $res = $this->db->query($sql);

    if($res->num_rows() > 0)
    {
        $row_invoice = $res->result_array();
    }
    else{
        exit();
    }

    //$gst = $row_invoice[0]['gst_tax'];
    //$gstAmt = $row_invoice[0]['total_gst_tax'];


    $sql_cust = "SELECT * FROM customer WHERE id = '".$row_invoice[0]['customer_id']."'";
    $res_cust = $this->db->query($sql_cust);
    $row_cust = $res_cust->result_array();

?>

<!DOCTYPE html>
<html>
    <head>

        <!-- Title -->
        <title>Invoice</title>

        <meta content="width=device-width, initial-scale=1" name="viewport"/>
        <meta charset="UTF-8">


        <!-- Styles -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <link href="../admin/assets/plugins/fontawesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <!-- <link href="../admin/assets/css/custom.css" rel="stylesheet" type="text/css"/> -->
        <!-- <link href="<?php //echo base_url();?>assets/css/invoice.css" rel="stylesheet" type="text/css"/> -->
        <style type="text/css">
             @media print {
                   .main_wrapper {
                       display:table;
                   }
             }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-1">
                </div>
                <div class="col-md-10 main_wrapper" style="display:table;padding:0;border:2px solid #000;">
                    <!-- <div class="invoice-box"> -->
                        
                        <div style="float:left;width:50%;">
                          <p class="shop-name">RAJVEER HERBALS</p>
                          <p class="address">                           
                            8, E. Y. A. SAYEED CHAWAL, JAMIL NAGAR,  NR . GIRIJA MEDICAL, BHANDUP W, MUMBAI 400078
                            <br/>
                            GST No: 27APAPY9889C1Z5
                          </p>
                        
                        </div>

                        <div style="float:left;width:50%;text-align:right;">
                          <p class="shop-name"><?php echo $row_cust[0]['name']; ?></p>
                          <p class="address">                           
                            <?php echo $row_cust[0]['address']; ?>
                          </p>
                          <p class="address">                           
                            <?php echo $row_cust[0]['phone']; ?>
                          </p>
                        
                        </div>
                        
                        <div class="col-md-12" style="padding:0;">
                            <div class="table-responsive" style="overflow-x: unset;">
                                <table class="table" border="1px" style="margin-bottom:0px;">
                                    <thead>
                                        <tr>
                                            <th colspan="3" style="border:none;"><?php echo $row_cust[0]['gst_no']; ?></th>
                                            <th colspan="4">GST INVOICE</th>
                                            <th colspan="3">Invoice No:</th>
                                            <th><?php echo $row_invoice[0]['voucher_no'];?></th>
                                            <th colspan="2">Date:</th>
                                            <th><?php echo date('d-m-y', strtotime($row_invoice[0]['sale_date']));?></th>
                                        </tr>
                                        <tr>
                                            
                                            <th colspan="7"></th>
                                            <th colspan="3">Sales Executive:</th>
                                            <th>abc</th>
                                            <th colspan="2">Due Date:</th>
                                            <th><?php echo date('d-m-y', strtotime($row_invoice[0]['sale_date']));?></th>
                                        </tr>
                                        <tr>
                                        <th>NO</th>
                                        <th>PRODUCT</th>                                
                                        <th>Pack</th>
                                        <th>HSN</th>
                                        <th>Batch</th>
                                        <th>Exp</th>
                                        <th>QTY</th>
                                        <th>Free</th>
                                        <th>MRP</th>
                                        <th>RATE</th>
                                        <th>DISCOUNT</th>
                                        <th>SGST</th>
                                        <th>CGST</th>
                                        <th class="text-right">AMOUNT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    
                                    $i = 1;
                                        
                                        $sql_purchase = "SELECT * FROM sale_items WHERE sale_id = '".$row_invoice[0]['id']."'";
                                        $res_purchase = $this->db->query($sql_purchase);
                                        $row_purchase = $res_purchase->result_array();
                                        foreach($row_purchase as $rp)
                                        {
                                            $product = $this->db->query('SELECT * FROM products WHERE id = '.$rp['product_id'])->result_array();
                                            //pre($product);
                                            
                                    ?>
                                        <tr>
                                            <td><?php echo $i++;?></td>
                                            <td><?php echo $product[0]['product_name'];?></td>
                                            <td><?php echo isset($product[0]['packing']) && !empty($product[0]['packing']) ? $product[0]['packing'] : '';?></td>
                                            <td><?php echo $product[0]['hsn_code'];?></td>
                                            <td><?php echo isset($product[0]['batch']) && !empty($product[0]['batch']) ? $product[0]['batch'] : '';?></td>
                                            <td><?php echo isset($product[0]['expiry_date']) && !empty($product[0]['expiry_date']) ? $product[0]['expiry_date'] : '';?></td>
                                            <td><?php echo $rp['qty'];?></td>
                                            <td></td>
                                            <td><?php echo $rp['price'];?></td>
                                            <td><?php echo $rp['price'];?></td>
                                            <td><?php echo '%';?></td>
                                            <td><?php echo $rp['item_cgst_amt'];?></td>
                                            <td><?php echo $rp['item_sgst_amt'];?></td>
                                            <td class="text-right"><?php echo $rp['sub_total'];?></td>
                                        </tr>
                                        <?php } ?>

                                        <tr>
                                            <td colspan="9"></td>                                            
                                            <td colspan="4">Sub Total
                                            <td><?php echo $rp['sub_total'];?></td>
                                        </tr>

                                        <tr>
                                            <td colspan="9"></td>                                            
                                            <td colspan="4">Discount
                                            <td><?php echo $row_invoice[0]['discount'];?></td>
                                        </tr>

                                        <tr>
                                            <td colspan="9"></td>                                            
                                            <td colspan="4">SGST Payable
                                            <td><?php echo $row_invoice[0]['totalSGstTax'];?></td>
                                        </tr>

                                        <tr>
                                            <td colspan="9"></td>                                            
                                            <td colspan="4">CGST Payable
                                            <td><?php echo $row_invoice[0]['totalCGstTax'];?></td>
                                        </tr>

                                        <tr>
                                            <td colspan="9"></td>                                            
                                            <td colspan="4">CR/DR Note
                                            <td></td>
                                        </tr>

                                        <tr>
                                            <td colspan="9"></td>                                            
                                            <td colspan="4">Grand Total
                                            <td><?php echo $row_invoice[0]['grand_total'];?></td>
                                        </tr>

                                        <tr>
                                            <td colspan="9"></td>                                            
                                            <td colspan="4">Total Paid
                                            <td><?php echo $row_invoice[0]['grand_total'];?></td>
                                        </tr>

                                        <tr>
                                            <td colspan="9"></td>                                            
                                            <td colspan="4">Balance
                                            <td><?php echo $row_invoice[0]['due_amount'];?></td>
                                        </tr>

                                        <tr>
                                            <td colspan="5">Terms & Conditions subject to Mumbai Jurisdiction: (1) Payments should be made by Cash, Debit/Credit Card, Cheque, Draft, Bank Transfer & should be made in favour of 'S Concepts'.</td>
                                            <td colspan="4">Receiver<br>
                                            </td>
                                            <td colspan="3">Bank Details:<br>
                                            Bank Name :-<br>
                                            Branch :-<br>
                                            Account No :-<br>
                                            IFSC Code:-</td>
                                            <td colspan="2">For RAJVEER HERBALS<br>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>                       
                        
                        
                </div>
                <div class="col-md-1">
                </div>
            </div>
        </div>
    </body>
</html>
<?php

    function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}
?>
