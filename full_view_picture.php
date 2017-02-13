<?php include 'navigationbar.php'; ?>
<?php include 'leftSideSlide.php'; ?>
<?php
require_once('Class_Library/class_post.php');
?>
<?php
//$path = "http://" . $_SERVER['SERVER_NAME'] . "/Zoom_Connect/";
$path = SITE;
$value = $_GET['idpost'];
$obj = new Post();

$result = $obj->onegetpostdetails($value);
$value = json_decode($result, true);
?>
<div class="row"style="margin-left:4%;margin-right:4%;">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div style="width:100%;height:auto;margin-top: 80px;">


            <div class="row">
                <div class=" col-sm-4 col-md-4 col-lg-4"></div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 

                    <?php
                    echo "<h4>" . $value['posts'][0]['post_title'] . "</h4>";
                    ?>

                    <img src="<?php echo $path . $value['posts'][0]['post_img']; ?>"class="img img-responsive" onerror='this.src="images/u.png"'/>

                    <?php echo "<br><div style='padding-left:20px;font-weight:bold;'>" . $value['posts'][0]['created_date'] . "</div><br><br>"; ?>

                    <?php
					$str = $value['posts'][0]['post_content']; 
					$word = wordwrap($str,50,"<br>\n",TRUE);
                    echo "<p style='text-align: justify'>" . $word . "</p><br>";
                    ?>




                </div>
                <div class=" col-sm-4 col-md-4 col-lg-4"></div>
            </div>




            <div class="row">
                <div class=" col-sm-4 col-md-4 col-lg-4"></div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 
                    <div class="row">


                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <button type="button" class="btn btn-default btn-sm"data-toggle="modal" data-target="#myModalLikepop">
                                <span class="glyphicon glyphicon-thumbs-up"></span> Likes
                            </button>
                            <?php
                            $postid = $_GET['idpost'];
                            $string = "post_id=$postid";

                            //$sub_req_url = "http://thomasinternational.benepik.com/webservices/communication_api/like_display.php";
                            $sub_req_url = SITE . "Link_Library/android_like_display.php";
                            $ch = curl_init($sub_req_url);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, "$string");
                            curl_setopt($ch, CURLOPT_HEADER, 0);
                            curl_setopt($ch, CURLOPT_POST, 1);

                            $resp = curl_exec($ch);
                            curl_close($ch);
                            $getcat = json_decode($resp, true);
//echo'<pre>';print_r($getcat);
                            $val = $getcat['total_like'];
                            echo $val;
                            ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <button type="button" class="btn btn-default btn-sm">
                                <span class="glyphicon glyphicon-comment"></span> Comments
                            </button>
                            <?php
                            $postid = $_GET['idpost'];
                            $string = "post=$postid";

//$sub_req_url ="http://thomasinternational.benepik.com/webservices/communication_api/c//omment_display.php";
                            $sub_req_url = SITE . "Link_Library/android_comment_display.php";
                            $ch = curl_init($sub_req_url);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, "$string");
                            curl_setopt($ch, CURLOPT_HEADER, 0);
                            curl_setopt($ch, CURLOPT_POST, 1);

                            $resp = curl_exec($ch);
                            curl_close($ch);
                            $get = json_decode($resp, true);
//echo"<pre>";
//print_r($get);
                            $resul = count($get['posts']);

                            echo $resul;
                            ?>
                        </div>

                    </div>

                </div>
                <div class=" col-sm-4 col-md-4 col-lg-4"></div>
            </div>



            <div class="row">
                <div class=" col-sm-4 col-md-4 col-lg-4"></div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 

                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                            <div id="RecentComment">
                                <p class="LatestActivitiesHeading">Total comment </p>

                                <hr>
                                <?php
                                for ($i = 0; $i < $resul; $i++) {
                                    echo "<div class='row'><div class='col-xs-6 col-sm-4 col-md-2 col-lg-2'>";
//echo "<button type='button' class='btn btn-default btn-circle btn-lg'>";
                                    echo "<img src=" . $get['posts'][0]['userimage'] . " class='img img-circle' style='width:60px !important;height:60px !important' onerror='this.src = &quot;images/usericon.png&quot;'/>";
//echo "</button>";
                                    echo "</div>";

                                    echo "<div class='col-xs-6 col-sm-8 col-md-10 col-lg-10'> ";
                                    echo "<p class='LatestActivitiesSub-Heading'>" . $get['posts'][$i]['firstname'] . "&nbsp;&nbsp;&nbsp;&nbsp;" . $get['posts'][$i]['cdate'] . "</p>";

                                    echo "<p class='LatestActivitiesDate'>" . $get['posts'][0]['content'] . "</p></div></div><hr>";
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
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                <div id="latest_activity">

                                    <?php
                                    for ($i = 0; $i < $getcat['total_like']; $i++) {
//echo'<pre>';print_r($getcat);
                                        echo "<div class='row'><div class='col-xs-6 col-sm-4 col-md-2 col-lg-2'>";
                                        echo "<button type='button' class='btn btn-default btn-circle btn-lg'>";
                                        echo "<img src=" . $getcat['posts'][$i]['userimage'] . " class='img img-circle' style='width:60px !important;height:60px !important;margin-top: -21px;margin-left: -19px;' onerror='this.src =&quot;images/usericon.png&quot;'/>";
                                        echo "</button></div>";
                                        echo "<div class='col-xs-6 col-sm-8 col-md-10 col-lg-10'> ";
                                        echo "<p class='LatestActivitiesSub-Heading'>" . $getcat['posts'][$i]['firstname'] . " " . $getcat['posts'][$i]['lastname'] . "</p>";

// echo "<p style='font-size:10px;color:gray;margin:0px;'>".$getcat[$i]['firstname']."</p>";
                                        echo "<p class='LatestActivitiesDate'>" . $getcat['posts'][$i]['cdate'] . "</p></div></div><hr style='margin-top:0px;'>";
                                    }
                                    ?>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>


            <!--**********pop up for like (end)***********-->




        </div>
    </div>
</div>



<?php include 'footer.php'; ?>