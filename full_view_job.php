<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="js/display_group.js"></script>

<?php
include 'navigationbar.php';
include 'leftSideSlide.php';
require_once('Class_Library/class_jobpost.php');

@session_start();
$clientId = $_SESSION['client_id'];
$value = $_GET['jobId'];
$obj = new JobPost();

$result = $obj->getJobs($clientId, $value);
$value = json_decode($result, true);
//echo '<pre>';
//print_r($value);
$path = SITE_URL;
?>
<div class="row"style="margin-left:4%;margin-right:4%;">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div style="width:100%;height:auto;margin-top: 80px;">


            <div class="row">
                <div class="col-sm-3 col-md-3 col-lg-3"></div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" ng-app=""> 

                    <div class="row">
                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                            <img src="<?php echo $path . $_SESSION['image_name']; ?>" class='img' id='user_image' style='margin-right:5px;' onerror='this.src = "images/usericon.png" ' >

                        </div>

                        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                            <p><b><?php echo $_SESSION['user_name']; ?></b></p>
                            <p><small>
                                    <?php echo "<div >" . date('d M Y', strtotime($value[0]['createdDate'])) . "</div>"; ?></small></p>

                        </div>
                    </div>
                    <hr style="margin-top:0px ;">
                    <?php echo "<h4> Job Title : " . $value[0]['jobTitle'] . "</h4>"; ?>
                    <p><?php echo "<p style='text-align: justify'> Company Name : " . $value[0]['companyName'] . "</p>"; ?></p>
                    <p><?php echo "<p style='text-align: justify'> Job Description : " . $value[0]['jobDescription'] . "</p>"; ?></p>
                    <p><?php echo "<p style='text-align: justify'> Job Location : " . $value[0]['jobLocation'] ."</p>"; ?></p>
                    <p><?php echo "<p style='text-align: justify'> Posted By : " . $value[0]['firstName'] .' '. $value[0]['lastName'] . "</p>"; ?></p>
                    <p><?php echo "<p style='text-align: justify'> Contact : " . $value[0]['contact'] . "</p>"; ?></p>
                    <p><?php echo "<p style='text-align: justify'> Contact Email : " . $value[0]['emailId'] . "</p>"; ?></p>
                    <!--<p><?php echo "<p style='text-align: justify'> Posted  : " . $value[0]['location'] . "</p>"; ?></p>-->

                    <hr>
                    <div class="form-group col-sm-12">
                        <label for="exampleInputPassword1" style="padding-left:3px;">Select User</label>
                        <div>
                            <div class="col-md-6">
                                <input type="radio" id="user2" name="user3" ng-model="content" value="All" ng-checked="true">
                                <label for="radio5">
                                    Send Post to All Groups
                                </label>
                            </div>
                            <div class="col-md-6">
                                <input type="radio" id="user" ng-model="content"  name="user3" value="Selected">
                                <label for="radio6">
                                    Send Post to Selected Groups
                                </label>
                            </div>
                        </div>

                    </div>

                    <div id ="everything" ng-show="content == 'Selected'">
                        <input type='hidden' name="useruniqueid" id="userid" value="<?php echo $_SESSION['user_unique_id']; ?>">
                        <input type='hidden' name="clientid" id="clientid" value="<?php echo $_SESSION['client_id']; ?>">
                        <div class="form-group col-sm-5"id="alldatadiv" >
                            <center><p class="groupalldataheading">All Group</p> </center>
                            <div id="allitems" >
                            </div>

                        </div>
                        <div class="col-sm-1"></div>
                        <div id="selecteditems1" class="form-group col-sm-6" style="border:1px solid #dddddd;" >
                            <center><p class="groupselecteddataheading">Selected Group</p> </center>  
                            <p id="selecteditems"></i></p>

                        </div> 


                        <textarea id ="allids" style="display:none;" name="all_user"  height="660"></textarea>
                        <textarea id ="selectedids" style="display:none;" name="selected_user" ></textarea>
                    </div>
                </div>

                <div class="col-sm-3 col-md-3 col-lg-3"></div>
            </div>




            <div class="row">
                <div class=" col-sm-4 col-md-4 col-lg-4"></div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 


                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <button type="button" class="btn btn-default btn-sm" onclick="Job_approve_dissapprove('<?php echo $value[0]['jobId'] ?>', 1);">
                                <span class="glyphicon glyphicon-thumbs-up"></span> Approve
                            </button>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <button type="button" class="btn btn-default btn-sm"data-toggle="modal" data-target="#myModalmessagelike">
                                <span class="glyphicon glyphicon-thumbs-down"></span> Disapprove
                            </button>
                            <?php
//                            $postid = $_GET['jobId'];
//                            $string = "post_id=$postid";
//
//                            $sub_req_url = SITE_URL . "Link_Library/android_like_display.php";
//                            $ch = curl_init($sub_req_url);
//                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//                            curl_setopt($ch, CURLOPT_POSTFIELDS, "$string");
//                            curl_setopt($ch, CURLOPT_HEADER, 0);
//                            curl_setopt($ch, CURLOPT_POST, 1);
//
//                            $resp = curl_exec($ch);
//                            curl_close($ch);
//                            $getcat = json_decode($resp, true);
//                            //echo'<pre>';print_r($getcat);
//                            $val = $getcat['total_like'];
//                            echo $val;
                            ?>
                        </div>
                        <!--                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                                    <button type="button" class="btn btn-default btn-sm">
                                                        <span class="glyphicon glyphicon-comment"></span> Comments
                                                    </button>
                        <?php
//                            $postid = $_GET['jobId'];
//                            $string = "post=$postid";
//
//                            $sub_req_url = SITE_URL . "Link_Library/android_comment_display.php";
//                            $ch = curl_init($sub_req_url);
//                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//                            curl_setopt($ch, CURLOPT_POSTFIELDS, "$string");
//                            curl_setopt($ch, CURLOPT_HEADER, 0);
//                            curl_setopt($ch, CURLOPT_POST, 1);
//
//                            $resp = curl_exec($ch);
//                            curl_close($ch);
//                            $get = json_decode($resp, true);
//                            //echo"<pre>";
//                            //print_r($get);
//                            $resul = count($get['posts']);
//
//                            echo $resul;
                        ?>
                                                </div>-->

                    </div>



                </div>
                <div class=" col-sm-4 col-md-4 col-lg-4"></div>
            </div>





            <div class="row">
                <div class=" col-sm-4 col-md-4 col-lg-4"></div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 


                    <!--**********pop up for message like (start)***********-->

                    <div class="modal fade" id="myModalmessagelike" role="dialog">

                        <div class="modal-dialog ">

                            Modal content
                            <div class="modal-content"style="width:80%;">

                                <div class="modal-header" style="background-color:#808080;color:#0000;">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h6 class="modal-title"><p class="LatestActivitiesHeading">Reason for Disapproval</p></h6>
                                    <!--<form method="post" action="post.php">-->
                                    Reason :<textarea rows="5" cols="70" id="reason"></textarea>
                                    <input type="submit" onclick="Job_approve_dissapprove('<?php echo $value[0]['jobId'] ?>', 2, , $('#reason').val());">
                                    <!--</form>-->
                                </div>
                                <div class="modal-body">


                                    <div class="row">

                                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                                            <div id="latest_activity">


                                                <?php
//                                                for ($i = 0; $i < count($getcat['posts']); $i++) {
////echo'<pre>';print_r($getcat['posts']);
//                                                    echo "<div class='row'><div class='col-xs-6 col-sm-4 col-md-2 col-lg-2'>";
////echo "<button type='button' class='btn btn-default btn-circle btn-lg'>";
//                                                    echo "<img src='" . $getcat['posts'][$i]['userimage'] . "' class='img img-circle' style='width:60px !important;height:60px !important;margin-right:5px;' onerror='this.src = &quot;images/usericon.png&quot;'  />";
////echo "<img src='".$getcat['posts'][$i]['userimage']."' class='img img-circle' style='width:60px !important;height:60px !important; margin-right:5px;' onerror="'this.src = &quot;images/usericon.png&quot;' ">";
////echo "</button>";
//                                                    echo "</div>";
//                                                    echo "<div class='col-xs-6 col-sm-8 col-md-10 col-lg-10'> ";
//                                                    echo "<p class='LatestActivitiesSub-Heading'>" . $getcat['posts'][$i]['firstname'] . " " . $getcat['posts'][$i]['lastname'] . "</p>";
////  echo "<p style='font-size:10px;color:gray;margin:0px;'>".$getcat['posts'][$i]['cdate']."</p>";
//                                                    echo "<p class='LatestActivitiesDate'>" . $getcat['posts'][$i]['cdate'] . "</p></div></div><hr style='margin-top:0px;'>";
//                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <!--**********pop up for like (end)***********-->




                    <!--                    <div class="row">
                    
                                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    
                                                <div id="RecentComment">
                                                    <p class="LatestActivitiesHeading">Total comment</p>
                    
                                                    <hr>
                    <?php
//                    for ($i = 0; $i < $resul; $i++) {
//                        echo "<div class='row'><div class='col-xs-6 col-sm-4 col-md-2 col-lg-2'>";
////echo "<button type='button' class='btn btn-default btn-circle btn-lg'>";
//                        echo "<img src=" . $get['posts'][$i]['userimage'] . " class='img img-circle'style='width:60px !important;height:60px !important;border-radius: 50%;background-size:55px 55px;margin-left:-20px;margin-top:-20px;' onerror='this.src =&quot;images/usericon.png&quot;'/>";
//
////echo "</button>";
//                        echo "</div>";
//
//                        echo "<div class='col-xs-6 col-sm-8 col-md-10 col-lg-10'> ";
//                        echo "<p class='LatestActivitiesSub-Heading'>" . $get['posts'][$i]['firstname'] . "&nbsp;&nbsp;&nbsp;&nbsp;" . $get['posts'][$i]['cdate'] . "</p>";
//
//                        echo "<p class='LatestActivitiesDate'>" . $get['posts'][$i]['content'] . "</p></div></div><hr>";
//                    }
                    ?>
                    
                    
                                                </div>
                    
                                            </div>	
                    
                                        </div>-->

                </div>
                <div class=" col-sm-4 col-md-4 col-lg-4"></div>
            </div>

        </div>
    </div>
</div>
<script>
    var jobId;
    var status;
    var reason;
    function Job_approve_dissapprove(jobId, status, reason = '') {
        var User_Type = $("input[name=user3]:checked").val();
        if (User_Type == "All"){
            var selected_user = $("textarea[name=all_user]").val();
        } else{
            var selected_user = $("textarea[name=selected_user]").val();
        }
        if(selected_user != ''){
            window.location.href = "Link_Library/job_status.php?jobid=" + jobId + "&poststatus=" + status + "&client=<?php echo $clientId; ?>&reason=" + reason  + "&selected_user=" + selected_user;
        }
        else{
            alert("Please select group to continue");
            $("input[name=user3]:checked").focus();
        }
}
</script>

<?php include 'footer.php'; ?>