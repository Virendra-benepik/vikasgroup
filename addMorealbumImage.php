<?php
include  'navigationbar.php';
include 'leftSideSlide.php';
?>

<?php 
require_once('Class_Library/class_upload_album.php');
$value = $_GET['albumid'];
$clientid = $_SESSION['client_id'];
$obj = new Album();

$device = "panel";
$result= $obj->getAlbumImage($value,$device);
$value1 = json_decode($result,true);

//echo "<pre>";
//print_r($value1);
//echo "</pre>";
?>

<!--this js file for upload multiple image at a time -->
<script type="text/javascript" src="js/multipleImageUpload.js"></script>
<!--<script src="js/display_group.js"></script>-->
<!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.10.1.js"></script>-->
<!--<script src="js/validation/createPostValidation.js"></script>-->

<script>
    function ValidatePostalbum()
    {
        var title = document.postalbumform.title;
        var fi = document.getElementById("files");
        if (title.value == "")
        {
            window.alert("Please Enter Album Title.");
            title.focus();
            return false;
        }
        if (fi.value == "")
        {
            window.alert("Please Select Image");
            fi.focus();
            return false;
        }
//        
        return true;
    }
</script>
<script>
    function check() {
        if (confirm('Are You Sure, You want to publish this post?')) {
            return true;
        } else {
            return false;
        }
    }
</script>
<!--this css file for upload multiple image at a time -->
<link rel="stylesheet" type="text/css" href="css/multipleImageUpload.css">



<div class="container" style="margin-left:10%;margin-top:80px;; border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;" ><br>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h3><strong>Gallery</strong></h3><hr>
    </div>

    <div class="row">
        <form method="post" name="postalbumform" action="Link_Library/link_addMoreImage.php" enctype="multipart/form-data"  onsubmit="return check()">

            <input type="hidden" name = "device" id="device" value="d2">	
            <input type="hidden" name = "useruniqueid" value="<?php echo $_SESSION['user_unique_id']; ?>">
             <input type="hidden" name = "albumeid" value="<?php echo $value1['posts'][0]['albumId']; ?>">
            <input type="hidden" name = "clientid" value="<?php echo $_SESSION['client_id']; ?>">	

            <div  class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group">
                            <label for="title">Album Title</label>
                            <input style="color:#2d2a3b;" type="text" class="form-control" id="" name="title" value="<?php echo $value1['posts'][0]['title']; ?>" readonly/>
                        </div>
                    </div>
                </div>
                <!--
                <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label for="comment">Description</label>
                    <textarea style="color:#2d2a3b;"class="form-control" name="desc" rows="2" id="" placeholder="Description..."></textarea>
                </div>
            </div>
        </div>
                -->
                <style>
                    .image-upload > #files{ display: none;}
                </style>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="image-upload">
                            <label for="files" style="background-image:url('img/uu.png');background-size:100% 100%;border:1px dotted #cdcdcd;height:120px;">
                                <p class="filetext" style="padding: 24px;  margin-top: 63px;  font-size: 23px;"> Select File </p>
                            </label><br> 
                            Select Multiple Images to upload

                            <input type="file" id="files" accept="image/*" name="album[]" multiple />

                        </div>

                    </div>
                </div>





            </div>     

            <!---------------------------------- option ----------------------------------->

           <div class="col-xs-4 col-md-4 col-lg-4 col-sm-4"id="rightpublicationdiv">
                <div class="publication" style="margin-top:20px;">
                   

                    <div class="publication"><p id="publication_heading">Notification</p><hr>

                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
                                <p class="publication_leftcontent"style="font-weight:500;"data-toggle="tooltip" data-placement="left" title="Push Notification.. Enable/Disable In Case of Enable(On) User Receive Notification of respective post">Push ?</p>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"id="rightpublicationdiv6">
                                <div class="checkbox"style="margin-top:-10px;">
                                    <label><input type="checkbox" data-toggle="toggle" name="push" value="PUSH_YES" checked></label></div>

                            </div>

                        </div>
                    </div>

                </div>

            </div>



            <!-------------------------- option end ----------------------------------------->
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                    <output id="list"></output>
                </div>
            </div>


            <!------------------------ select group -------------------------------------------->
<!--            <div class="row">
                <div ng-app="" class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                    <div class="form-group col-sm-12">


                        <label for="exampleInputPassword1" style="padding-left:3px;">Select Group</label>
                        <div>
                            
                            <div class="col-md-6">
                                <input type="radio" id="user" ng-model="content"  name="user3" value="Selected">
                                <label for="radio6">
                                    Select Groups
                                </label>
                            </div>
							<div class="col-md-6">
                                <input type="radio" id="user2" name="user3" ng-model="content" value="All" ng-checked="true">
                                <label for="radio5">
                                    Send Post to All Groups
                                </label>
                            </div>
                        </div>

                    </div>
                    -------------------this script for show textbox on select radio button--------------------                        



                    ----------Abobe script for show textbox on select radio button--------------------
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
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"></div>
            </div>-->
            <!------------------------ end select group ----------------------------------------->



            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
                    <!--<output id="list"></output>-->
                    <input type="submit" name="submit" value="Publish" style="background-color:#015DA8;border:0px; solid:#284dbd;height:35px;width:70px;COLOR:#FFF;margin-left:500px;" onclick="return ValidatePostalbum();">
                </div>
            </div>
        </form>
    </div>
</div>
<?php include 'footer.php'; ?> 