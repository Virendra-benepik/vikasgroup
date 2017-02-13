<?php  include 'navigationbar.php';?>
<?php  include 'leftSideSlide.php';?>

<?php  include 'Class_Library/class_get_group.php';
require_once('Class_Library/class_get_useruniqueid.php');
$gt = new UserUniqueId();
?>                   
<?php 
session_start();
$clientid = $_SESSION['client_id'];

$obj = new Group();

$result = $obj->getGroup($clientid);
$value = json_decode($result, TRUE);
$getcat = $value['posts'];

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
                                    <div class="title"><strong>View Groups</strong></div>
                                    </div>
                                   
                                </div>
                                

                                <div class="card-body">
                                    <table class="datatable table table-responsive" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Group Name</th>
                                                
                                                <th>Description</th>
                                                <th>Created by</th>
                                                <th>Created Date</th>
                                              <!--  <th>Status</th>-->
                                                <th>Action</th> 
                                                 <!--<th>Salary</th>-->
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                               <th>Page Name</th>
                                               
                                                <th>Description</th>
                                                <th>Created by</th>
                                                <th>Created Date</th>
                                               <!--- <th>Status</th>-->
                                                <th>Action<th> 
                                                <!--<th>Salary</th>-->
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                     <?php
                                   
                                     for($i=0; $i<count($getcat); $i++)
                                       {
                                     ?>       	
					      <tr>
                                             
                                                <td class="padding_right_px"><?php echo $getcat[$i]['groupName']; ?></td>
                                               
                                                <td class="padding_right_px"><?php echo $getcat[$i]['groupDescription']; ?></td>
                                                 <td class="padding_right_px"><?php 
                                                
                                                 $uid = $getcat[$i]['createdBy'];
                                               //  echo $uid;
                                                $na = $gt->getUserData($clientid,$uid);
                                               $name = json_decode($na,true);
                                              echo  $name[0]['firstName']." ".$name[0]['lastName'];
                                                 ?></td>
                                                <td class="padding_right_px"><?php echo $getcat[$i]['createdDate'];  ?></td>
                                              
                                           <!---   <td><button type="button"class="btn btn-sm  btn-success"><span class="glyphicon glyphicon-thumbs-up"></span><?php echo $val[$i]['status']; ?></button></td> -->
                                              <td>
 <!--   <a href="update_channel.php?clientid=<?php echo $getcat[$i]['clientId']; ?>&groupid=<?php echo $getcat[$i]['groupId']; ?>"><button type="button"class="btn btn-sm  editbtn"><span class="glyphicon glyphicon"></span>Edit</button></a> -->
                                               
                                            <a href="view_oneChannel.php?clientid=<?php echo $getcat[$i]['clientId']; ?>&groupid=<?php echo $getcat[$i]['groupId']; ?>"style="color:#00a4fd;margin-left:10px !important;"><span class="glyphicon glyphicon"></span>View</a>
                                               </td> 
                                            </tr>
                                      <a href="Link_Library/post_status.php?postid=<?php echo $val[$i]['post_id']; ?>&poststatus=<?php echo $val[$i]['status']; ?>" style="color:#CE3030;margin-left:30px !important">

<?php echo $action; ?>

</a>
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
			</div>
				<?php include 'footer.php';?>