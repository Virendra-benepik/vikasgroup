<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';?>
<?php include('Class_Library/class_feedback.php');
include('Class_Library/class_get_group_data.php');
$obj = new GetGroupData();
$cid = $_SESSION['client_id'];

$clientdemography1 = $obj->getClientDemoGraphy($cid); 
 $clientdemography = json_decode($clientdemography1,true);
$obj = new Feedback();
$happyid = "h1";
$averageid = "a1";
$sadid = "s1";

if(isset($_POST['submitdate']))
{
$d1 = $_POST['date1'];
$d2 = $_POST['date2'];

$resul = $obj->getallfeedback($happyid,$d1,$d2,$cid);
$getcat1 = json_decode($resul,true);

$resul2 = $obj->getallfeedback($averageid,$d1,$d2,$cid);
$getcat2 = json_decode($resul2,true);

$resul3 = $obj->getallfeedback($sadid,$d1,$d2,$cid);
$getcat3 = json_decode($resul3,true);
}
else
{
$result = $obj->getallfeedbacks($happyid,$cid);
$getcat1 = json_decode($result,true);

$result2 = $obj->getallfeedbacks($averageid,$cid);
$getcat2 = json_decode($result2,true);

$result3 = $obj->getallfeedbacks($sadid,$cid);
$getcat3 = json_decode($result3,true);
}
?>
<style>
#avgValue{
    width: 100px;
    height: 80px;
    border: 1px solid #ccc;
    border-radius: 100%;
    background: #353D47;
    position: absolute;
   // top: 3.5%;
    right: 4%;
    z-index: 1;
    text-align: center;
    color: white;
    font-size: 30px;
    padding: 15px;
}
#value{
color: white;
    position: relative;
    top: 15%;
    left: 20%;
    font-size: 45px;
}
#formAvg{

}
#valueAvg{
    font-family: sans-serif;
font-size:19px;padding:10px;
}
.formdate{    font-size: 18px;
    padding: 25px;
    border: 1px solid #dcdcdc;}
.fdropdown{    font-size: 18px;
    padding: 25px;
    }
.mylabel{font-weight:500 !important;}
</style>


	<div class="container-fluid">
	<div class="addusertest">
			<!--<button type="button"class="btn btn-sm btn-default"style="text-shadow:none;"data-toggle="modal" data-target="#ADDuserpopup"><b>Add User</b></button> 		--->	
		</div>
		
			 <!-- *********************************************************Modal for add user************************* -->
 <link rel="stylesheet" href="style.css" type="text/css">
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

        <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
        <script src="js/amcharts/amcharts.js" type="text/javascript"></script>
		<script src="js/amcharts/serial.js" type="text/javascript"></script>
		<script src="js/happiness_graph.js" type="text/javascript"></script>
		
		
  
        <div class="side-body padding-top">
		<div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;">
		<div class="row">
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-4" > <h4 style="padding: 20px;"><strong>Employee Happiness Average Score</strong></h4><hr></div>
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-4" >		
<div id="formAvg">

<script>

$(document).ready(function(){

var scripts = new Array();

scripts[01] = "January";
scripts[02] = "Febuary";
scripts[03] = "March";
scripts[04] = "April";
scripts[05] = "May";
scripts[06] = "June";
scripts[07] = "July";
scripts[08] = "August";
scripts[09] = "September";
scripts[10] = "October";
scripts[11] = "November";
scripts[12] = "December";

var monthname = "<?php echo date('m'); ?>";
var monthint = parseInt(monthname);


for (i=1;i<scripts.length;i++)
{
$("#selectmonth").append($("<option></option>").attr("value",i).text(scripts[i]));
}

$("#selectmonth option").filter(function() {
    if ( $(this).val() == monthint ) {
        return true;
    }
}).prop('selected', true);

});
</script>

<form name="form1" method="post" class="form-inline formdate">
Year: <select id="myAwesomeYear" class="form-control">
<option value="2016"><?php echo date('Y'); ?></option>
<!--<option value="2017">2017</option>-->
</select>
&nbsp;&nbsp;
Month:<select  class="form-control" id="selectmonth"  >

</select>
<!--<input type="submit" value="Submit" name="sub1" id="sub1"/>-->
</form>
</div></div>
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" style="padding:26px;">

<span id="valueAvg">Monthly Average : </span>
</div>
			<div class="col-xs-12 col-sm-3 col-md-3 col-lg-1" ><div id="avgValue"></div></div>
		</div>
		



<!-------------------------------------------------------------------------->

		 <div class="row">
	       
	        <form method="post" class="fdropdown"action="backup_happiness_score.php">
		
		 <div class="col-md-3"><label for="Location" class="mylabel">Select Location</label>
		    <select class="form-control" name="location" id="location_selector">
		
		 <option value="All">All</option>
		 <?php $lcount = count($clientdemography['posts'][0]['distinctValuesWithinColumn']); 
		 
		 for($i=0;$i<$lcount;$i++)
		 {
		 $val = $clientdemography['posts'][0]['distinctValuesWithinColumn'][$i];
		 echo "<option value='".$val."'>".$val."</option>";
		 }
		 ?>
		 
		 </select>
		 </div>
		<div class="col-md-3"><label for="Department" class="mylabel">Select Department</label>
		    <select class="form-control" name="department" id="department_selector">
		
		 <option value="All">All</option>
		  <?php $dcount = count($clientdemography['posts'][1]['distinctValuesWithinColumn']); 
		 for($k=0;$k<$dcount;$k++)
		 {
		 $val = $clientdemography['posts'][1]['distinctValuesWithinColumn'][$k];
		 echo "<option value='".$val."'>".$val."</option>";
		 }
		 ?>
		 </select>
		 </div>
		<div class="col-md-3"><label for="Gender" class="mylabel">Select Gender</label>
		    <select class="form-control" name="age" id="age_selector">
		 <option selected value="All">All</option>
		 <option value="Male">Male</option>
		 <option value="Female">Female</option>
		  </select>
		   </div>

		<div class="col-md-3"><label for="Age_Range" class="mylabel">Select Age Range</label>
		    <select class="form-control" name="age" id="age_selector">
		
		 <option value="All">All</option>
		 <option value='25-30'>25-30 </option>
		 <option value='30-35'>30-35</option>
		  <option value='35-40'>35-40</option>
		   <option value='40-45'>40-45</option>
		 </select>
		   </div>
		    
		   
		 
		 </form>
		     
		 </div>
		 <div class="row">
		 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		  <div id="chartdiv" style="width: 100%; height: 400px;"></div>
		      <div id="info" style="width: 100%; height: 100px;"></div>
		 </div>
		 </div>
		 
		 
            <div class="row">
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					
					<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				
					<div id="RecentComment">
						<p class="LatestActivitiesHeading">Recent Comment</p>
						<hr>
						<?php
						
						for($i=0; $i<count($getcat1); $i++)
						{
                                               ?>
						
					<div class="row">
						<div class="col-xs-6 col-sm-4 col-md-2 col-lg-2">
							<i class="fa fa-smile-o fa-3x"></i>
						</div>
						<div class="col-xs-6 col-sm-8 col-md-10 col-lg-10">
							<p class="RecentCommentSub-Heading">Anonymous</p>
							<p class="LatestActivitiesDate"><?php echo $getcat1[$i]['date_of_feedback'];  ?></p>
							<p class="mycomments"><?php echo $getcat1[$i]['comment']; ?></p>
						</div>
						
					</div>
					<?php 
					}
					?>
					
					

					</div>
					</div>
					</div>
					
				</div>
				
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					
					<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				
					<div id="RecentComment">
						<p class="LatestActivitiesHeading">Recent Comment</p>
						<hr>
					<?php
						
						for($i=0; $i<count($getcat2); $i++)
						{
                                               ?>
						
					<div class="row">
						<div class="col-xs-6 col-sm-4 col-md-2 col-lg-2">
							<i class="fa fa-meh-o fa-3x"></i>
						</div>
						<div class="col-xs-6 col-sm-8 col-md-10 col-lg-10">
							<p class="RecentCommentSub-Heading">Anonymous</p>
							<p class="LatestActivitiesDate"><?php echo $getcat2[$i]['date_of_feedback'];  ?></p>
							<p class="mycomments"><?php echo $getcat2[$i]['comment']; ?></p>
						</div>
						
					</div>
					<?php 
					}
					?>
					
					

					</div>
					</div>
					</div>
					
				</div>
				
				
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					
					<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				
					<div id="RecentComment">
						<p class="LatestActivitiesHeading">Recent Comment</p>
						<hr>
					<?php
						
						for($i=0; $i<count($getcat3); $i++)
						{
                                               ?>
						
					<div class="row">
						<div class="col-xs-6 col-sm-4 col-md-2 col-lg-2">
							<i class="fa fa-frown-o fa-3x"></i>
						</div>
						<div class="col-xs-6 col-sm-8 col-md-10 col-lg-10">
							<p class="RecentCommentSub-Heading">Anonymous</p>
							<p class="LatestActivitiesDate"><?php echo $getcat3[$i]['date_of_feedback'];  ?></p>
							<p class="mycomments"><?php echo $getcat3[$i]['comment']; ?></p>
						</div>
						
					</div>
					<?php 
					}
					?>
					
					
					


					</div>
					</div>
					</div>
					
				</div>
				
				
				
			</div>
					
                    
         </div>
	</div>
	</div>
<?php include 'footer.php';?>