<?php include('session.php'); ?>
<?php include('header.php'); ?>
<body>
<div class="container">
	<div style="height:50px;"></div>
	<div class="row">
		
		<form method="POST" action="confirm_check.php">
			<div class="col-lg-9">
				<a href="sales_trans.php" class="btn btn-primary" style="position:relative; bottom: 4px; left:3px; margin-bottom: 5px;"><span class="glyphicon glyphicon-arrow-left"></span> Cancel</a>
			</div>
			<div class="col-lg-3" style="left: 15px;"><span>Customer: </span><input type="text" name="customer" required="true"></div>
			<div style="height:10px;"></div>
			<div id="checkout_area"></div>
			<div class="row">
				<span class="pull-right" style="margin-right: 15px;"><strong>Payment method Here</strong></span>
			</div>
			<div style="height:20px;"></div>
			<div class="row">
				<button type="submit" id="check" class="btn btn-primary pull-right" style="margin-right:15px;" value="Confirm"><i class="fa fa-check fa-fw"></i> Confirm</button>
			</div>
		</form>
	</div>
	
</div>
<?php include('script.php'); ?>
<script src="custom.js"></script>
<script>
$(document).ready(function(){
	showCheckout();
	
});
</script>
</body>
</html>