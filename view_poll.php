<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';?>
	                             
<?php require_once('Class_Library/class_poll.php');
session_start();
require_once('Class_Library/class_get_useruniqueid.php');
$gt = new UserUniqueId();
$poll_obj = new Poll();
$clientid = $_SESSION['client_id'];
$user_uniqueid = $_SESSION['user_unique_id'];
$user_type = $_SESSION['user_type'];

$result = $poll_obj->pollDetails($clientid,$user_uniqueid,$user_type);
$getcat = json_decode($result,true);

$value = $getcat['posts'];
$count = count($value);

if(isset($_GET['poll_id']) && isset($_GET['status']))
{
$idpoll = $_GET['poll_id'];
$status = $_GET['status'];

if($status == 'Live')
{
$status1 = "Expired"; 
}
$result = $poll_obj->updatePollStatus($idpoll,$status1);
$output = json_decode($result,true);

$value = $output['success'];
$message = $output['message'];

if($value == 1)
{
echo "<script>alert('$message')</script>";
echo "<script>window.location='view_poll.php'</script>";
}

}

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
                                    <div class="title">Feedback Details</div>
                                    </div>
                                    <div style="float:top; margin-top:13px; font-size:20px;"> 
                                    <a href="create_poll.php">
                 <button type="button" class="btn btn-primary btn-sm">Create New Feedback</button>
                                    </a>
                                     </div>
                                </div>
                                

                                <div class="card-body">
                                    <table class="datatable table table-responsive" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Feedback Images</th>
                                                
                                                <th>Feedback Question</th>
                                                <th>Created by</th>
                                                <th>Created Date</th>
                                                <th>Status</th>
                                                <th><center>Action</center></th>
                                                 <!--<th>Salary</th>-->
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Feedback Images</th>
                                                
                                                <th>Feedbacks Question</th>
                                                <th>Created by</th>
                                                <th>Created Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                                 <!--<th>Salary</th>-->
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                     <?php
                                     for($i=0; $i<$count; $i++)
                                       {
if($value[$i]['status']=='Live')
{
$sta = "Unpublish";
$gly = "glyphicon glyphicon-eye-close";
$dis = "";
$status="Live";
}
else
{
$sta = "Unpublish";
$gly = "glyphicon glyphicon-eye-open";
$dis = "disabled";
$status="Expire";
}


$imagevalue = $value[$i]['pollImage'];

if($imagevalue!="")
{$valueimage = $imagevalue; }
else
{$valueimage = "Poll/poll_img/dummy.png";}

                                     ?>       	
					      <tr>
                                              <td>
                                  
                                              <img style="width: 150px;height: 100px;border-radius: 4px;" src="<?php echo $valueimage ; ?>" />
                                              </td>
                                                <td class="padding_right_px"><?php 
if(strlen($value[$i]['pollQuestion'])>50)
{
echo substr($value[$i]['pollQuestion'],0,50)."<b>...</b>";
}
else
{
echo $value[$i]['pollQuestion'];
} ?></td>
                                             <td class="padding_right_px"><?php
                                               $uid = $value[$i]['createdBy'];
                                            //   echo $uid;
                                              $na = $gt->getUserData($clientid,$uid);
                                            //  echo $na;
                                               $name = json_decode($na,true);
                                              echo  $name[0]['firstName']." ".$name[0]['lastName'];
                                              ?></td>
                                             <td class="padding_right_px"><?php echo $value[$i]['publishingTime']; ?></td>                                             
                                             <td class="padding_right_px"><?php echo $value[$i]['status'];  ?></td>
<td>

<a href="view_poll.php?poll_id=<?php echo $value[$i]['pollId'];?>&status=<?php echo $status; ?>">
<button style="background-color:#fff;color:red" type="button" onclick="return confirm( 'Are you sure you want to unpublish this Feedback?');" class="btn btn-sm" <?php echo $dis .">".$sta; ?></span></button></a>

<a href="view_poll_result.php?pollid=<?php echo $value[$i]['pollId']; ?>&clientid=<?php echo $value[$i]['clientId']; ?>" style="color:#00a4fd;margin-left:29px !important;">Result</a>
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