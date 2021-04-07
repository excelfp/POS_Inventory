<?php include('session.php'); ?>
<?php include('header.php'); ?>
<body>
<div class="container">
	<div style="height:50px;"></div>
	<div class="row">
		<div class="col-lg-9">
			<a href="index.php" class="btn btn-primary" style="position:relative; left:3px;"><span class="glyphicon glyphicon-arrow-left"></span> Cancel</a>
		</div>
		<form method="POST" action="confirm_check.php">
			<div class="col-lg-3" style="left: 15px;"><span>Customer: </span><input type="text" name="customer" required="1"></div>
			<div style="height:10px;"></div>
			<div id="checkout_area"></div>
			<div class="row">
				<span class="pull-right" style="margin-right:15px;"><strong>Payment method Here</strong></span>
			</div>
			<div style="height:20px;"></div>
			<div class="row">
				<button type="submit" id="check" class="btn btn-primary pull-right" style="margin-right:15px;" value="Confirm"><i class="fa fa-check fa-fw"></i> Confirm</button>
				<input type="submit" id="check" class="btn btn-primary pull-right" style="margin-right:15px;" value="Confirm">
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