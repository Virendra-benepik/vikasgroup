<?php include 'navigationbar.php'; ?>
<?php include 'leftSideSlide.php'; ?>

<!-------------------------------SCRIPT START FROM HERE   --------->	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/display_user.js"></script>
<!-------------------------------SCRIPT END FROM HERE   --------->	
<script>
    function check() {
        if (confirm('Are You Sure, You want to publish this post?')) {
            return true;
        } else {
            return false;
        }
    }
</script>
<script>
function ValidateMessage()
{
    var posttitle = document.form1.posttitle;
	//alert(posttitle);
	var postcontent = document.form1.postcontent;
    if (posttitle.value == "")
    {
        window.alert("Please Enter Title.");
        posttitle.focus();
        return false;
    }
	if (postcontent.value == "")
    {
        window.alert("Please Enter Message.");
        postcontent.focus();
        return false;
    }
	return true;
}
</script>

<div class="side-body padding-top">
    <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;margin-top:20px;">
        <div class="bs-example">


            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"style="margin:1px !important;">
                    <h4><strong>Update Message</strong></h4><hr>
                    <?php
                    if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                    }
                    ?>

                </div>

            </div>
            <br>

            <?php
            unset($_SESSION['msg']);
            ?>
            <?php
            require_once('Class_Library/class_getpost.php');
            $post = $_GET['idpost'];
            $page = $_GET['page'];
            //echo $post;
            $pageobj = new GetPost();
            $result1 = $pageobj->getSinglePost($post);
            $result = json_decode($result1, true);
           //print_r($result);
            //$path = $result[0]['fileName'];
            $cid = $result[0]['clientId'];
            ?>
            <!------------------------------------------message portal start from here------------------------------------------------>	
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <!----------------------------------------message  start from here---------------------------------------->	
                    <div class="row">
                        <form role="form" name="form1" method="post" enctype="multipart/form-data" action="Link_Library/link_update_message.php" onsubmit="return check();">
                            <input type="hidden" name = "client" value="<?php echo $cid; ?>">
                            <input type="hidden" name="postid" value="<?php echo $_GET['idpost']; ?>" />
                            <input type="hidden" name="page" value="<?php echo $page; ?>" />
							
						<div class="row">
						 <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						 
						   <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="Articlecontent">Message Title</label>
                                    <input type="text" name="posttitle" class="form-control" value="<?php echo $result[0]['post_title']; ?>">
                                </div>
                            </div>

                            
                               
                            </div>
							

                            
                            <div class="row">
                                <div class="form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                              
                                    <label for="Articlecontent">Message</label>
                                    <textarea cols="105" id="editor1" name="postcontent" rows="10"><?php echo $result[0]['post_content']; ?></textarea>
                                </div>
                            </div>
							
							<div class="row">
								   
						    <div class=" form-group col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <center><input type="submit" name ="news_post" class="btn btn-md btn-info commonColorSubmitBtn" style="text-shadow:none;font-weight:normal;" value="Save Now" id="getData" onclick="return ValidateMessage();"/></center>
                                    </div>

                                </div>
								</div>
					 <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"></div>
                        
                    </div>
					
                            </form>
                </div>
               
            </div>
            
        </div>
    </div>			

</div>

</div>
<?php include 'footer.php'; ?>