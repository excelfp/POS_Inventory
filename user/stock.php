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
				<a href="stock_return.php" class="btn btn-danger btn-sm"><i class="fa fa-repeat fa-fw"></i> Stock Return </a>
			</span>
			</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <table width="100%" class="table table-striped table-bordered table-hover" id="prodTable">
                <thead>
                    <tr>
                        <th>Stock Name</th>
						<th>Supplier</th>
                        <th>Price</th>
						<th>Quantity</th>
						<th>Min. Quantity</th>
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
							<td><?php echo $sqrow['min_qty']; ?></td>
							<td>
								<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#editstock_<?php echo $sid; ?>"><i class="fa fa-edit"></i> Edit</button>
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
<?php include('stockalert.php'); ?>
<?php include('modal.php'); ?>
<?php include('add_modal.php'); ?>
<script src="custom.js"></script>
</body>
</html>