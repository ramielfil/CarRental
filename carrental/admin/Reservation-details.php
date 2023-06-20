<?php
session_start();
error_reporting(0);
include('includes/connection.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
if(isset($_REQUEST['eid']))
	{
$eid=intval($_GET['eid']);
$status="2";
$sql = "UPDATE t_reservation SET Status=:status WHERE  id=:eid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':eid',$eid, PDO::PARAM_STR);
$query -> execute();
  echo "<script>alert('Reservation Successfully Cancelled');</script>";
echo "<script type='text/javascript'> document.location = 'canceled-Reservation.php; </script>";
}


if(isset($_REQUEST['aeid']))
	{
$aeid=intval($_GET['aeid']);
$status=1;

$sql = "UPDATE t_reservation SET Status=:status WHERE  id=:aeid";
$query = $dbh->prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query-> bindParam(':aeid',$aeid, PDO::PARAM_STR);
$query -> execute();
echo "<script>alert('Reservation Successfully Confirmed');</script>";
echo "<script type='text/javascript'> document.location = 'confirmed-Reservation.php'; </script>";
}
 ?>
<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	
	<title>Car Rental | New Reservation   </title>

	<!-- Font awesome -->
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Sandstone Bootstrap CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<!-- Bootstrap Datatables -->
	<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
	<!-- Bootstrap social button library -->
	<link rel="stylesheet" href="css/bootstrap-social.css">
	<!-- Bootstrap select -->
	<link rel="stylesheet" href="css/bootstrap-select.css">
	<!-- Bootstrap file input -->
	<link rel="stylesheet" href="css/fileinput.min.css">
	<!-- Awesome Bootstrap checkbox -->
	<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
	<!-- Admin Stye -->
	<link rel="stylesheet" href="css/style.css">
	<style>
			.errorWrap {
		padding: 10px;
		margin: 0 0 20px 0;
		background: #fff;
		border-left: 4px solid #dd3d36;
		-webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
		box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
	}
	.succWrap{
		padding: 10px;
		margin: 0 0 20px 0;
		background: #fff;
		border-left: 4px solid #5cb85c;
		-webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
		box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
	}
	</style>

</head>

<body>
	<?php include('includes/header.php');?>

	<div class="ts-main-content">
		<?php include('includes/leftbar.php');?>
		<div class="content-wrapper">
			<div class="container-fluid">

				<div class="row">
					<div class="col-md-12">

						<h2 class="page-title">Reservation Details</h2>

						<!-- Zero Configuration Table -->
						<div class="panel panel-default">
							<div class="panel-heading">Reservation Info</div>
							<div class="panel-body">
							<div id="print">
								<table border="1"  class="display table table-striped table-bordered table-hover" cellspacing="0" width="100%"  >
									<tbody>
									<?php 
									$bid=intval($_GET['bid']);
									$sql = "SELECT t_users.*,t_brands.BrandName,t_cars.car_title,t_reservation.FromDate,t_reservation.ToDate,t_reservation.cin,t_reservation.Car_Id 
									as vid,t_reservation.Status,t_reservation.PostingDate,t_reservation.id,t_reservation.Reservation_Number,
									DATEDIFF(t_reservation.ToDate,t_reservation.FromDate) as totalnodays,t_cars.Price_Per_Day 
									from t_reservation join t_cars on t_cars.id=t_reservation.Car_Id 
									join t_users on t_users.EmailId=t_reservation.userEmail join t_brands on t_cars.car_brand=t_brands.id 
									where t_reservation.id=:bid";
									$query = $dbh -> prepare($sql);
									$query -> bindParam(':bid',$bid, PDO::PARAM_STR);
									$query->execute();
									$results=$query->fetchAll(PDO::FETCH_OBJ);
									$cnt=1;
									if($query->rowCount() > 0)
									{
									foreach($results as $result){				?>	
										<h3 style="text-align:center; color:red">#<?php echo htmlentities($result->Reservation_Number);?> Reservation Details </h3>
										<tr>
											<th colspan="4" style="text-align:center;color:blue">User Details</th>
										</tr>
										<tr>
											<th>Reservation Number</th>
											<td>#<?php echo htmlentities($result->Reservation_Number);?></td>
											<th>Name</th>
											<td><?php echo htmlentities($result->FullName);?></td>
										</tr>
										<tr>											
											<th>Email </th>
											<td><?php echo htmlentities($result->EmailId);?></td>
											<th>Phone Number</th>
											<td><?php echo htmlentities($result->contact_PNumber);?></td>
										</tr>
											<tr>											
											<th>Address</th>
											<td><?php echo htmlentities($result->Address);?></td>
											<th>City</th>
											<td><?php echo htmlentities($result->City);?></td>
										</tr>
											<tr>											
											<th>Country</th>
											<td colspan="3"><?php echo htmlentities($result->Country);?></td>
										</tr>

										<tr>
											<th colspan="4" style="text-align:center;color:blue">Reservation Details</th>
										</tr>
											<tr>											
											<th>Car Name</th>
											<td><a href="edit-car.php?id=<?php echo htmlentities($result->vid);?>"><?php echo htmlentities($result->BrandName);?> , <?php echo htmlentities($result->car_title);?></td>
											<th>Reservation Date</th>
											<td><?php echo htmlentities($result->PostingDate);?></td>
										</tr>
										<tr>
											<th>From Date</th>
											<td><?php echo htmlentities($result->FromDate);?></td>
											<th>To Date</th>
											<td><?php echo htmlentities($result->ToDate);?></td>
										</tr>
										<tr>
											<th>Total Days</th>
											<td><?php echo htmlentities($tdays=$result->totalnodays);?></td>
											<th>Rent Per Days</th>
											<td><?php echo htmlentities($ppdays=$result->Price_Per_Day);?></td>
										</tr>
										<tr>
											<th colspan="3" style="text-align:center">Grand Total</th>
											<td><?php echo htmlentities($tdays*$ppdays);?></td>
										</tr>
										<tr>
										<th>Reservation Status</th>
										<td><?php 
										if($result->Status==0)
										{
										echo htmlentities('Not Confirmed yet');
										} else if ($result->Status==1) {
										echo htmlentities('Confirmed');
										}
										else{
											echo htmlentities('Cancelled');
										}
										?></td>
										<th>Last update Date</th>
										<td><?php echo htmlentities($result->LastUpdationDate);?></td>
									</tr>

									<?php if($result->Status==0){ ?>
										<tr>	
										<td style="text-align:center" colspan="4">
										<a href="Reservation-details.php?aeid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you really want to Confirm this booking')" class="btn btn-primary"> Confirm Reservation</a> 
										<a href="Reservation-details.php?eid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you really want to Cancel this Booking')" class="btn btn-danger"> Cancel Reservation</a>
										</td>
										</tr>
										<?php } ?>
										<?php $cnt=$cnt+1; }} ?>		
									</tbody>
								</table>
								<form method="post">
	   							<input name="Submit2" type="submit" class="txtbox4" value="Print" onClick="return f3();" style="cursor: pointer;"  />
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Loading Scripts -->
	<script src="js/jquery.min.js"></script>
	<script src="js/bootstrap-select.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
	<script src="js/dataTables.bootstrap.min.js"></script>
	<script src="js/Chart.min.js"></script>
	<script src="js/fileinput.js"></script>
	<script src="js/chartData.js"></script>
	<script src="js/main.js"></script>
	<script language="javascript" type="text/javascript">
function f3()
{
window.print(); 
}
</script>
</body>
</html>
<?php } ?>
