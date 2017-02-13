<!-----------
Created BY - Monika Gupta
Created Date - 26/10/2016
----------->

<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';?>	                
<?php require_once('Class_Library/class_getaward.php');

$object = new Getaward();
echo $employeeawardid = $_GET['employeeAwardId'];
$path=SITE;
$empawarddetails = $object->selectemployeeawarddetails($employeeawardid);
//echo "<pre>";
//print_r($result);
$result = json_decode($empawarddetails,true);
		  $firstName = $result['Data']['firstName'];
		  $awardName = $result['Data']['awardName'];
          $awardDate = $result['Data']['awardDate'];
	      $commentDesc = $result['Data']['commentDesc'];
	      $userimage = $result['Data']['userImage'];
		 if($userimage != '')
		 { 
			  //$servername = $_SERVER['SERVER_NAME'];
			  //$imgpath = '/benepik/benepic_admin/benepik_admin/';
			  $userimg = $path.$userimage;
		 
		 }
		 else
		 {
			  $userimg = 'images/usericon.png';
		 }
//echo "<pre>";
//print_r($result);

//$path = "http://admin.benepik.com/employee/virendra/benepik_client/";

?>

<div class="row" style="width:100%;height:auto;margin-top: 80px;margin-left:0%;">
	<div class=" col-sm-4 col-md-4 col-lg-4">
	</div>
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="border: 1px solid #f1f1f0;">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				
					<?php echo "<h4>".$firstName."</h4>"; ?>
					<?php echo "<div style='font-size: 11px; font-weight: bold;color: gray; margin-bottom: 1%;'>".$awardDate."</div>";?>
					<img src="<?php echo $userimg; ?>"class="img img-responsive" style="box-shadow: gray 0px -1px 10px 1px;max-height: 250px; width: 100%" onerror='this.src="images/usericon.png"'/>
					<br/>
					<?php echo "<div style='font-size: 11px; font-weight: bold;color: black; margin-bottom: 1%;'><b>Award Name : </b>".$awardName."</div>";?>
					<br/>
					<div style="font-size: 16px;font-family: calibri, sans-serif; text-align: justify;"><?php echo "<p >".$commentDesc."</p>";?></div>
				
						
				</div>
			</div>
		</div>
	<div class=" col-sm-4 col-md-4 col-lg-4"></div>
<div>	
<?php include 'footer.php';?>