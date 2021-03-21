<?php include('session.php'); ?>
<?php include('header.php'); ?>
<body>
<div id="wrapper">
<?php include('navbar.php'); ?>
<div style="height:50px;"></div>
<div style="background-color: white">
<div class="container-fluid">
	<div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Stocks 
            <span class="pull-right">
				
			</span>
			</h1>
        </div>
    </div>
    <div class="row">
    	<div class="col-sm-4"><div class="dataTables_length" id="supTable_length"><label>Show <select name="supTable_length" aria-controls="supTable" class="form-control input-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label></div></div>
    	<div class="col-sm-6"><div id="cusTable_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control input-sm" placeholder="" aria-controls="cusTable"></label></div></div>
        <div class="col-lg-12">
            <table width="100%" class="table table-striped table-bordered table-hover" id="prodTable">
                <thead>
                    <tr>
                        <th>Stock Name</th>
						<th>Supplier</th>
                        <th>Price</th>
						<th>Quantity</th>
						<th>Action</th>
                    </tr>
                </thead>
                <tbody>
				<?php
					$sq=mysqli_query($conn,"select * from stock left join supplier on supplier.userid=stock.supplierid");
					while($sqrow=mysqli_fetch_array($sq)){
						$sid=$sqrow['stockid'];
					?>
						<tr>
							<td><?php echo $sqrow['stock_name']; ?></td>
							<td><?php echo $sqrow['company_name']; ?></td>
							<td><?php echo $sqrow['stock_price']; ?></td>
							<td><?php echo $sqrow['stock_qty']; ?></td>
							<td>
								<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#editstock_<?php echo $sid; ?>"><i class="fa fa-edit"></i> Edit</button>
								<button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delstock_<?php echo $sid; ?>"><i class="fa fa-trash"></i> Delete</button>
								<?php include('stock_button.php'); ?>
							</td>
						</tr>
					<?php
					}
				?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
</div>
<?php include('script.php'); ?>
<?php include('modal.php'); ?>
<?php include('add_modal.php'); ?>
<script src="custom.js"></script>
</body>
</html>