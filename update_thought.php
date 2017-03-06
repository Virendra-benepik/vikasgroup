<?php include 'navigationbar.php'; ?>
<?php include 'leftSideSlide.php'; ?>

<!-------------------------------SCRIPT START FROM HERE   --------->	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/display_user.js"></script>
<!-------------------------------SCRIPT END FROM HERE   --------->	


<div class="side-body padding-top">
    <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;margin-top:20px;">
        <div class="bs-example">


            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"style="margin:1px !important;">
                    <h4><strong>Update Picture</strong></h4><hr>
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
            require_once('Class_Library/class_thought.php');
            $post = $_GET['idpost'];
            $page = $_GET['page'];
            //echo $post;
            $pageobj = new ThoughtOfDay();
            $result1 = $pageobj->getSinglethought($post);
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
                        <form role="form" method="post" enctype="multipart/form-data" action="Link_Library/link_update_thought.php">
                            <input type="hidden" name = "client" value="<?php echo $cid; ?>">
                            <input type="hidden" name="postid" value="<?php echo $_GET['idpost']; ?>" />
                            <input type="hidden" name="page" value="<?php echo $page; ?>" />
                            <div class="row">
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <label for="Articlecontent">Select Image</label>
                                <script type="text/javascript">
                                    function showimagepreview(input) {
                                        if (input.files && input.files[0]) {
                                            var filerdr = new FileReader();
                                            filerdr.onload = function (e) {
                                                var image = new Image();
												//Set the Base64 string return from FileReader as source.
													   image.src = e.target.result;
															
													   //Validate the File Height and Width.
													   image.onload = function () {
														   var height = this.height;
														   var width = this.width;
														   var size = parseFloat($("#filUpload")[0].files[0].size / 1024).toFixed(2);
                                                if (size > 2000)
                                                {
                                                    alert("Sorry, your Image Size is too large , Max 2MB Size Are Allowed");
                                                    $('#imgprvw').attr('src', '');
                                                    $('.post_img').attr('src', '');
                                                    $('#filUpload').val("");
                                                    return false;
                                                }
												  else if (height > 1000 || width > 1000) {
													   alert("Height and Width must not exceed 1000 X 1000 px.");
														$('#imgprvw1').attr('src', "");
														$('.post_img').attr('src', "");
														 $('#filUpload').val("");
													   return false;
												   }
												   else
												   {
													   //alert ("image gud");
														$('#imgprvw1').attr('src', e.target.result);
														$('.post_img').attr('src', e.target.result);
												   }
											}
												//$('#imgprvw1').attr('src', e.target.result);
                                                //$('.post_img').attr('src', e.target.result);
                                            }
                                            filerdr.readAsDataURL(input.files[0]);
                                        }
                                    }
                                </script>
                                <img id="imgprvw1" alt="uploaded image preview" style="margin-bottom:5px; float:right; height:110px; width:200px;border:1px solid #f1f1f0;" 
                                     src='<?php echo $result[0]['thoughtImage']; ?>' onerror='this.src="images/u.png"'/>
                                <div>
                                      <input type="hidden" name="himage" value ="<?php echo $result[0]['thoughtImage']; ?>" />
                              <input type="file" name="uploadimage" id="filUpload" onchange="showimagepreview(this)" />
                                </div>
                            </div>

                            <div class="form-group col-xs-12 col-sm-8 col-md-8 col-lg-8 myImageRight">
                                <div class="form-group">
								<label for="Articlecontent">Description</label>
								<textarea id="content" name="content" rows="5" cols="80"><?php echo $result[0]['message']; ?></textarea>
								</div>
                            </div>
							</div>

                                <div class="row">
                                   <div class="form-group col-sm-12">
                                        <center><input type="submit" name ="news_post" class="btn btn-md btn-info commonColorSubmitBtn" style="text-shadow:none;font-weight:normal;" value="Save Now" id="getData" /></center>
                                    </div>

                                </div>
                        
                    
                            </form>
                </div>
               
            </div>
            
        </div>
    </div>			

</div>

</div>
<?php include 'footer.php'; ?>