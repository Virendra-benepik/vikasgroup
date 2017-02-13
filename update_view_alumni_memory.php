<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="js/display_group.js"></script>
<script>
    $(document).ready(function () {
        $("#imgprvw").hide();
        $("#memoryMedia").click(function () {
            $('#memory').click();
        });
    });</script>

<?php
include 'navigationbar.php';
include 'leftSideSlide.php';
require_once('Class_Library/class_AlumniMemory.php');

@session_start();
$clientId = $_SESSION['client_id'];
$value = $_GET['memoryId'];
$obj = new AlumniMemory();

$result = $obj->getMemories($clientId, $value);
$value = json_decode($result, true);
//echo '<pre>';
//print_r($value);
$path = SITE;
?>
<div class="row"style="margin-left:4%;margin-right:4%;">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div style="width:100%;height:auto;margin-top: 80px;">


            <div class="row">
                <div class=" col-sm-3 col-md-3 col-lg-3"></div>
                <div ng-app="" class="col-xs-6 col-sm-6 col-md-6 col-lg-6"> 

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

                    <form method="post" action="Link_Library/alumini_memory_status.php" enctype="multipart/form-data">
                        <input type="hidden" value="<?php echo $value[0]['clientId']; ?>" name="clientId" readonly="">
                        <input type="hidden" value="<?php echo $value[0]['createdBy']; ?>" name="createdBy" readonly="">
                        <input type="hidden" value="<?php echo $value[0]['firstName']; ?>" name="auth" readonly="">
                        <input type="hidden" value="<?php echo $value[0]['memoryId']; ?>" name="memoryId" readonly="">
                      <!--  <input type="hidden" value="<?php echo $value[0]['selectedGroup']; ?>" name="selectedGroup" readonly="">-->
                        <input type="hidden" value="<?php echo $value[0]['flagType']; ?>" name="flag" readonly="">
                        <input type="hidden" value="<?php echo $value[0]['imageName']; ?>" id="hidMemoryImage" name="hidMemoryImage" readonly="">

                        <?php echo "<img src='" . $path . $value[0]['imageName'] . "' id='memoryMedia' style='cursor:hand;' class='img img-responsive' onerror='this.src = &quot;images/board.png&quot;' >"; ?> 
                        
                        <input type="file" name="memoryImage" id="memory" style="display:none;" onchange="showimagepreview1(this)">
                        
                        <b> Memory Title : </b>
                        <input style="width:98%;color: black;" type="text" name="title" id="title" class="form-control user-success" placeholder=" Choose a heading for this memmory..." value="<?php echo $value[0]['title']; ?>">
                        <br>
                        <b> Memory Content : </b>
                        <textarea style="color:#2d2a3b;" class="form-control user-error" rows="4" id="comment" cols="8" name="memory_content" placeholder="Event Description" required="" aria-invalid="true"> <?php echo $value[0]['memoryContent']; ?> </textarea>
                        <!--<textarea style="margin-left: 3px;" cols="61" rows="5" name="memory_content"><?php echo $value[0]['memoryContent']; ?></textarea>-->
                        <br>
						<!-------------------------------------------------------------->
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
						
						
						<div class="form-group col-sm-12">
						 <input type="submit" class="btn btn-md btn-info news_postBtn" style="text-shadow:none;font-weight:normal;" name="update" id="update" value=" Approve Memory ">
						 &emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp; &emsp;&emsp;&emsp;&emsp; 
						  <span style="font-weight:500; font-size:16px;"> Add In Popup </span> <input type="checkbox" name="popup" id="" value="hide">
						</div>
                        
                    </form>
                    <hr>
                </div>
                <div class=" col-sm-3 col-md-3 col-lg-3"></div>
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
                                    <input type="submit" onclick="Job_approve_dissapprove('<?php echo $value[0]['memoryId'] ?>', 2, $('#reason').val());">
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
    var memoryId;
    var status;
    var reason;
    function Job_approve_dissapprove(memoryId, status) {
        window.location.href = "Link_Library/alumini_memory_status.php?memoryid=" + memoryId + "&memorystatus=" + status + "&page=memory;
    }
</script>

<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.2.js"></script>

<script type="text/javascript">

    function showimagepreview1(input) {
        if (input.files && input.files[0]) {
            var filerdr = new FileReader();
            filerdr.onload = function (e) {
                $('#imgprvw').attr('src', e.target.result);
                $('#memoryMedia').attr('src', e.target.result);
            }
            filerdr.readAsDataURL(input.files[0]);
        }
    }

</script>

<?php include 'footer.php'; ?>