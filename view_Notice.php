<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';?>
	                             
<?php require_once('Class_Library/class_getNotice.php'); 
$object = new GetNotice();

$clientid = $_SESSION['client_id'];
$user_uniqueid = $_SESSION['user_unique_id'];
$user_type = $_SESSION['user_type'];

if(isset($_GET['idnotice']))
{
$nid = $_GET['idnotice'];

$result = $object->deleteNotice($nid);
$output = json_decode($result,true);

$value = $output['success'];
$message = $output['message'];

if($value == 1)
{
echo "<script>alert('$message')</script>";
echo "<script>window.location='view_Notice.php'</script>";
}

}


if(isset($_GET['notice_id']) && isset($_GET['status']))
{
$notice = $_GET['notice_id'];
$status = $_GET['status'];
if($status == 'Live')
{
$status1 = "Expire"; 
}

$result = $object->updateNoticeStatus($notice,$status1);
$output = json_decode($result,true);

$value = $output['success'];
$message = $output['message'];

if($value == 1)
{
echo "<script>alert('$message')</script>";
echo "<script>window.location='view_Notice.php'</script>";
}

}

$result = $object->getAllnotices($clientid,$user_uniqueid,$user_type);
$value = json_decode($result,true);
$val = $value['posts'];
$count  = count($val);
$path = "http://admin.benepik.com/employee/virendra/benepik_client/";

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
                                    <div class="title"><strong>All Notices</strong></div>
                                    </div>
                                   
                                </div>
                             
<script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
                                <div class="card-body">
                                    <table class="datatable table table-responsive" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Notice Name</th>
                                              
                                                <th>Created by</th>
                                                <th>Publishing Date</th>
                                               <!-- <th>UnPublishing Date</th> -->
                                                <th>Status</th>
                                                <th><center>Action</center></th>
                                                 <!--<th>Salary</th>-->
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                               <th>Notice Name</th>
                                              
                                                <th>Created by</th>
                                                <th>Publishing Date</th>
                                              <!--  <th>UnPublishing Date</th>  -->
                                                <th>Status</th>
                                                <th>Action<th>
                                                <!--<th>Salary</th>-->
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                     <?php
                                     for($i=0; $i<$count; $i++)
                                              {
                                              if($val[$i]['status'] == 'Live')
                                              {
                                              $action = "UnPublish";
                                              $gly = "glyphicon glyphicon-eye-close";
                                              $dis = "";
                                              $status = "Live";
                                              }
                                              else
                                              {
                                               $action = "UnPublish";
                                               $status = "Expire";
                                               $gly = "glyphicon glyphicon-eye-open";
                                               $dis = "disabled";
                                              }
                                     // echo $path.$val[$i]['post_img']."<br/>";

                                     ?>       	
					      <tr>
                                             
                                                <td class="padding_right_px"><?php echo $val[$i]['noticeTitle']; ?></td>
                                                 <td class="padding_right_px"><?php echo $val[$i]['name'];  ?></td>
                                                <td class="padding_right_px"><?php   echo $val[$i]['publishingTime'];  ?></td> 
                                               
                                                <td class="padding_right_px"> <?php
/*
$pub = $val[$i]['publishingTime'];
$unpub = $val[$i]['unpublishingTime'];
$object->getStatusOfNotice($pub,$unpub);*/
echo $status; 
?>
</td>

                                               <td style="width:22%;">
                                             <a href="<?php echo $val[$i]['fileName']; ?>" target="_blank"style="color:#00a4fd;margin-left:10px;">View Notice</a>
                                               
                                             <a href ="update_notice.php?noticeid=<?php echo $val[$i]['noticeId'];  ?>"style="color:#00a4fd;margin-left:10px;">Edit</a>

          <a href="view_Notice.php?notice_id=<?php echo $val[$i]['noticeId'];?>&status=<?php echo $status; ?>"style="color:#00a4fd;margin-left:10px;">     

 <button style="background-color:#fff;color:red" class="btn btn-sm" <?php echo $dis .">".$action; ?></button></a>

                                           <!--<a href="view_Notice.php?idnotice=<?php echo $val[$i]['noticeId']; ?>">  <button type="button"class="btn btn-sm btn-default ViewBtn"><span class="glyphicon glyphicon-trash"></span>Delete</button></a>-->
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
			</div>
				<?php include 'footer.php';?>