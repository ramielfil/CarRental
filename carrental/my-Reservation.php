<?php
session_start();
error_reporting(0);
include('includes/connection.php');
if(strlen($_SESSION['login'])==0)
  { 
header('location:index.php');
}
else{
?><!DOCTYPE HTML>
<html lang="en">
<head>

<title>Car Rental - My Reservation</title>
<!--Bootstrap -->
<link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css">
<!--Custome Style -->
<link rel="stylesheet" href="assets/css/style.css" type="text/css">
<!--OWL Carousel slider-->
<link rel="stylesheet" href="assets/css/owl.carousel.css" type="text/css">
<link rel="stylesheet" href="assets/css/owl.transitions.css" type="text/css">
<!--slick-slider -->
<link href="assets/css/slick.css" rel="stylesheet">
<!--bootstrap-slider -->
<link href="assets/css/bootstrap-slider.min.css" rel="stylesheet">
<!--FontAwesome Font Style -->
<link href="assets/css/font-awesome.min.css" rel="stylesheet">

  <!-- SWITCHER -->
	
  <link rel="alternate stylesheet" type="text/css" href="assets/switcher/css/blue.css" title="blue" media="all" />
	

  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet"> 
<!-- Fav and touch icons -->
<link rel="shortcut icon" href="assets/images/favicon-icon/logo_site2.jpg">
  
  </head>
  <body>
     <!-- /SWITCHER -->   
        
<!--Header-->
<?php include('includes/header.php');?>
<!--Page Header-->
<!-- /Header --> 

<!--Page Header-->
<section class="page-header profile_page">
  <div class="container">
    <div class="page-header_wrap">
      <div class="page-heading">
        <h1>Reservation Page</h1>
      </div>
      <ul class="coustom-breadcrumb">
        <li><a href="#">Home</a></li>
        <li>my Reservation</li>
      </ul>
    </div>
  </div>
  <!-- Dark Overlay-->
  <div class="dark-overlay"></div>
</section>
<!-- /Page Header--> 

<?php 
$useremail=$_SESSION['login'];
$sql = "SELECT * from t_users where EmailId=:useremail ";
$query = $dbh -> prepare($sql);
$query -> bindParam(':useremail',$useremail, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{ ?>
<section class="user_profile inner_pages">
  <div class="container">
    <div class="user_profile_info gray-bg padding_4x4_40">
      <div class="upload_user_logo"> <img src="assets/images/profil.jpg" alt="image">
      </div>

      <div class="dealer_info">
        <h5><?php echo htmlentities($result->FullName);?></h5>
        <p><?php echo htmlentities($result->Address);?><br>
          <?php echo htmlentities($result->City);?>&nbsp;<?php echo htmlentities($result->Country); }}?></p>
      </div>
    </div>
    <div class="row">
      <div class="col-md-3 col-sm-3">
       <?php include('includes/sidebar.php');?>
   
      <div class="col-md-8 col-sm-8">
        <div class="profile_wrap">
          <h5 class="uppercase underline">My Reservation </h5>
          <div class="my_vehicles_list">
            <ul class="vehicle_listing">
<?php 
$useremail=$_SESSION['login'];
 $sql = "SELECT t_cars.c_image1 as c_image1,t_cars.car_title,t_cars.id as vid,t_brands.BrandName,t_reservation.FromDate,t_reservation.ToDate,t_reservation.cin,t_reservation.Status,t_cars.Price_Per_Day,DATEDIFF(t_reservation.ToDate,t_reservation.FromDate) as totaldays,t_reservation.Reservation_Number  from t_reservation join t_cars on t_reservation.Car_Id=t_cars.id join t_brands on t_brands.id=t_cars.car_brand where t_reservation.userEmail=:useremail order by t_reservation.id desc";
$query = $dbh -> prepare($sql);
$query-> bindParam(':useremail', $useremail, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{  ?>

<li>
    <h4 style="color:red">Reservation Number : #<?php echo htmlentities($result->Reservation_Number);?></h4>
                <div class="vehicle_img"> <a href="car-details.php?vhid=<?php echo htmlentities($result->vid);?>"><img src="admin/img/vehicleimages/<?php echo htmlentities($result->c_image1);?>" alt="image"></a> </div>
                <div class="vehicle_title">

                  <h6><a href="car-details.php?vhid=<?php echo htmlentities($result->vid);?>"> <?php echo htmlentities($result->BrandName);?> , <?php echo htmlentities($result->car_title);?></a></h6>
                  <p><b>From : </b> <?php echo htmlentities($result->FromDate);?> <b>To : </b> <?php echo htmlentities($result->ToDate);?></p>
                  <div style="float: left"><p><b>Cin:</b> <?php echo htmlentities($result->cin);?> </p></div>
                </div>
                <?php if($result->Status==1)
                { ?>
                <div class="vehicle_status"> <a href="#" class="btn outline btn-xs active-btn">Confirmed</a>
                           <div class="clearfix"></div>
        </div>

              <?php } else if($result->Status==2) { ?>
 <div class="vehicle_status"> <a href="#" class="btn outline btn-xs">Cancelled</a>
            <div class="clearfix"></div>
        </div>
             


                <?php } else { ?>
 <div class="vehicle_status"> <a href="#" class="btn outline btn-xs">Not Confirm yet</a>
            <div class="clearfix"></div>
        </div>
                <?php } ?>
       
              </li>

<h5 style="color:blue">Facture</h5>
<table>
  <tr>
    <th>Car Name</th>
    <th>From Date</th>
    <th>To Date</th>
    <th>Total Days</th>
    <th>price for signle day</th>
  </tr>
  <tr>
    <td><?php echo htmlentities($result->car_title);?>, <?php echo htmlentities($result->BrandName);?></td>
     <td><?php echo htmlentities($result->FromDate);?></td>
      <td> <?php echo htmlentities($result->ToDate);?></td>
       <td><?php echo htmlentities($tds=$result->totaldays);?></td>
        <td> <?php echo htmlentities($ppd=$result->Price_Per_Day);?></td>
  </tr>
  <tr>
    <th colspan="4" style="text-align:center;">Total Price $</th>
    <th><?php echo htmlentities($tds*$ppd);?></th>
  </tr>
</table>
<hr />
              <?php }}  else { ?>
                <h5 align="center" style="color:red">No booking yet</h5>
              <?php } ?>
             
         
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--/my-vehicles--> 
<?php include('includes/footer.php');?>

<!-- Scripts --> 
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script> 
<script src="assets/js/interface.js"></script> 
<!--Switcher-->
<script src="assets/switcher/js/switcher.js"></script>
<!--bootstrap-slider-JS--> 
<script src="assets/js/bootstrap-slider.min.js"></script> 
<!--Slider-JS--> 
<script src="assets/js/slick.min.js"></script> 
<script src="assets/js/owl.carousel.min.js"></script>
</body>
</html>
<?php } ?>