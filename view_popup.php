<?php include 'navigationbar.php';?>
		<?php include 'leftSideSlide.php';?>
	                             
<?php require_once('Class_Library/class_post_popup.php'); 
$object = new PostPopup();

$clientid = $_SESSION['client_id'];
$user_uniqueid = $_SESSION['user_unique_id'];
$user_type = $_SESSION['user_type'];

$result = $object->getAllPopUp($clientid);
$val = json_decode($result,true);
//echo "<pre>";
//print_r($val);
$count  = count($val['Data']);
$servername = $_SERVER['SERVER_NAME'];
$path = SITE;


?>
	
			<div class="container-fluid">
			<div class="addusertest">
			
	</div>
	              <div class="side-body">
                   <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;margin-top:20px;">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="card">
                                <div class="card-header">

                                    <div class="card-title">
                                    <div class="title"><strong>
									
									ALL PopUp Details</strong></div>
                                    </div>
                                    <div style="float:left; margin-top:13px; font-size:20px;"> 
                                    <a href="postpopup.php">
                 <button type="button" class="btn btn-primary btn-sm">Create New PopUp</button>
                                    </a>
                                     </div>
                                </div>
                                

                                <div class="card-body">
                                    <table class="datatable table table-responsive" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
												<th>Post Name</th>
                                                <!--<th>Caption</th>-->
                                                <th>Status</th>
												<th>Last Updates</th>
												<th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                              <th>Image</th>
											  <th>Post Name</th>
                                                <!--<th>Caption</th>-->
												<th>Status</th>
                                                <th>Last Updates</th> 
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                     <?php
                                 //    print_r($val);
                                     for($i=0; $i<$count; $i++)
                                              {
                                              
                                             $k = $val['Data'][$i]['status'];
												if($k == 1)
												{
												$action = 'Active';
												}
												else
												{
												$action = 'Inactive';
												}
												
												if($k == 1)
												{
													$act = 'Inactive';
												}
												else
												{
													$act = 'Active';
												}
                                     

                                     ?>       	
					      <tr>
						  
                                              <td>
                                  
                                              <img src="<?php echo $val['Data'][$i]['imageName']; ?>"class="img img-rounded"id="news_images" onerror='this.src="images/u.png"'/>
                                              </td>
											  <td><?php echo $val['Data'][$i]['moduleName']; ?></td>
                                               <!-- 
											   <td><p style="width:15% !important;">
												<?php 
                                                 echo $val['Data'][$i]['imageCaption'];
                                                 ?></p></td>
												 -->
                                                <td><?php echo $action; ?></td>
												<td><?php echo $val['Data'][$i]['createdDate']; ?></td>
                                                <td>
												<a href="Link_Library/popup_status.php?postid=<?php echo $val['Data'][$i]['popupId']; ?>&poststatus=<?php echo $val['Data'][$i]['status']; ?>" style="color:#CE3030;margin-left:30px !important">
												<?php echo $act; ?>
												</a>
												</td>
                                                
                                            
                                               
                                            </tr>
                                      
                                        <?php
                                        }
                                        ?>
                                          </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
				<?php include 'footer.php';?>