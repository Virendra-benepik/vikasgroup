<!-----------
Created BY - Monika Gupta
Created Date - 26/10/2016
----------->

<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';?>	                
<?php require_once('Class_Library/class_getaward.php');
session_start();
$object = new Getaward();
$clientid = $_SESSION['client_id'];
$awardid = $_GET['awardid'];

$result = $object->getAllAwardListDetails($awardid);
//echo "<pre>";
//print_r($result);
$val = json_decode($result,true);
//echo "<pre>";
//print_r($val);

		
		
						
//print_r($val["Data"]);
//$count  = count($val);
//$path = "http://admin.benepik.com/employee/virendra/benepik_client/";

?>



<div class="row" style="width:100%;height:auto;margin-top: 80px;margin-left:0%;">
	<div class=" col-sm-4 col-md-4 col-lg-4">
	</div>
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="border: 1px solid #f1f1f0;">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<?php 
					$status = ($val['Data']['status'] == 1) ? 'Active' : 'Not Active';
				?>
					<?php echo "<h4>".$val['Data']['awardName']."</h4>"; ?>
					<?php echo "<div style='font-size: 11px; font-weight: bold;color: gray; margin-bottom: 1%;'>".$val['Data']['createdDate']."</div>";?>
					<img src="<?php echo $val['Data']['awardImage']; ?>"class="img img-responsive" style="box-shadow: gray 0px -1px 10px 1px;max-height: 250px; width: 100%"/>
					<br/>
					<!--
					<?php echo "<div style='font-size: 11px; font-weight: bold;color: black; margin-bottom: 1%;'><b>Created By : </b>".$val['Data']['createdBy']."</div>";?>
					-->
					<?php echo "<div style='font-size: 11px; font-weight: bold;color: black; margin-bottom: 1%;'><b>Status : </b>".$status."</div>";?>
					<br/>
					<div style="font-size: 16px;font-family: calibri, sans-serif; text-align: justify;"><?php echo "<p >".$val['Data']['awardDescription']."</p>";?></div>
				
						
				</div>
			</div>
		</div>
	<div class=" col-sm-4 col-md-4 col-lg-4"></div>
<div>
		
<?php include 'footer.php';?>