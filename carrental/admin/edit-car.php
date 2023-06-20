<?php
session_start();
error_reporting(0);
include "includes/connection.php";
if (strlen($_SESSION["alogin"]) == 0) {
 header("location:index.php");
} else {
 if (isset($_POST["submit"])) {
  $vehicletitle = $_POST["vehicletitle"];
  $brand = $_POST["brandname"];
  $vehicleoverview = $_POST["vehicalorcview"];
  $Price_Per_Day = $_POST["Price_Per_Day"];
  $Fuel_Type = $_POST["Fuel_Type"];
  $Model_Year = $_POST["Model_Year"];
  $seatingcapacity = $_POST["seatingcapacity"];
  $airconditioner = $_POST["airconditioner"];
  $powerdoorlocks = $_POST["powerdoorlocks"];
  $antilockbrakingsys = $_POST["antilockbrakingsys"];
  $brakeassist = $_POST["brakeassist"];
  $powersteering = $_POST["powersteering"];
  $driverairbag = $_POST["driverairbag"];
  $passengerairbag = $_POST["passengerairbag"];
  $powerwindow = $_POST["powerwindow"];
  $cdplayer = $_POST["cdplayer"];
  $centrallocking = $_POST["centrallocking"];
  $crashcensor = $_POST["crashcensor"];
  $leatherseats = $_POST["leatherseats"];
  $id = intval($_GET["id"]);

  $sql =
   "update t_cars set car_title=:vehicletitle,car_brand=:brand,car_description=:vehicleoverview,Price_Per_Day=:Price_Per_Day,Fuel_Type=:Fuel_Type,Model_Year=:Model_Year,SeatingCapacity=:seatingcapacity,AirConditioner=:airconditioner,PowerDoorLocks=:powerdoorlocks,AntiLockBrakingSystem=:antilockbrakingsys,BrakeAssist=:brakeassist,PowerSteering=:powersteering,DriverAirbag=:driverairbag,PassengerAirbag=:passengerairbag,PowerWindows=:powerwindow,CDPlayer=:cdplayer,CentralLocking=:centrallocking,CrashSensor=:crashcensor,LeatherSeats=:leatherseats where id=:id ";
  $query = $dbh->prepare($sql);
  $query->bindParam(":vehicletitle", $vehicletitle, PDO::PARAM_STR);
  $query->bindParam(":brand", $brand, PDO::PARAM_STR);
  $query->bindParam(":vehicleoverview", $vehicleoverview, PDO::PARAM_STR);
  $query->bindParam(":Price_Per_Day", $Price_Per_Day, PDO::PARAM_STR);
  $query->bindParam(":Fuel_Type", $Fuel_Type, PDO::PARAM_STR);
  $query->bindParam(":Model_Year", $Model_Year, PDO::PARAM_STR);
  $query->bindParam(":seatingcapacity", $seatingcapacity, PDO::PARAM_STR);
  $query->bindParam(":airconditioner", $airconditioner, PDO::PARAM_STR);
  $query->bindParam(":powerdoorlocks", $powerdoorlocks, PDO::PARAM_STR);
  $query->bindParam(
   ":antilockbrakingsys",
   $antilockbrakingsys,
   PDO::PARAM_STR,
  );
  $query->bindParam(":brakeassist", $brakeassist, PDO::PARAM_STR);
  $query->bindParam(":powersteering", $powersteering, PDO::PARAM_STR);
  $query->bindParam(":driverairbag", $driverairbag, PDO::PARAM_STR);
  $query->bindParam(":passengerairbag", $passengerairbag, PDO::PARAM_STR);
  $query->bindParam(":powerwindow", $powerwindow, PDO::PARAM_STR);
  $query->bindParam(":cdplayer", $cdplayer, PDO::PARAM_STR);
  $query->bindParam(":centrallocking", $centrallocking, PDO::PARAM_STR);
  $query->bindParam(":crashcensor", $crashcensor, PDO::PARAM_STR);
  $query->bindParam(":leatherseats", $leatherseats, PDO::PARAM_STR);
  $query->bindParam(":id", $id, PDO::PARAM_STR);
  $query->execute();

  $msg = "Data updated successfully";
 } ?>
<!doctype html>
<html lang="en" class="no-js">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="theme-color" content="#3e454c">
	
	<title>Car Rental | Admin Edit Car Info</title>

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
	<?php include "includes/header.php"; ?>
	<div class="ts-main-content">
	<?php include "includes/leftbar.php"; ?>
	<div class="content-wrapper">
		<div class="container-fluid">

		<div class="row">
			<div class="col-md-12">
			
			<h2 class="page-title">Edit Car</h2>

			<div class="row">
				<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">Info</div>
					<div class="panel-body">
<?php if (
 $msg
) { ?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities(
 $msg,
); ?> </div><?php } ?>
<?php
$id = intval($_GET["id"]);
$sql =
 "SELECT t_cars.*,t_brands.BrandName,t_brands.id as bid from t_cars join t_brands on t_brands.id=t_cars.car_brand where t_cars.id=:id";
$query = $dbh->prepare($sql);
$query->bindParam(":id", $id, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
$cnt = 1;
if ($query->rowCount() > 0) {
 foreach ($results as $result) { ?>

<form method="post" class="form-horizontal" enctype="multipart/form-data">
<div class="form-group">
<label class="col-sm-2 control-label">car Title<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="vehicletitle" class="form-control" value="<?php echo htmlentities(
 $result->car_title,
); ?>" required>
</div>
<label class="col-sm-2 control-label">Select Brand<span style="color:red">*</span></label>
<div class="col-sm-4">
<select class="selectpicker" name="brandname" required>
<option value="<?php echo htmlentities(
 $result->bid,
); ?>"><?php echo htmlentities($bdname = $result->BrandName); ?> </option>
<?php
$ret = "select id,BrandName from t_brands";
$query = $dbh->prepare($ret); //$query->bindParam(':id',$id, PDO::PARAM_STR);
$query->execute();
$resultss = $query->fetchAll(PDO::FETCH_OBJ);
if ($query->rowCount() > 0) {
 foreach ($resultss as $results) {
  if ($results->BrandName == $bdname) {
   continue;
  } else {
    ?>
<option value="<?php echo htmlentities(
 $results->id,
); ?>"><?php echo htmlentities($results->BrandName); ?></option>
<?php
  }
 }
}
?>

</select>
</div>
</div>
						
<div class="hr-dashed"></div>
<div class="form-group">
<label class="col-sm-2 control-label">car Overview<span style="color:red">*</span></label>
<div class="col-sm-10">
<textarea class="form-control" name="vehicalorcview" rows="3" required><?php echo htmlentities(
 $result->car_description,
); ?></textarea>
</div>
</div>

<div class="form-group">
<label class="col-sm-2 control-label">Price Per Day(in DT)<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="Price_Per_Day" class="form-control" value="<?php echo htmlentities(
 $result->Price_Per_Day,
); ?>" required>
</div>
<label class="col-sm-2 control-label">Select Fuel Type<span style="color:red">*</span></label>
<div class="col-sm-4">
<select class="selectpicker" name="Fuel_Type" required>
<option value="<?php echo htmlentities(
 $result->Fuel_Type,
); ?>"> <?php echo htmlentities($result->Fuel_Type); ?> </option>

<option value="essence">essence</option>
<option value="Diesel">Diesel</option>
<option value="CNG">CNG</option>
</select>
</div>
</div>


<div class="form-group">
<label class="col-sm-2 control-label">Model Year<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="Model_Year" class="form-control" value="<?php echo htmlentities(
 $result->Model_Year,
); ?>" required>
</div>
<label class="col-sm-2 control-label">Seating Capacity<span style="color:red">*</span></label>
<div class="col-sm-4">
<input type="text" name="seatingcapacity" class="form-control" value="<?php echo htmlentities(
 $result->SeatingCapacity,
); ?>" required>
</div>
</div>
<div class="hr-dashed"></div>								
<div class="form-group">
<div class="col-sm-12">
<h4><b>Vehicle Images</b></h4>
</div>
</div>


<div class="form-group">
<div class="col-sm-4">
Image 1 <img src="img/vehicleimages/<?php echo htmlentities(
 $result->c_image1,
); ?>" width="300" height="200" style="border:solid 1px #000">
<a href="changeimage1.php?imgid=<?php echo htmlentities(
 $result->id,
); ?>">Change Image 1</a>
</div>
<div class="col-sm-4">
Image 2<img src="img/vehicleimages/<?php echo htmlentities(
 $result->c_image2,
); ?>" width="300" height="200" style="border:solid 1px #000">
<a href="changeimage2.php?imgid=<?php echo htmlentities(
 $result->id,
); ?>">Change Image 2</a>
</div>
<div class="col-sm-4">
Image 3<img src="img/vehicleimages/<?php echo htmlentities(
 $result->c_image3,
); ?>" width="300" height="200" style="border:solid 1px #000">
<a href="changeimage3.php?imgid=<?php echo htmlentities(
 $result->id,
); ?>">Change Image 3</a>
</div>
</div>


<div class="form-group">
<div class="col-sm-4">
Image 4<img src="img/vehicleimages/<?php echo htmlentities(
 $result->c_image4,
); ?>" width="300" height="200" style="border:solid 1px #000">
<a href="changeimage4.php?imgid=<?php echo htmlentities(
 $result->id,
); ?>">Change Image 4</a>
</div>
<div class="col-sm-4">
Image 5
<?php if ($result->c_image5 == "") {
 echo htmlentities("File not available");
} else {
  ?>
<img src="img/vehicleimages/<?php echo htmlentities(
 $result->c_image5,
); ?>" width="300" height="200" style="border:solid 1px #000">
<a href="changeimage5.php?imgid=<?php echo htmlentities(
 $result->id,
); ?>">Change Image 5</a>
<?php
} ?>
</div>

</div>
<div class="hr-dashed"></div>									
</div>
</div>
</div>
</div>
	
				



						<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2" >
							
<center><button class="btn btn-primary" name="submit" type="submit" style="margin-top:4%">Save changes</button></center>
						</div>
						</div>

					</form>
					</div>
				</div>
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
</body>
</html>
<?php }
}

} ?>
