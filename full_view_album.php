<?php  include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';?>
<?php require_once('Class_Library/class_upload_album.php');
?>
<?php 
$value = $_GET['albumid'];
$clientid = $_SESSION['client_id'];
$obj = new Album();

$device = "panel";
$result= $obj->getAlbumImage($value,$device);
$value1 = json_decode($result,true);

$resul = count($value1['posts']);

echo $resul;

?>
<style>
div.img {
    margin: 5px;
    border: 1px solid #ccc;
    float: left;
    width: 180px;
}

div.img:hover {
    border: 1px solid #777;
}

div.img img {
    width: 100%;
    height: auto;
}

div.desc {
    padding: 15px;
    text-align: center;
}
.albumImage{height:130px !important;}
</style>

<div class="row" style="width:93%;height:auto;margin-top: 80px;margin-left:5%;border:1px solid #cdcdcd;">
	<div class=" col-sm-12 col-md-12 col-offset-md-3">
	 
	<?php
	for($t=0;$t<$resul;$t++)
	{
	?>
	<div class="img img-responsive">
  <a target="_blank" href="view_album_likeComments.php?albumid=<?php echo $value; ?>&imageid=<?php echo $value1['posts'][$t]['autoId']; ?>">
    <img src="<?php echo $value1['posts'][$t]['imgName']; ?>" alt="Image" class="albumImage" onerror='this.src="images/u.png"'>
  </a>

</div> 
	
	<?php
	}

	?>
		
	</div>
	
</div>




<!--**********pop up for like (end)***********-->
<?php include 'footer.php';?>