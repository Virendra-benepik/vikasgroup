<?php include 'navigationbar.php';?>
		<?php include 'leftSideSlide.php';?>
	                             
<?php require_once('Class_Library/class_eventSponsership.php'); 
$object = new Sponsership();

$clientid = $_SESSION['client_id'];

$result = $object->getContributorList($clientid);
$val = json_decode($result,true);
//echo "<pre>";
//print_r($val);
$count  = count($val['Data']);
$servername = $_SERVER['SERVER_NAME'];
//$path = SITE;


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
									
									ALL Contribute Details</strong></div>
                                    </div>
                                    <div style="float:left; margin-top:13px; font-size:20px;"> 
                                    <a href="eventsponsorship.php">
                 <button type="button" class="btn btn-primary btn-sm">Add Contribute</button>
                                    </a>
                                     </div>
                                </div>
                                

                                <div class="card-body">
                                    <table class="datatable table table-responsive" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Title</th>
												<th>Total View</th>
												<th>Unique View</th>
												<th>Like</th>
												<th>Comment</th>
												<th>Created By</th>
												<th>Status</th>
												<th>Last Updates</th>
												<th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                              <th>Image</th>
                                                <th>Title</th>
												<th>Total View</th>
												<th>Unique View</th>
												<th>Like</th>
												<th>Comment</th>
												<th>Created By</th>
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
												if($k == 'Publish')
												{
												$action = 'Publish';
												}
												else
												{
												$action = 'Unpublish';
												}
												
												if($k == 'Publish')
												{
													$act = 'Unpublish';
												}
												else
												{
													$act = 'Publish';
												}
                                     

                                     ?>       	
					      <tr>
						  
                                              <td>
                                  
                                              <img src="<?php echo $val['Data'][$i]['post_img']; ?>"class="img img-rounded"id="news_images" onerror='this.src="images/u.png"'/>
                                              </td>
                                                <td>
												<?php 
                                                 echo $val['Data'][$i]['post_title'];
                                                 ?></td>
												 <td><?php echo $val['Data'][$i]['TotalCount']; ?></td>
												 <td><?php echo $val['Data'][$i]['ViewPostCount']; ?></td>
												 <td><?php echo $val['Data'][$i]['likeCount']; ?></td>
												 <td><?php echo $val['Data'][$i]['commentCount']; ?></td>
												<td><?php echo $val['Data'][$i]['created_by']; ?></td>
												<td><?php echo $action; ?></td>
												
												<td><?php echo $val['Data'][$i]['created_date']; ?></td>
												
                                                <td>
												 <a target="_blank" href="full_view_contributor.php?idpost=<?php echo $val['Data'][$i]['post_id']; ?>" style="color:#00a4fd;margin-left:29px !important;">View</a>
												 
												<a href="Link_Library/contributor_status.php?postid=<?php echo $val['Data'][$i]['post_id']; ?>&poststatus=<?php echo $val['Data'][$i]['status']; ?>" style="color:#CE3030;margin-left:30px !important">
												<?php echo $act; ?>
												</a>
												
												<a target="_blank" href="contributor_queryreport.php?idpost=<?php echo $val['Data'][$i]['post_id']; ?>&clientid=<?php echo $clientid; ?>" style="color:#00a4fd;margin-left:29px !important;">
												<button type="button" class="btn btn-sm btn-danger unpublishBtn">
												Queries Report
												</button></a>												
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