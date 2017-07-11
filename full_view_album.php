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
<br/>
	<!--<p><?php echo "<pre>";print_r($value1);echo "</pre>"; ?></p>-->
	<div class="col-md-12"><a href="addMorealbumImage.php?albumid=<?php echo $value; ?>"><button class="btn btn-primary">Add more images</button></a></div>
	
	<div class=" col-sm-12 col-md-12 col-offset-md-3">
	 
	<?php
	//echo "<pre>";
	//print_r($value1);
	
	for($t=0;$t<$resul;$t++)
	{
		$k = $value1['posts'][$t]['status'];
                                        //  echo $k;

                                        if ($k == 0) {
                                            $action = 'Unpublish';
                                        } else {
                                            $action = 'Publish';
                                        }
										
										if ($k == 0) {
                                            $act = 'Publish';
                                        } else {
                                            $act = 'Unpublish';
                                        }
	?>
	<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
	<div style="border:1px solid #f2f2f2;margin-bottom:10px; margin-top:10px;">
  <a target="_blank" href="view_album_likeComments.php?albumid=<?php echo $value; ?>&imageid=<?php echo $value1['posts'][$t]['autoId']; ?>">
  <div style="background-image:url('<?php echo $value1['posts'][$t]['imgName']; ?>');background-size:cover;min-height:150px;">
   <!-- <img src="<?php echo $value1['posts'][$t]['imgName']; ?>" alt="Image" class="albumImage img img-responsive" onerror='this.src="images/u.png"'>--></div>
  </a>
  
  <a href="Link_Library/albumimage_status.php?postid=<?php echo $value1['posts'][$t]['albumId']; ?>&imagestatus=<?php echo $value1['posts'][$t]['status'];; ?>&imageid=<?php echo $value1['posts'][$t]['autoId']; ?>" ><p style="color:#fff;width:100%;background-color:#015da8;padding:7px 3px 7px 3px;margin:0px;font-weight:500;font-size:15px;text-align:center;">
  <?php echo $act; ?></p>
  </a>

</div>
</div>

	
	<?php
	}

	?>
		
	</div>
	
</div>




<!--**********pop up for like (end)***********-->
<?php include 'footer.php';?>