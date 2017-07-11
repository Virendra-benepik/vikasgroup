<?php  include 'navigationbar.php'; ?>
<?php include 'leftSideSlide.php'; ?>
<?php
session_start();
require_once('Class_Library/class_complaints.php');
?>
<?php
$value = $_GET['idpost'];
$obj = new Complaint();

$result = $obj->getonecomplain($value);
$value = json_decode($result, true);
//echo "<pre>";
//print_r($value);
//echo "</pre>";
$path = SITE;
?>
<div class="row"style="margin-left:5%;margin-right:0%;">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div style="width:100%;height:auto;margin-top: 80px; border:1px solid #cdcdcd;">

<!--- heading ------------------>
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div style="width:100%;height:auto;margin-top: 0px;">
		<div class="col-xs-12">
            <div class="card">
				<div class="card-header">
                    <div class="card-title">
                        <div class="">
						<h3><b>Feed Us Back Details</b></h3>
						</div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
</div>
<!----- / heading -------------->

            <div class="row" style="margin-top:15px; margin-left:10px;">
                
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8"> 

                  <!--  <div class="row">
                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                            <img src="<?php echo $path . $_SESSION['image_name']; ?>" class='img' id='user_image' style='margin-right:5px;' onerror='this.src = "images/usericon.png" ' >

                        </div>

                        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
                            <p><b><?php echo $_SESSION['suggestionArea']; ?></b></p>
                            <p><small>
                                    <?php echo "<div >" . $value['posts'][0]['date_of_sugestion'] . "</div>"; ?></small></p>

                        </div>
                    </div>---->
                    <!--<hr style="margin-top:0px ;">-->
                    <?php
					
					echo "<div class='row'><div class=' col-sm-6 col-md-2 col-lg-2'><p><b>Employee Id : </b></p></div><div class=' col-sm-6 col-md-10 col-lg-10'><p class='fontsize'>". $value['posts'][0]['employeeCode']."</p></div></div>";
					
					echo "<div class='row'><div class=' col-sm-6 col-md-2 col-lg-2'><p><b>Feed back By : </b></p></div><div class=' col-sm-6 col-md-10 col-lg-10'><p class='fontsize'>". $value['posts'][0]['complaintBy']."</p></div></div>";
					
					echo "<div class='row'><div class=' col-sm-6 col-md-2 col-lg-2'><p><b>Company : </b></p></div><div class=' col-sm-6 col-md-10 col-lg-10'><p class='fontsize'>". $value['posts'][0]['Companyname'] ."</p></div></div>";
					
					echo "<div class='row'><div class=' col-sm-6 col-md-2 col-lg-2'><p><b>Feed Back : </b></p></div><div class=' col-sm-6 col-md-10 col-lg-10'><p class='fontsize'>". $value['posts'][0]['content'] ."</p></div></div>";
					
					echo "<div class='row'><div class=' col-sm-6 col-md-2 col-lg-2'><p><b>Date : </b></p></div><div class=' col-sm-6 col-md-10 col-lg-10'><p class='fontsize'>". $value['posts'][0]['date_of_complaint'] ."</p></div></div>";
                   
				   /*echo "<p><b>Feed back By : </b>" . $value['posts'][0]['complaintBy']."</p>";
				   echo "<p><b>Company : </b>" . $value['posts'][0]['Companyname']."</p>";
				   echo "<p><b>Feed back : </b>" . $value['posts'][0]['content']."</p>";
				   echo "<p><b>Date : </b>" . $value['posts'][0]['date_of_complaint']."</p>";*/
                    ?>
                   
                </div>
                
				<div class=" col-sm-4 col-md-4 col-lg-4"></div>
            </div>


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