<?php include 'navigationbar.php';?>
		<?php include 'leftSideSlide.php';?>
	                             
<?php require_once('Class_Library/class_event.php');

$object = new Event();

$clientid = $_SESSION['client_id'];

$result = $object->getAlleventslist($clientid);
$val = json_decode($result,true);
//echo "<pre>";
//print_r($val);
$count  = count($val['Data']);


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
                                    <div class="title"><strong>All Event Details</strong></div>
                                    </div>
                                 <!--   <div style="float:left; margin-top:13px; font-size:20px;"> 
                                    <a href="create_event.php">
                 <button type="button" class="btn btn-primary btn-sm">Create New Event</button>
                                    </a>
                                     </div>-->
                                </div>
                                

                                <div class="card-body">
                                    <table class="datatable table table-responsive" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                               <th>Image</th>
                                                <th>Title</th>
												<th>Total View</th>
												<th>Unique View</th>
                                                 <!--<th>Venue</th>
                                                 <th>Event Time</th>
												 <th>Event Cost</th>-->
												 <th>Registration</th>
                                                <th>Created By</th>
                                                <th>Status</th>
                                               <th>Created Date </th>
											   <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                              <th>Image</th>
                                                <th>Title</th>
												<th>Total View</th>
												<th>Unique View</th>
                                                <!--<th>Venue</th>
                                                 <th>Event Time</th>
												 <th>Event Cost</th>-->
												 <th>Registration</th>
                                                <th>Created By</th>
                                                <th>Status</th>
                                               <th>Created Date </th>
											   <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                     <?php
                                    require_once('Class_Library/class_get_useruniqueid.php');
									$gt = new UserUniqueId(); 
                                     for($i=0; $i<$count; $i++)
                                              {
                                               $k = $val['Data'][$i]['status'];
                                              
												if($k == 'Unpublish')
												{
												$action = 'Publish';
												}
												else
												{
												$action = 'Unpublish';
												}
                                              
                                     ?>       	   	
					      <tr>
                                              <td>

<img src="<?php echo $val['Data'][$i]['imageName']; ?>"class="img img-rounded"id="news_images" onerror='this.src="images/u.png"'/> </td>
                                               
                                                <td style="width:14% !important;"><?php 
                                               $cont =  $val['Data'][$i]['title'];
                                        $words = explode(" ",$cont);
                                        $word = implode(" ", array_splice($words, 0, 10));
                                                echo $word; 
                                                
                                               // echo $val[$i]['title']; ?></td>
											    <td><?php echo $val['Data'][$i]['TotalCount']; ?></td>
												 <td><?php echo $val['Data'][$i]['ViewPostCount']; ?></td>
                                                <!--<td><?php echo $val['Data'][$i]['venue']; ?></td>
                                                <td><?php echo $val['Data'][$i]['eventTime']; ?></td>
                                                  <td><?php echo $val['Data'][$i]['eventCost']; ?></td>-->
                                                <td><?php echo $val['Data'][$i]['registration']; ?></td>
                                               <td>
                                           <?php    $uid = $val['Data'][$i]['createdBy'];
                                              $na = $gt->getUserData($clientid,$uid);
                                              $name = json_decode($na,true);
                                              echo  $name[0]['firstName']." ".$name[0]['lastName'];
                                              ?></td>

                               <td><?php echo $val['Data'][$i]['status']; ?></td>
                                         <td><?php echo $val['Data'][$i]['createdDate'];  ?></td>
                                              
                                     <td  style="width:16% !important;">
<!--<a onClick="javascript:if(confirm('Are you sure want to Delete Post ?')){return true;} else{return false}" href="Link_Library/delete_post.php?idpost=<?php echo $val['Data'][$i]['post_id']; ?>">
<button type="button"class="btn btn-sm  btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete
</button>
</a>-->

<!--<a target="_blank" href="full_view_news.php?idpost=<?php echo $val['Data'][$i]['post_id']?>"><button type="button"class="btn btn-sm btn-info viewNewsBtn"> View
</button></a>

<a href="Link_Library/post_status.php?postid=<?php echo $val['Data'][$i]['post_id']; ?>&poststatus=<?php echo $val['Data'][$i]['status']; ?>">
<button type="button"class="btn btn-sm btn-danger unpublishBtn">
<?php echo $action; ?>
</button>
</a>-->

<a href="view_event_registration.php?eventid=<?php echo $val['Data'][$i]['eventId']; ?>&clientid=<?php echo $val['Data'][$i]['clientId']; ?>">
<button type="button" class="btn btn-sm btn-danger unpublishBtn" 
<?php 
$res = ($val['Data'][$i]['registration'] == "No")? 'disabled' : '';
echo $res; ?>
>
Registration report
</button>
</a>
<a href="Full_view_event.php?eventid=<?php echo $val['Data'][$i]['eventId']; ?>&clientid=<?php echo $val['Data'][$i]['clientId']; ?>" style="color:#00a4fd;margin-left:30px !important">
View
</a>
<!--<a href="view_queriesreport.php?eventid=<?php echo $val['Data'][$i]['eventId']; ?>&clientid=<?php echo $val['Data'][$i]['clientId']; ?>" style="color:#00a4fd;margin-left:30px !important">
<button type="button" class="btn btn-sm btn-danger unpublishBtn">
Queries Report
</button>
</a>-->




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