<?php  include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';?>
<?php 
require_once('Class_Library/class_recognize.php');
require_once('Class_Library/class_get_useruniqueid.php');
?>
<?php 
$value = $_GET['idreg'];
$obj = new Recognize();
$uobj = new UserUniqueId ();

$result= $obj->getonerecogdetails($value);
$value = json_decode($result,true);

$clientid = $value['posts'][0]['clientId'];
$recid = $value['posts'][0]['recognitionId'];

$rby = $value['posts'][0]['recognitionBy'];
$rto = $value['posts'][0]['recognitionTo'];

$rcognizeby = $uobj->getUserData($clientid,$rby);
$by_data = json_decode($rcognizeby, true);
$by_image = $by_data[0]['userImage'];
$by_name = $by_data[0]['firstName']." ".$by_data[0]['lastName'];
$rcognizeto = $uobj->getUserData($clientid,$rto);
$to_data = json_decode($rcognizeto, true);
$to_image = $to_data[0]['userImage'];
$to_name = $to_data[0]['firstName']." ".$to_data[0]['lastName'];

$point = $value['posts'][0]['points'];
?>

<style>
.img_circle{
    width: 90px;
    height: 90px;
    border-radius: 50%;
	margin-left:98px;
	margin-right:98px;

}
.arrow_right{

    font-size: 50px;
    margin-top: 4%;
}
.left{float:left}
.right{float:right}
.rewards_image{    width: 145px;
    height: 129px;
	margin-top:90px;
	margin-left:20px;}
.quality{float:left; font-size:16px;text-align:justify;}
.fullviewUL li{display:inline;font-size:15px;font-weight:500;text-align:center;}
</style>


<div class="container">
<div class="row" style="width:100%;height:auto;margin-top: 100px;margin-left:40px;border:1px solid #cdcdcd;">








   <div class=" col-sm-2 col-md-2 col-lg-2"></div>
<div class="col-xs-12 col-sm-2 col-md-8 col-lg-8" style="border:1px solid #cdcdcd;margin-top:30px;margin-bottom:30px;padding-top:20px;box-shadow:1px 3px 4px 1px #dcdcdc;">

<div class="row">
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"><img src="<?php echo $by_image; ?>"class="img img-circle pull-left img_circle"/></div>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"><center><img src="img/arrow.png" class="img img-responsive" height="60" width="60"></center></div>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4"><img src="<?php echo $to_image; ?>" class="img img-circle pull-right img_circle" /></div>
</div>

<!--

        <img src="<?php echo $by_image; ?>"class="img img-circle pull-left img_circle" style="margin-left:40px;"/>
<img src="img/arrow.png" class="img img-responsive" height="60" width="60">
<img src="<?php echo $to_image; ?>" class="img img-circle pull-right img_circle" style="margin-top:-49px;" style="margin-right:20px;"/>
-->

<div class="row">
   <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
     <center><h4><?php echo $by_name; ?> recognize to <?php echo $to_name; ?></h4></center>
   </div>
</div>

<div class="row">
<div class="col-xs-12 col-sm-10 col-md-12 col-lg-12"> 
<center>
<ul class="fullviewUL"> 
<?php 
$topic = $value['posts'][0]['topic'];
$rt = explode("&",$topic);
$count = count($rt);
for($i=0;$i<$count;$i++)
{
?>
<li> <span class="glyphicon glyphicon-search"></span> <?php echo $rt[$i]; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  </li>

<?php
}
?>
</ul>
</center>
</div>
</div>

<div class="row">
<div class="col-xs-12 col-sm-10 col-md-8 col-lg-8"> 
<form role="form" method="post" action="Link_Library/link_update_recognizestatus.php" style="margin-left:98px;">
  <div class="form-group">
    <label for="title"class="pull-left">Title:</label>
    <input type="hidden" name="topic" value="<?php echo $topic; ?>" />
     <input type="hidden" name="clientid" value="<?php echo $clientid; ?>" />
      <input type="hidden" name="rcid" value="<?php echo $recid; ?>" />
      <input type="hidden" name="point" value="<?php echo $point; ?>" />
      <input type="hidden" name="recozto" value="<?php echo $rto; ?>" />
      <input type="hidden" name="recozby" value="<?php echo $rby; ?>" />
        <input type="hidden" name="byimg" value="<?php echo $by_image; ?>" />
         <input type="hidden" name="byname" value="<?php echo $by_name; ?>" />
           <input type="hidden" name="toname" value="<?php echo $to_name; ?>" />
       <input type="hidden" name="toimg" value="<?php echo $to_image; ?>" />
    <input type="text" class="form-control" name = "title" id="title" readonly value="<?php echo $value['posts'][0]['title']; ?>" >
  </div>

<div class="form-group">
  <label for="comment pull-left"class="pull-left">Comment:</label>
  <textarea class="form-control" rows="5" cols="40" name="comment" id="comment" readonly><?php echo $value['posts'][0]['text']; ?></textarea>
</div>
<center>
  <input type="submit" class="btn btn-primary" name="status" value="Approve" />
  <input type="submit" class="btn btn-success" name="status" value="Reject" />
  <input type="submit" class="btn btn-danger" name="status" value="Cancel" />
  </center>
</form>

</div>
  <div class="col-xs-12 col-sm-2 col-md-4 col-lg-4">
        
		 <div style="background-image:url('img/rewards.png');background-size:100% 100%;text-align:center;width:170px;height:170px">
<p style="padding-top: 51px;    font-size: 13px;    font-weight: bold;"><?php echo $point; ?> Points</p>
</div>
   
</div>

<hr>
<div class="row" style="margin-top:20px;margin-left:5px;">


<div class="col-xs-8 col-sm-11 col-md-11 col-lg-11" >
<img src="img/hr.jpg" class="img img-circle" width="50px" height="50px"/>
<font><strong>Deepak Thapa</strong></font>
<p style="margin-left:52px;">Awesome person</p>
</div>

</div>

</div>



   <div class=" col-sm-2 col-md-2 col-lg-2"></div>



 



 <div class="col-sm-2 col-md-2 col-lg-2 "></div>
</div><!-------------------///////////////////////////------------------------------->


</div>

<!-------------------------------------------------->


<!--**********pop up for like (start)***********-->


<!--**********pop up for like (end)***********-->

<?php include 'footer.php';?>