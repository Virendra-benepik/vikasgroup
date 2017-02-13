<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';?>
<?php include('Class_Library/class_feedback.php');
 
$obj = new Feedback();
$happyid = "h1";
$averageid = "a1";
$sadid = "s1";
$cid = $_SESSION['client_id'];
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
position: absolute;
    border: 1px solid #ccc;
    padding: 10px 30px;
    right: 33%;
}
#valueAvg{
    position: ABSOLUTE;
    right: 15%;
    font-size: 19px;
    font-weight: 600;
  //  top: 3%;
    font-family: sans-serif;
}
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

<form name="form1" method="post" >
Year: <select id="myAwesomeYear" style="width:60px">
<option value="2016"><?php echo date('Y'); ?></option>
<!--<option value="2017">2017</option>-->
</select>
&nbsp;&nbsp;&nbsp;&nbsp;
Month:<select style='width:100px' id="selectmonth"  >

</select>
<!--<input type="submit" value="Submit" name="sub1" id="sub1"/>-->
</form>
</div>

<div id="avgValue"></div>
<span id="valueAvg">Monthly Average : </span>

		 <div class="row">
	        <h3>Employee Happiness Average Score<h3>
		 
		 <div class="col-md-12">  
		 <div class="col-md-4">
		 <select>
		 <option selected>----select location--- </option>
		 <option value="New Delhi">New Delhi </option>
		 <option value="Mumbai">Mumbai</option>
		 
		 </select>
		 </div>
		  <div class="col-md-4">
		   <select>
		 <option selected>----select department--- </option>
		 <option value ='IT'>IT </option>
		 <option value = 'Sales'>Sales</option>
		 
		 </select>
		  </div>
		   <div class="col-md-4">
		    <select>
		 <option selected>----select age--- </option>
		 <option value='25-30'>25-30 </option>
		 <option value='30-35'>30-35</option>
		  <option value='35-40'>35-40</option>
		   <option value='40-45'>40-45</option>
		 </select>
		   </div>
		    
		  </div>
		 
		      <div id="chartdiv" style="width: 100%; height: 400px;"></div>
		      <div id="info" style="width: 100%; height: 100px;"></div>
		 </div>
		 
		 
		<!------------------------------------------------------------------------------------------------------> 
		 
		 
		 
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
<?php include 'footer.php';?>