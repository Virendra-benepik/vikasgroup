<?php include 'navigationbar.php'; ?>
<?php include 'leftSideSlide.php'; ?>
<?php

?>
<!-------------------------------SCRIPT START FROM HERE   --------->	

<script src="angularjs/poll_option.js"></script>

<link rel="stylesheet" href="css/thought.css" />
<link rel="stylesheet" href="css/createpoll.css" />
<script src="js/display_group.js"></script>

<script>

    $(document).ready(function () {

        $("#preview_poll").click(function () {

            $("#poll_div").css({"display": "block"});
            var pquestion = $("#content").val();
            $(".pollquestion").html(pquestion);
            fetchvalues();
        });
    });
    function check() {
        if (confirm('Are You Sure, You want to publish this post?')) {
            return true;
        } else {
            return false;
        }
    }

    function fetchvalues()
    {

        var val = $("#option").val();
        for (i = 1; i <= val; i++)
        {

            var number = document.getElementById("text" + i).value;
            $(".polloptions").append('<div >' + number + '</div>');
        }
    }

</script>

<script>
    $(document).ready(function () {
        $(".closeThoughtPopoUpBtn").click(function () {
            $("#poll_div").hide();
        });
    });</script>

<div id="poll_div" >




    <div class="row">
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">

        </div>
        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
            <button type="button" class="btn btn-gray closeThoughtPopoUpBtn closebtn" style="margin-left: 183px;
                    }">X</button><br><br>
            <div class="tab-content mytabContent">
                <div id="AndoidPriviewTab" class="tab-pane fade in active">  
                    <div class="background_Android_Image" style="margin-left:-149px;">
                        <img src="images/mobile.jpg"class="img img-responsive androidImage"/>
                    </div>
                    <div class="androidContentTab">
                        <div class="wholeAndroidContentHolder">

                            <div class="pollquestion"></div><br><br>
                            <div class="polloptions"></div>


                        </div>
                    </div>
                </div>
                <div id="IphonePriviewTab" class="tab-pane fade">
                    <div class="background_iphone_Image">
                        <img src="images/i6.png"class="img img-responsive IphoneImage"/>
                    </div>
                    <div class="iphoneContentTab">
                        <div class="wholeIOSContentHolder">


                            <div class="pollquestion"></div><br><br>
                            <div class="polloptions"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--
    <div id="pollquestion"></div>
    <div id="polloptions"></div>-->
</div>
<div class="side-body padding-top">
    <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;margin-top:-5px;">
        <div class="bs-example">

            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
                    <h3><strong>Create New Happiness Survey</strong></h3><hr>
                </div>

            </div>
            <br>


            <div class="row">

                <form role="form" action="Link_Library/link_create_happinessquestion.php" method="post" enctype="multipart/form-data">

                    <input style="color:#2d2a3b;" type="hidden" name = "flag" value="4">
                    <input style="color:#2d2a3b;" type="hidden" name = "device" value="d2">
                    <input style="color:#2d2a3b;" type="hidden" name = "useruniqueid" value="<?php echo $_SESSION['user_unique_id']; ?>">
                    <input style="color:#2d2a3b;" type="hidden" name = "googleapi" value="<?php echo $_SESSION['gpk']; ?>">
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">

                        <!----------------------------------- form picture post staryt here ------------------------------------------>		
                        <div class="row">
                            <div class="col-md-12">
                                <br/>

                                <div class="col-md-12">
                                  <div class="form-group">
                                    <label for="select ans"> Comment (Enable/Disable) </label>
                                    <div>
                                        <div class="col-md-6">
                                       <input style="color:#2d2a3b;" type="radio" id="optiontext" name="surveychoice" value="1" ng-checked="true" >
                                            <label for="radio5">
                                                Comment Enable
                                            </label>
                                        </div>
                                        <div class="col-md-6">
                                         <input style="color:#2d2a3b;" type="radio" id="optionimage" name="surveychoice" value="0" >
                                            <label for="radio6">
                                                Comment Disable
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                    <br>
                                    <div ng-controller="ctrl">
                                        <div class="form-group">
                                            <label for="Articlecontent">Please Enter no. of Question (required only numbers)</label>
                                            <input min="0" max="3" style="color:#2d2a3b;" ng-model="totalNumberOfOptions" type="number" ng-change="makeArray()" class="form-control" name="option" id="option" /> 
                                        </div>
                                        <br>  
                                        <br>
                                        <div  ng-show="totalNumberOfOptions > 0" ng-repeat="ithData in allOptions"> 

                                            <div class="form-group col-md-1">  {{$index + 1}}
                                            </div>
                                            <div class="form-group col-md-11">
                                                <textarea style="color:#2d2a3b;" name = "text{{$index + 1}}" 
                                                          id = "text{{$index + 1}}" style="width:450px; height:100px;" class="form-control" placeholder="Write Text Option" ></textarea>
                                            </div>

                                            <br/>
                                        </div>




                                    </div>   
                                </div>

                                <br>
                                <hr/>



                                <!------------Abobe script for show textbox on select radio button---------------------->

                                <div id ="everything" ng-show=" content == 'Selected'">
                                    <input style="color:#2d2a3b;" type='hidden' name="useruniqueid" id="userid" value="<?php echo $_SESSION['user_unique_id']; ?>">
                                    <input style="color:#2d2a3b;" type='hidden' name="clientid" id="clientid" value="<?php echo $_SESSION['client_id']; ?>">
                                    <div class="col-sm-1"style="width:3.333333%;"></div>	  <div class="form-group col-sm-5" id="alldatadiv" >
                                        <center><p class="groupPicturealldataheading">All Group</p> </center>
                                        <div id="allitems" >
                                        </div>

                                    </div>
                                    <div class="col-sm-1"></div>
                                    <div id="selecteditems1" class="form-group col-sm-5" style="border:1px solid #dddddd; width:44.666667%;" >
                                        <center><p class="groupselecteddataheading">Selected Group</p> </center>  
                                        <p id="selecteditems"></p>


                                    </div>


                                    <textarea id ="allids" name="all_user" ng-show = false height="660"></textarea>
                                    <textarea id ="selectedids" name="selected_user" ng-show = false ></textarea>
                                </div>


                            </div>
                        </div>
                    </div>
                    <!----------------------------------- form picture post end here ------------------------------------------>		


                    <div class="col-xs-4 col-md-4 col-lg-4 col-sm-4"id="rightpublicationdiv">
                        <div class="publication">
                            <!---------------------------------------------------------------------->

                            <div class="publication">
                                <p id="publication_heading">PUBLICATION</p><hr>

                                <p class="publication_subheading">PUBLISH DATE </p>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" id="rightpublicationdiv6">
                                        <p class="publication_leftcontent" data-toggle="tooltip" data-placement="left"  title="Publish Date.. Enable/Disable In Case of Enable(On) Add publish Date of respective post">Immediately ?</p>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">

                                        <div class="btn-group btn-toggle"> 
                                            <button type = "button" class="btn btn-default btn-xs" id="showshortcontent">ON</button>
                                            <button type = "button" class="btn btn-primary active btn-xs"id="hideshortcontent">OFF</button>

                                        </div>

                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function () {
                                        $("#hideshortcontent").click(function () {
                                            $("#shortpublicationdivcontent").hide();
                                        });
                                        $("#showshortcontent").click(function () {
                                            $("#shortpublicationdivcontent").show();
                                        });
                                    });</script>
                                <div id="shortpublicationdivcontent">

                                    <input  style="color:#2d2a3b;" type="date" class="form-control" placeholder="YYYY-MM-DD"  name="publish_date1"/><br>

                                </div>

                                <br>

                                <p class="publication_subheading">EXPIRY DATE </p>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
                                        <p class="publication_leftcontent" data-toggle="tooltip" data-placement="left"  title="Expeiry Date.. Enable/Disable In Case of Enable(On) Add Expeiry Date of respective post">Not Scheduled ?</p>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">

                                        <div class="btn-group btn-toggle"> 
                                            <button type = "button" class="btn btn-default btn-xs"id="showshortcontent1">ON</button>
                                            <button type = "button" class="btn btn-primary active btn-xs"id="hideshortcontent1">OFF</button>

                                        </div>

                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function () {
                                        $("#hideshortcontent1").click(function () {
                                            $("#shortUnpublicationdivcontent").hide();
                                        });
                                        $("#showshortcontent1").click(function () {
                                            $("#shortUnpublicationdivcontent").show();
                                        });
                                    });</script>
                                <div id="shortUnpublicationdivcontent" >
                                    <input style="color:#2d2a3b;" type="date" class="form-control" style="width: 100% !important;" name="publish_date2" placeholder= "YYYY-MM-DD"/><br>

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
                                        <label><input type="checkbox" data-toggle="toggle" name="push" value="PUSH_YES" checked></label></div>

                                </div>

                            </div> 


                        </div>
                    </div>


                    <!-------------------------------------------------------------------->	


                    <div class="form-group col-sm-12">
                        <center>
                            <!--
        <input type="button" name ="preview_poll" id="preview_poll" class="btn btn-md btn-info publishnowBtn" style="text-shadow:none;font-weight:normal;" value="Preview" />
                            -->
                            <input type="submit" name ="news_post" class="btn btn-md btn-info publishnowBtn" style="text-shadow:none;font-weight:normal;" value="Publish" id="getData" onclick="return check();" /></center>
                    </div>
                </form>			



            </div>
        </div>
    </div>
    <!--this script is use for tooltip genrate-->     
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <!--tooltip script end here-->
    <?php include 'footer.php'; ?>