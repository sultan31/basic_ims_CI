<div class="sidebar" id="sidebar">
<div class="sidebar-inner slimscroll">
<div id="sidebar-menu" class="sidebar-menu">
<ul>
<li class="<?php echo $this->uri->segment(1) == '' || $this->uri->segment(1) == 'dashboard' ? 'active' : '';?>">
<a href="<?php echo base_url();?>dashboard"><i class="fa fa-home"></i><span> Dashboard</span> </a>
</li>

<li class="<?php echo $this->uri->segment(1) == 'company' ? 'active' : '';?>">
<a href="<?php echo base_url();?>company"><i class="fa fa-building"></i><span>Company</span> </a>
</li>

<li class="submenu">
<a href="<?php echo base_url();?>javascript:void(0);"><img src="<?php echo base_url();?>assets/img/icons/product.svg" alt="img"><span> Masters</span> <span class="menu-arrow"></span></a>
<ul>
    <li><a href="<?php echo base_url();?>category" class="<?php echo $this->uri->segment(1) == 'category' && $this->uri->segment(2) == '' ? 'active' : '';?>">Category List</a></li>

    <li><a href="<?php echo base_url();?>category/addcategory" class="<?php echo $this->uri->segment(2) == 'addcategory' || $this->uri->segment(2) == 'editcategory' ? 'active' : '';?>">Add Category</a></li>
    <li><a href="<?php echo base_url();?>subcategory" class="<?php echo $this->uri->segment(1) == 'subcategory' && $this->uri->segment(2) == '' ? 'active' : '';?>">Sub Category List</a></li>

    <li><a href="<?php echo base_url();?>subcategory/addsubcategory" class="<?php echo 
    $this->uri->segment(2) == 'addsubcategory' || $this->uri->segment(2) == 'editsubcategory' ? 'active' : '';?>">Add Sub Category</a></li>
    <li><a href="<?php echo base_url();?>brand" class="<?php echo $this->uri->segment(1) == 'brand' && $this->uri->segment(2) == '' ? 'active' : '';?>">Brand List</a></li>

    <li><a href="<?php echo base_url();?>brand/addbrand" class="<?php echo ($this->uri->segment(2) == 'addbrand' || $this->uri->segment(2) == 'editbrand') ? 'active' : '';?>">Add Brand</a></li>
</ul>
</li>

<li class="submenu">
<a href="<?php echo base_url();?>javascript:void(0);"><img src="<?php echo base_url();?>assets/img/icons/users1.svg" alt="img"><span> Customer</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?php echo base_url();?>customers" class="<?php echo $this->uri->segment(1) == 'customers' && $this->uri->segment(2) == '' ? 'active' : '';?>">Customer List</a></li>

<li><a href="<?php echo base_url();?>customers/addcustomer" class="<?php echo $this->uri->segment(2) == 'addcustomer' || $this->uri->segment(2) == 'editcustomer' ? 'active' : '';?>">Add Customer</a></li>

</ul>
</li>


<li class="submenu">
<a href="<?php echo base_url();?>javascript:void(0);"><img src="<?php echo base_url();?>assets/img/icons/product.svg" alt="img"><span> Product</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?php echo base_url();?>products" class="<?php echo $this->uri->segment(1) == 'products' && $this->uri->segment(2) == '' ? 'active' : '';?>">Product List</a></li>
<li><a href="<?php echo base_url();?>products/addproduct" class="<?php echo $this->uri->segment(2) == 'addproduct' || $this->uri->segment(2) == 'editproduct' ? 'active' : '';?>">Add Product</a></li>

<li><a href="<?php echo base_url();?>stock" class="<?php echo $this->uri->segment(1) == 'stock' ? 'active' : '';?>">Stock</a></li>


<!-- <li><a href="<?php echo base_url();?>importproduct.html">Import Products</a></li>
<li><a href="<?php echo base_url();?>barcode.html">Print Barcode</a></li> -->
</ul>
</li>
<li class="submenu">
<a href="<?php echo base_url();?>javascript:void(0);"><img src="<?php echo base_url();?>assets/img/icons/sales1.svg" alt="img"><span> Invoices</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?php echo base_url();?>sale" class="<?php echo $this->uri->segment(1) == 'sale' && $this->uri->segment(2) == '' ? 'active' : '';?>">Invoice List</a></li>
<!-- <li><a href="<?php echo base_url();?>pos.html">POS</a></li> -->
<li><a href="<?php echo base_url();?>sale/addsale" class="<?php echo $this->uri->segment(1) == 'sale' && $this->uri->segment(2) == 'addsale' ? 'active' : '';?>">New Invoice</a></li>
<!-- <li><a href="<?php echo base_url();?>salesreturnlists.html">Sales Return List</a></li> -->
<!-- <li><a href="<?php echo base_url();?>createsalesreturns.html">New Sales Return</a></li> -->
</ul>
</li>


<!-- <li class="submenu">
<a href="<?php echo base_url();?>javascript:void(0);"><img src="<?php echo base_url();?>assets/img/icons/purchase1.svg" alt="img"><span> Purchase</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?php echo base_url();?>purchaselist.html">Purchase List</a></li>
<li><a href="<?php echo base_url();?>addpurchase.html">Add Purchase</a></li>
<li><a href="<?php echo base_url();?>importpurchase.html">Import Purchase</a></li>
</ul>
</li> -->

<!-- <li class="submenu">
<a href="<?php echo base_url();?>javascript:void(0);"><img src="<?php echo base_url();?>assets/img/icons/quotation1.svg" alt="img"><span> Quotation</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?php echo base_url();?>quotationList.html">Quotation List</a></li>
 <li><a href="<?php echo base_url();?>addquotation.html">Add Quotation</a></li>
</ul>
</li>
 -->
<!-- <li class="submenu">
<a href="<?php echo base_url();?>javascript:void(0);"><img src="<?php echo base_url();?>assets/img/icons/return1.svg" alt="img"><span> Return</span> <span class="menu-arrow"></span></a>
<ul>
<li><a href="<?php echo base_url();?>salesreturnlist.html">Sales Return List</a></li>
<li><a href="<?php echo base_url();?>createsalesreturn.html">Add Sales Return </a></li>
<li><a href="<?php echo base_url();?>purchasereturnlist.html">Purchase Return List</a></li>
<li><a href="<?php echo base_url();?>createpurchasereturn.html">Add Purchase Return </a></li>
</ul>
</li> -->


</ul>
</div>
</div>
</div>