<?php include('session.php'); ?>
<?php include('header.php'); ?>
<body>
<div id="wrapper">
<?php include('navbar.php'); ?>
<div style="height:50px;"></div>
<div id="page-wrapper">
<div class="container-fluid">
	<div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Stocks Return
				<span class="pull-right">
					<a href="stock.php" class="btn btn-sm btn-primary"><i class="fa fa-arrow-left fa-fw"></i> Back </a>
					<button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addstockreturn"><i class="fa fa-plus-circle"></i> Add Return </button>
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
						<th>Quantity</th>
						<th>Description</th>
						<th>Date</th>
                    </tr>
                </thead>
                <tbody>
				<?php
					$sq=mysqli_query($conn,"select * from stock_return left join supplier on supplier.userid=stock_return.supplierid left join stock on stock.stockid=stock_return.stockid order by return_date asc");
					while($sqrow=mysqli_fetch_array($sq)){
						$sid=$sqrow['stockid'];
					?>
						<tr>
							<td><?php echo $sqrow['stock_name']; ?></td>
							<td><?php echo $sqrow['company_name']; ?></td>
							<td><?php echo $sqrow['return_qty']; ?></td>
							<td><?php echo $sqrow['description']; ?></td>
							<td><?php echo date('M d, Y h:i A',strtotime($sqrow['return_date'])); ?></td>
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