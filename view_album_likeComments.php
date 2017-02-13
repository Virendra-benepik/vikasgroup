<?php include 'navigationbar.php'; ?>
<?php include 'leftSideSlide.php'; ?>
<?php
require_once('Class_Library/class_upload_album.php');
?>
<?php
//$path = "http://" . $_SERVER['SERVER_NAME'] . "/Zoom_Connect/";
$path = SITE;
$albumid = $_GET['albumid'];
$imageid = $_GET['imageid'];
$obj = new Album();
$resultalbum = $obj->getalbumimagedetails($albumid,$imageid);
$imagedetails = json_decode($resultalbum, true);

//echo "<pre>";
//print_r($imagedetails);
?>


<div class="row" style="width:100%;height:auto;margin-top: 80px;margin-left:0%;">
    <div class=" col-sm-4 col-md-4 col-lg-4"></div>
    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="border: 1px solid #f1f1f0;">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php echo "<h4>" . $imagedetails['posts'][0]['post_title'] . "</h4>" ?>
                <img src="<?php echo $path . $imagedetails['posts'][0]['post_img']; ?>"class="img img-responsive" style="box-shadow: gray 0px -1px 10px 1px;max-height: 250px; width: 100%" onerror='this.src="images/u.png"'/>
                
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <button type="button" class="btn btn-default btn-sm"data-toggle="modal" data-target="#myModalLikepop">
                    <span class="glyphicon glyphicon-thumbs-up"></span> Likes
                </button>
                <?php
				$result = $obj->getAlbumImagelike($albumid,$imageid);
				$value = json_decode($result, true);
				echo $value['total_like'];
				//echo "<pre>";
				//print_r($value);
				
                 
                ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <button type="button" class="btn btn-default btn-sm">
                    <span class="glyphicon glyphicon-comment"></span> Comments
                </button>
                <?php
                $resp = $obj->getAlbumImageComment($albumid,$imageid);
                $get = json_decode($resp, true);
				$totalcomment = count($get['posts']);
                echo $totalcomment;
                //echo"<pre>";
                //print_r($get);
                ?>
            </div>
        </div>


        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                <div id="RecentComment">
                    <p class="LatestActivitiesHeading">Total comment</p>
                    <hr>
                    <?php
                    for ($i = 0; $i < $totalcomment; $i++) {
                        echo "<div class='row'><div class='col-xs-6 col-sm-4 col-md-2 col-lg-2'>";
                        //echo "<button type='button' class='btn btn-default btn-circle btn-lg'>";
                        echo "<img src=" . $get['posts'][$i]['userimage'] . " class='img img-circle' style='width:60px !important;height:60px !important' onerror='this.src = &quot;images/usericon.png&quot;'/>";
                        //echo "</button>";
                        echo "</div>";

                        echo "<div class='col-xs-6 col-sm-8 col-md-10 col-lg-10'> ";
                        echo "<p class='LatestActivitiesSub-Heading'>" . $get['posts'][$i]['firstname'] . "&nbsp;&nbsp;&nbsp;&nbsp;" . $get['posts'][$i]['cdate'] . "</p>";

                        echo "<p class='LatestActivitiesDate'>" . $get['posts'][$i]['content'] . "</p></div></div><hr>";
                    }
                    ?>
                </div>
            </div>	
        </div>





    </div>
    <div class=" col-sm-4 col-md-4 col-lg-4"></div>
</div>



<!--**********pop up for like (start)***********-->


<div class="modal fade" id="myModalLikepop" role="dialog">
    <div class="modal-dialog ">

        <!-- Modal content-->
        <div class="modal-content"style="width:80%;">
            <div class="modal-header"style="background:#808080;color:#ffffff;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h6 class="modal-title"><p class="LatestActivitiesHeading">Likes</p></h6>
            </div>
            <div class="modal-body"style="max-height:550px;overflow-y:auto;">


                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                        <div id="latest_activity">


<?php
for ($i = 0; $i < $value['total_like']; $i++) {
//echo'<pre>';print_r($getcat);
    echo "<div class='row'><div class='col-xs-6 col-sm-4 col-md-2 col-lg-2'>";
    echo "<button type='button' class='btn btn-default btn-circle btn-lg'>";
    echo "<img src=" . $value['posts'][$i]['userimage'] . " class='img img-circle' style='width:60px !important;height:60px !important;margin-top: -21px;margin-left: -19px;' onerror='this.src =&quot;images/usericon.png&quot;'/>";
    echo "</button></div>";
    echo "<div class='col-xs-6 col-sm-8 col-md-10 col-lg-10'> ";
    echo "<p class='LatestActivitiesSub-Heading'>" . $value['posts'][$i]['firstname'] . " " . $value['posts'][$i]['lastname'] . "</p>";

// echo "<p style='font-size:10px;color:gray;margin:0px;'>".$getcat[$i]['firstname']."</p>";
    echo "<p class='LatestActivitiesDate'>" . $value['posts'][$i]['cdate'] . "</p></div></div><hr style='margin-top:0px;'>";
}
?>


                        </div>



                    </div>

                </div>

            </div>
        </div>

    </div>
</div>
<!--**********pop up for like (end)***********-->





<?php include 'footer.php'; ?>