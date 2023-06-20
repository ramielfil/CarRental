<?php
session_start();
error_reporting(0);
include('includes/connection.php');
if(strlen($_SESSION['login'])==0)
  { 
header('location:index.php');
}
else{
if(isset($_POST['updateprofile']))
  {
$name=$_POST['fullname'];
$mobile_number=$_POST['mobile_number'];
$dob=$_POST['dob'];
$email=$_POST['email'];
$adress=$_POST['address'];
$city=$_POST['city'];
$country=$_POST['country'];
$email=$_SESSION['login'];
$sql="update t_users set FullName=:name,contact_PNumber=:mobile_num,dob=:dob,Address=:adress,City=:city,Country=:country,EmailId=:email
 where EmailId=:email";
$query = $dbh->prepare($sql);
$query->bindParam(':name',$name,PDO::PARAM_STR);
$query->bindParam(':mobile_num',$mobile_number,PDO::PARAM_STR);
$query->bindParam(':dob',$dob,PDO::PARAM_STR);
$query->bindParam(':adress',$adress,PDO::PARAM_STR);
$query->bindParam(':city',$city,PDO::PARAM_STR);
$query->bindParam(':country',$country,PDO::PARAM_STR);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->execute();
$msg="Profile Updated Successfully";
}

?>
  <!DOCTYPE HTML>
<html lang="en">
<head>

<title>Car Rental | My Profile</title>
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
<!-- /Header --> 
<!--Page Header-->
<section class="page-header profile_page">
  <div class="container">
    <div class="page-header_wrap">
      <div class="page-heading">
        <h1>Your Profile</h1>
      </div>
      <ul class="coustom-breadcrumb">
        <li><a href="#">Home</a></li>
        <li>Profile</li>
      </ul>
    </div>
  </div>
  <!-- Dark Overlay-->
  <div class="dark-overlay"></div>
</section>
<!-- /Page Header--> 


<?php 
$useremail=$_SESSION['login'];
$sql = "SELECT * from t_users where EmailId=:useremail";
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
        <p>
          <?php echo htmlentities($result->Address);?><br>
          <?php echo htmlentities($result->City);?>&nbsp;<?php echo htmlentities($result->Country);?>
        </p>
      </div>
    </div>
  
    <div class="row">
      <div class="col-md-3 col-sm-3">
        <?php include('includes/sidebar.php');?>
      <div class="col-md-6 col-sm-8">
        <div class="profile_wrap">
          <h5 class="uppercase underline">Manage Your Profile</h5>
          <?php  
         if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
          <form  method="post">
           <div class="form-group">
              <label class="control-label">Registre Date :</label>
             <?php echo htmlentities($result->RegDate);?>
            </div>
             <?php if($result->last_update!=""){?>
            <div class="form-group">
              <label class="control-label">Last Update at  :</label>
             <?php echo htmlentities($result->last_update);?>
            </div>
            <?php } ?>
            <div class="form-group">
              <label class="control-label">Full Name</label>
              <input class="form-control white_bg" name="fullname" value="<?php echo htmlentities($result->FullName);?>" id="fullname" type="text"  required>
            </div>
            <div class="form-group">
              <label class="control-label">Email Address</label>
              <input class="form-control white_bg" value="<?php echo htmlentities($result->EmailId);?>" name="email" id="email" type="email" required readonly>
            </div>
            <div class="form-group">
              <label class="control-label">Phone Number</label>
              <input class="form-control white_bg"  id="mobile_number" name="mobile_number" value="<?php echo htmlentities($result->contact_PNumber);?>" type="text" required>
            </div>
            <div class="form-group">
              <label class="control-label">Date of Birth&nbsp;(dd/mm/yyyy)</label>
              <input class="form-control white_bg" value="<?php echo htmlentities($result->dob);?>" name="dob" placeholder="dd/mm/yyyy" id="birth-date" type="text" >
            </div>
            <div class="form-group">
              <label class="control-label">Your Address</label>
              <textarea class="form-control white_bg" name="address" rows="4" ><?php echo htmlentities($result->Address);?></textarea>
            </div>
            <div class="form-group">
              <label class="control-label">Country</label>
              <input class="form-control white_bg"  id="country" name="country" value="<?php echo htmlentities($result->Country);?>" type="text">
            </div>
            <div class="form-group">
              <label class="control-label">City</label>
              <input class="form-control white_bg" id="city" name="city" value="<?php echo htmlentities($result->City);?>" type="text">
            </div>
            <?php }} ?>
           
            <div class="form-group">
              <button type="submit" name="updateprofile" class="btn">Save Changes <span class="angle_arrow"><i class="fa fa-angle-right" aria-hidden="true"></i></span></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<!--/Profile-setting--> 

<<!--Footer -->
<?php include('includes/footer.php');?>
<!-- /Footer--> 

<!--Back to top-->
<div id="back-top" class="back-top"> <a href="#top"><i class="fa fa-angle-up" aria-hidden="true"></i> </a> </div>
<!--/Back to top--> 

<!--Login-Form -->
<?php include('includes/login.php');?>
<!--/Login-Form --> 

<!--Register-Form -->
<?php include('includes/registration.php');?>

<!--/Register-Form --> 

<!--Forgot-password-Form -->
<?php include('includes/forgot-password.php');?>
<!--/Forgot-password-Form --> 

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