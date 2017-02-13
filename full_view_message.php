<?php include 'navigationbar.php'; ?>
<?php include 'leftSideSlide.php'; ?>
<?php
require_once('Class_Library/class_post.php');
?>
<?php
$value = $_GET['idpost'];
$obj = new Post();

$result = $obj->onegetpostdetails($value);
$value = json_decode($result, true);

//$path = "http://admin.benepik.com/employee/virendra/benepik_admin/";
$path = SITE;
?>
<div class="row"style="margin-left:4%;margin-right:4%;">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div style="width:100%;height:auto;margin-top: 80px;">


            <div class="row">
                <div class=" col-sm-4 col-md-4 col-lg-4"></div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 

                    <div class="row">
                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                            <img src="<?php echo $path . $_SESSION['image_name']; ?>" class='img' id='user_image' style='margin-right:5px;' onerror='this.src = "images/usericon.png" ' >

                        </div>

                        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                            <p><b><?php echo $_SESSION['user_name']; ?></b></p>
                            <p><small>
                                    <?php echo "<div >" . $value['posts'][0]['created_date'] . "</div>"; ?></small></p>

                        </div>
                    </div>
                    <hr style="margin-top:0px ;">
                    <?php
                    echo "<h4>" . $value['posts'][0]['post_title'] . "</h4>";
                    ?>
                    <p><?php echo "<p style='text-align: justify'>" . $value['posts'][0]['post_content'] . "</p><br>"; ?></p>

                    <hr>
                </div>
                <div class=" col-sm-4 col-md-4 col-lg-4"></div>
            </div>

<!------------------------------------------- total like and comment----------------------------------------->


          <!--  <div class="row">
                <div class=" col-sm-4 col-md-4 col-lg-4"></div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 


                    <div class="row">

                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <button type="button" class="btn btn-default btn-sm"data-toggle="modal" data-target="#myModalmessagelike">
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
            </div>-->

<!------------------------------------------- total like and comment end ----------------------------------------->

<!---------------------------- like comment user details ---------------------------------------------------------->
         <!--   <div class="row">
                <div class=" col-sm-4 col-md-4 col-lg-4"></div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 


                   

                    <div class="modal fade" id="myModalmessagelike" role="dialog">

                        <div class="modal-dialog ">

                            
                            <div class="modal-content"style="width:80%;">

                                <div class="modal-header"style="background-color:#808080;color:#ffffff;">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h6 class="modal-title"><p class="LatestActivitiesHeading">Likes</p></h6>
                                </div>
                                <div class="modal-body">


                                    <div class="row">

                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                            <div id="latest_activity">


                                                <?php
                                                for ($i = 0; $i < count($getcat['posts']); $i++) {
//echo'<pre>';print_r($getcat['posts']);
                                                    echo "<div class='row'><div class='col-xs-6 col-sm-4 col-md-2 col-lg-2'>";
//echo "<button type='button' class='btn btn-default btn-circle btn-lg'>";
                                                    echo "<img src='" . $getcat['posts'][$i]['userimage'] . "' class='img img-circle' style='width:60px !important;height:60px !important;margin-right:5px;' onerror='this.src = &quot;images/usericon.png&quot;'  />";
//echo "<img src='".$getcat['posts'][$i]['userimage']."' class='img img-circle' style='width:60px !important;height:60px !important; margin-right:5px;' onerror="'this.src = &quot;images/usericon.png&quot;' ">";
//echo "</button>";
                                                    echo "</div>";
                                                    echo "<div class='col-xs-6 col-sm-8 col-md-10 col-lg-10'> ";
                                                    echo "<p class='LatestActivitiesSub-Heading'>" . $getcat['posts'][$i]['firstname'] . " " . $getcat['posts'][$i]['lastname'] . "</p>";
//  echo "<p style='font-size:10px;color:gray;margin:0px;'>".$getcat['posts'][$i]['cdate']."</p>";
                                                    echo "<p class='LatestActivitiesDate'>" . $getcat['posts'][$i]['cdate'] . "</p></div></div><hr style='margin-top:0px;'>";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                
                            </div>
                        </div>
                    </div>


                   




                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                            <div id="RecentComment">
                                <p class="LatestActivitiesHeading">Total comment</p>

                                <hr>
                                <?php
                                for ($i = 0; $i < $resul; $i++) {
                                    echo "<div class='row'><div class='col-xs-6 col-sm-4 col-md-2 col-lg-2'>";
//echo "<button type='button' class='btn btn-default btn-circle btn-lg'>";
                                    echo "<img src=" . $get['posts'][$i]['userimage'] . " class='img img-circle'style='width:60px !important;height:60px !important;border-radius: 50%;background-size:55px 55px;margin-left:-20px;margin-top:-20px;' onerror='this.src =&quot;images/usericon.png&quot;'/>";

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
            </div> -->
<!---------------------------- like conmment user details end ----------------------------------------------->

        </div>
    </div>
</div>


<?php include 'footer.php'; ?>