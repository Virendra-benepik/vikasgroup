<?php include 'navigationbar.php'; ?>
<?php include 'leftSideSlide.php'; ?>

<!-------------------------------      SCRIPT START FROM HERE   --------->	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/display_group.js"></script>
<script src="js/validation/createPostValidation.js"></script>
<script>
    function check() {
        if (confirm('Are You Sure, You want to publish this post?')) {
            return true;
        } else {
            return false;
        }
    }
</script>
<!-------------------------------SCRIPT END FROM HERE   --------->	
<link rel="stylesheet"type="text/css"href="css/post_message.css"/>

<script>
    $(document).ready(function () {

        $("#preview_post").click(function () {

            var messageTitle = $("#messageTitle").val();
			var mesg = $("#message").val();
            


            $("#testpopup").css({"display": "block"});
            $(".messageTitlePost").html(messageTitle);
            $(".contentPost").html(mesg);



            $("#Iphone5").click(function () {
                $("#rightoneIphone6").css({"z-index": 0});
                $("#rightoneIphone5").css({"z-index": 1});
            });
            $("#Iphone6").click(function () {
                $("#rightoneIphone5").css({"z-index": 0});
                $("#rightoneIphone6").css({"z-index": 1});
            });

        });
    });
</script>

<script>
    $(document).ready(function () {
        $("#close_news_priview").click(function () {
            $("#testpopup").hide();
        });

    });
</script>	
<?php
$username = $_SESSION['user_name'];
?>
<div style="background-color:black;height:100%;width:100%;">
    <div id="testpopup" >

        <button id="close_news_priview" style="margin-top: 30px;" type="button"class="btn btn-gray" style="margin-left:373px ! important;">X</button><br><br>
        <!--
        <div id="leftone">
        <p style=" margin-top: 10px; font-size: 19px;margin-left: 24Px;border-bottom:1px dotted gray;"><span class="glyphicon glyphicon-phone" id="Iphone6"> Android</span></p>
        <p style="margin-top: 10px; font-size: 19px;margin-left: 24Px;border-bottom:1px dotted gray;"><span class="glyphicon glyphicon-phone" id="Iphone5"> iphone</span></p>
        
        
        </div>-->

        <div id="rightoneIphone5" style="    box-shadow: rgb(136, 136, 136) 1px 1px 5px 1px;">

            <div id="iphone5">
                <!--
                <div id="inneriphone5">
                <div class="iphoneSubParentDiv">
                <div class="row">
                
                
                <div class="col-xs-12 col-md-4 col-sm-4 col-lg-4"><img src="images/usericon.png"class="img img-responsive"id="user_image_priview_news"/></div>
                <div class="col-xs-12 col-md-8 col-sm-8  col-lg-8 "><p id="HRnamenewsPriview">HR Name</p><p id="Date_newsPriview">Date</sub> </div>
                
                </div>
                <div class="imagePost"><img class="post_img" /></div>
                <div class="contentPost"></div>
                <div class="row"style="margin:0px">
                <div class="col-xs-10 col-md-10 col-sm-10 col-lg-10 ">   Likes /  Commnets      </div>
                <div class="col-xs-2 col-md-2 col-sm-2 col-lg-2 ">  <span class="glyphicon glyphicon-thumbs-up" style="float:right;"></span>        </div>
                <hr style="height:1px;background-color:gray;width:92%;">
                </div>
                
                
                </div>
                </div>-->
            </div>

        </div>

        <div id="rightoneIphone6">

            <div id="iphone6DivMain">
                <div id="iphone6">
                    <div id="inneriphone6">
                        <div class="row" ><div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 " style="background-color: #5cb85c;
                                               height: 32px;
                                               margin-left: 0px;
                                               margin-right: 0px;
                                               border: 1px solid #5cb85c;padding-left:25px;"><i class="fa fa-arrow-left"style="color:#fff !important;    padding-top: 8px;">&nbsp;&nbsp;&nbsp;</i><font style="color:#ffffff;">Article</font></div>

                            <div class="iphoneSubParentDiv" style="padding-left:5px;">
                                <div class="row">
                                    <div class="col-xs-12 col-md-3 col-sm-3 col-lg-3" ><img src="images/usericon.png"class="img img-responsive"id="user_image_priview_news"/></div>
                                    <div class="col-xs-12 col-md-9 col-sm-9 col-lg-9 "><p id="HRnamenewsPriview"><?php echo $username; ?></p><p id="Date_newsPriview">Date: <?php echo date("d/m/Y"); ?></sub> </div>

                                </div>
                                <!--<div class="messageTitlePost"></div>
                                <div class="contentPost"></div>
                                -->
                                <div class="row" style="padding-left:10px;padding-right:10px;">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  
                                        <p class="messageTitlePost previewContent"></p>
                                    </div>
                                </div>

                                <div class="row" style="padding-left:10px;padding-right:10px;">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">  
                                        <p class="contentPost previewContent"></p>
                                    </div>
                                </div>


                                <div class="row"style="margin:0px">
                                    <div class="col-xs-12 col-md-12 col-sm-5 col-lg-5 "><font style="font-size:10px;">0 Likes</font><br> <button type="button" class="btn btn-xs"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i><font style="font-size:10px;">Like</font></button> </div>
                                    <div class="col-xs-12 col-md-12 col-sm-7 col-lg-7 "><font style="font-size:10px;"> 0 Comments</font><br> <button type="button" class="btn btn-xs"><i class="fa fa-commenting-o" aria-hidden="true"></i><font style="font-size:10px;">Comments</font></button></div
                                    <hr style="height:1px;background-color:gray;width:92%;">
                                </div>

                            </div>
                            <!--
                            <div class="row"style="margin:0px">
                            <div class="col-xs-11 col-md-11 col-sm-11 col-lg-11 ">   Likes /  Commnets      </div>
                            <div class="col-xs-1 col-md-1 col-sm-1 col-lg-1 ">  <span class="glyphicon glyphicon-thumbs-up" style="float:right;"></span>        </div>
                            <hr style="height:1px;background-color:gray;width:92%;">
                            </div>
                            -->
                        </div>
                    </div></div>
            </div>

        </div>

    </div>

</div>			   <div class="side-body padding-top">
    <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;margin-top:0px;">
        <div class="bs-example">


            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h3><strong> Message</strong></h3><hr>
                </div>


                <!-- Trigger the modal with a button -->

                <style>
                    #tableftiphonePriview:hover{background-color:#d6d6c2;color:red;}
                    #tableftiphonePriview a:hover{color:#ffffff;}
                    #tableftiphonePriview{padding:10px;border-bottom:1px dotted gray;}
                </style>
                <!--************************pop up start for live privie iphones output****************************** -->
                <div id="IphoneLivePriviewMessage" class="modal fade" role="dialog">
                    <div class="modal-dialog"style="width:60%;">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">

                                <br>
                                <br>
                                <div class="row">
                                    <div class="col-xs-3">

                                        <div class="row">
                                            <div class="col-xs-12"> <!-- required for floating -->
                                                <!-- Nav tabs -->
                                                <div class="nav nav-tabs tabs-left"style="border:none;background:#ffffff !important;"><!-- 'tabs-right' for right tabs -->
                                                    <p class="active" id="tableftiphonePriview"><a href="#iphone5Priview" data-toggle="tab"> <span class="glyphicon glyphicon-phone"style="font-size:20px;"> </span> iPhone 5</a></p>
                                                    <p id="tableftiphonePriview"><a href="#iphone6Priview" data-toggle="tab"> <span class="glyphicon glyphicon-phone"style="font-size:20px;"> </span> iPhone 6</a></p>
                                                    <p id="tableftiphonePriview"><a href="#iphone6PlushPriview" data-toggle="tab"> <span class="glyphicon glyphicon-phone"style="font-size:20px;"> </span> iPhone 6 Plush</a></p>
                                                    <p id="tableftiphonePriview"><a href="#androidPriview" data-toggle="tab"> <span class="glyphicon glyphicon-phone"style="font-size:20px;"> </span> Android </a></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-9">
                                        <div class="col-xs-12">
                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="iphone5Priview">
                                                    <h1 style="margin-top:-12%;">iPhone 5</h1><br><br><br><br>
                                                    <iframe src="http://admin.benepik.com/employee/virendra/www/message_priview.html" style="width:320px; height:491px ;border:1 px solid #000000 ;position:absolute;">

                                                    </iframe>
                                                    <img src="img/iphone.png"style="width:351px;height:592px;margin-top:-58px;margin-left:-14px;"/>

                                                </div>
                                                <div class="tab-pane" id="iphone6Priview">
                                                    <h1 style="margin-top:-12%;">iPhone 6</h1><br><br><br><br>
                                                    <iframe src="http://admin.benepik.com/employee/virendra/www/message_priview.html" style="width:375px ; height:667px ;border:1 px solid #000000 ;position:absolute;">

                                                    </iframe>
                                                    <img src="img/iphone.png"style="width:408px;height:795px;margin-top:-73px;margin-left:-14px;"/>
                                                </div>




                                                <div class="tab-pane" id="iphone6PlushPriview">
                                                    <h1 style="margin-top:-12%;">iPhone Plush</h1><br><br><br><br>
                                                    <iframe src="http://admin.benepik.com/employee/virendra/www/message_priview.html" style="width:414px ; height:736px ;border:1 px solid #000000 ;position:absolute;">

                                                    </iframe>
                                                    <img src="img/iphone.png"style="width:452px;height:878px;margin-top:-81px;margin-left:-17px;"/>
                                                </div>




                                                <div class="tab-pane" id="androidPriview">
                                                    <h1 style="margin-top:-12%;">Android Phone</h1><br><br><br><br>
                                                    <iframe src="http://admin.benepik.com/employee/virendra/www/message_priview.html" style="width:315px ;margin-left:18px; height:450px ;border:1 px solid #000000 ;position:absolute;">

                                                    </iframe>
                                                    <img src="images/motoe.jpg"style="width:381px;height:592px;margin-top:-57px;margin-left:-14px;"/>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

                <!--************************pop up end for live privie iphones output****************************** -->




            </div>
        </div>
        <br>



        <!------------------------------------------message portal start from here------------------------------------------------>	
        <div ng-app="" class="row">

            <form role="form" name="postmessageform" method="post" action="Link_Library/link_post_message.php" onsubmit="return check()">
                <input style="color:#2d2a3b;" type="hidden" name = "flag" value="2">
                <input style="color:#2d2a3b;" type="hidden" name = "flagvalue" value="Message">
                <input style="color:#2d2a3b;" type="hidden" name = "device" id="device" value="d2">	
                <input style="color:#2d2a3b;" type="hidden" name = "useruniqueid" value="<?php echo $_SESSION['user_unique_id']; ?>">	
                <input style="color:#2d2a3b;"type="hidden" name = "googleapi" value="<?php echo $_SESSION['gpk']; ?>">			

                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                    <!----------------------------------------message  start from here---------------------------------------->	
                    <div class="row">

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                            <div class="form-group">
                                <label for="TITLE">Message Title</label>
                                <input style="color:#2d2a3b;" type="text" name="title" id="messageTitle" class="form-control" placeholder="Choose a heading for message..." />
                            </div>

							
                            <div class="form-group">
                                <label for="Articlecontent">Message</label>
                                <div>
                                    <textarea style="color:#2d2a3b;" cols="80" id="message" name="content" rows="10" class="form-control" placeholder="Write  message..." ></textarea>
                                </div>
                            </div>
							
							
							

                            <script data-require="angular.js@1.1.5" data-semver="1.1.5" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.1.5/angular.js">

                            </script>					

                            <div class="form-group col-sm-12">

                                <label for="exampleInputPassword1">Select User</label>
                                <div>
                                    <div class="col-md-6">
                                        <input style="color:#2d2a3b;" type="radio" id="user2" name="user3" ng-model="content" value="All" ng-checked="true">
                                        <label for="radio5">
                                            Send Post to All Groups
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <input style="color:#2d2a3b;" type="radio" id="user" name="user3" ng-model="content" value="Selected">
                                        <label for="radio6">
                                            Send Post to Selected Groups
                                        </label>
                                    </div>
                                </div>

                            </div>
                            <!---------------------this script for show textbox on select radio button---------------------->                        

                            <!------------Abobe script for show textbox on select radio button---------------------->
                            <div id ="everything" ng-show="content == 'Selected'">
                                <input style="color:#2d2a3b;" type='hidden' name="useruniqueid" id="userid" value="<?php echo $_SESSION['user_unique_id']; ?>">
                                <input style="color:#2d2a3b;"type='hidden' name="clientid" id="clientid" value="<?php echo $_SESSION['client_id']; ?>">
                                <div class="form-group col-sm-5"id="alldatadiv" >
                                    <center><p class="groupalldataMessageheading">All Group</p> </center>
                                    <div id="allitems" class="form-group " >

                                    </div>
                                </div>

                                <div class="col-sm-1"></div>
                                <div id="selecteditems1" class="form-group col-sm-6"style="border:1px solid #dddddd;" >
                                    <center><p class="groupselecteddataheading">Selected Group</p> </center>  
                                    <p id="selecteditems"></p>
                                </div>


                                <textarea id ="allids" name="all_user" height="660" style="display:none;"></textarea>
                                <textarea id ="selectedids" name="selected_user" style="display:none;" ></textarea>
                            </div>

                        </div>
                    </div>
                    <!-----------------------------------message form end from here---------------------------------->		


                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">

                    <div class="publication">
                        <!------------------------------------------------------------------------------------------->
                        <br>

                        <div class="publication"><p id="publication_heading">Options</p><hr>

                            <div class="row">

                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
                                    <p class="publication_leftcontent"data-toggle="tooltip" data-placement="left" title="Post Comment (Enable/Disable) in case of Enable(On) User enable to comment on the post ">Comment ?</p>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">

                                    <div class="checkbox"style="margin-top:-10px;">
                                        <label><input style="color:#2d2a3b;"type="checkbox" data-toggle="toggle" name="comment" value="COMMENT_YES" checked></label></div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
                                    <p class="publication_leftcontent"data-toggle="tooltip" data-placement="left" title="Post Like(Enable/Disable) in case of Enable(On) User enable to like the post ">Like ?</p>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
                                    <div class="checkbox"style="margin-top:-10px;"><label><input style="color:#2d2a3b;"type="checkbox" data-toggle="toggle" name="like" value="LIKE_YES" checked></label></div>

                                </div>
                            </div>

                        </div>
                        <div class="publication"><p id="publication_heading">Notification</p><hr>

                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 "id="rightpublicationdiv6 ">
                                    <p class="publication_leftcontent "data-toggle="tooltip" data-placement="left" title="Push Notification.. Enable/Disable In Case of Enable(On) User Receive Notification of respective post">Push ?</p>




                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
                                    <div class="checkbox"style="margin-top:-10px;">
                                        <label><input style="color:#2d2a3b;"type="checkbox" data-toggle="toggle" name="push" value="PUSH_YES" checked></label></div>

                                </div>

                            </div>
                        </div>


                    </div>
                </div>
                <div class="form-group col-sm-6" style="margin-left:640px;">

                    <input style="color:#2d2a3b;" type="submit" name ="news_post" class="btn btn-md btn-primary publishnowBtn" style="text-shadow:none;font-weight:normal;" value="Publish" id="getData" onclick="return ValidatePostMessage();" />
                    <button type="button" class="btn btn-primary btn-md " id="preview_post" name="preview_post"> Preview</button>
                </div>

            </form>				

        </div>

    </div> <!--this script is use for tooltip genrate-->  

    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</div>
<!--tooltip script end here-->
<?php include 'footer.php'; ?>