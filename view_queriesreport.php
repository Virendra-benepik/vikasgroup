<?php include 'navigationbar.php';?>
		<?php  include 'leftSideSlide.php';?>
	                             
<?php require_once('Class_Library/class_event.php'); 
$obj = new Event();
//$path = "http://admin.benepik.com/employee/virendra/Mahle_AdminPanel/";
?>
	<!----------------------------------------------------------->
<?php
$eventid = $_GET['eventid'];
$clientid = $_GET['clientid'];
$val1 = $obj->getqueriesreport($clientid,$eventid);

$val = json_decode($val1,true);

//echo "<pre>";
//print_r($val);

$count = count($val['Data']);
//echo $count;
?>
	<!--------------------------------------------------------->
	
	
			<div class="container-fluid">
			<!--<div class="addusertest">
			<a href="create_post.php"><button type="button"class="btn btn-sm btn-default" style="text-shadow:none;"><b>Create Post</b></button></a>
	</div> -->
	              <div class="side-body">
                   
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="card">
                                <div class="card-header">

                                    <div class="card-title">
                                    <div class="title">Suggestion Report</div>
                                    </div>
                                </div>
  
                                <div class="card-body">
                                    <table class="datatable table table-responsive" cellspacing="2" width="100%" id="myTable">
                                        <thead>
                                            <tr>
                                               
                                                <th>Name</th>
                                                <th>Event Title</th>
                                                <th>Query</th>
                                                <th>Created Date</th>
                                                <th>Action</th> 
                                               
                                              
                                            </tr>
                                        </thead>
                                       <tfoot>
                                            <tr>
                                              <th>Name</th>
                                                <th>Event Title</th>
                                                <th>Query</th>
                                                <th>Created Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot> 
                                        <tbody>
                                     <?php
                                 
                                     for($i=0; $i<$count; $i++)
                                              {
                                             
                                     ?>       	
					      <tr>
                                             
                                                
                                                
                                                 <td><?php echo $val['Data'][$i]['name']; ?></td>
                                                 <td><?php echo $val['Data'][$i]['title']; ?></td>
												 
												<?php 
												$string = strip_tags($val['Data'][$i]['query']);
												if (strlen($string) > 50) 
												{
												$stringCut = substr($string, 0, 50);
												
												$string = substr($stringCut, 0, strrpos($stringCut, ' '))."....<a style='color:#00a4fd;margin-left:30px !important' href='full_view_query.php?queryid=".$val['Data'][$i]['autoId']."&eventid=".$eventid."'>Read More</a>";   
												}
										        ?>		 
												 
												 
												 <td><?php echo $string; ?></td>
                                                 <!--<td><?php echo $val['Data'][$i]['query']; ?></td>-->
                                                 <td><?php echo $val['Data'][$i]['createdDate']; ?></td>
												 <td>
												 <a href="full_view_query.php?queryid=<?php echo $val['Data'][$i]['autoId']; ?>&eventid=<?php echo $eventid; ?>" style="color:#00a4fd;margin-left:30px !important">
												 View
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