<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';?>
	                             
<?php require_once('Class_Library/class_getPages.php'); 
require_once('Class_Library/class_get_useruniqueid.php');
$gt = new UserUniqueId();
$clientid = $_SESSION['client_id'];

$object = new GetPages();

if(isset($_GET['page_id']) && isset($_GET['status']))
{
$page = $_GET['page_id'];
$status = $_GET['status'];

$result = $object->updatePageStatus($page,$status);
$output = json_decode($result,true);

$value = $output['success'];
$message = $output['message'];

if($value == 1)
{
echo "<script>alert('$message')</script>";
echo "<script>window.location='view_page.php'</script>";
}

}

$result = $object->getAllpages($clientid);
$val = json_decode($result,true);
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
                                    <div class="title"><strong>View Policy</strong></div>
                                    </div>
                                   
                                </div>
                                

                                <div class="card-body">
                                    <table class="datatable table table-responsive" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Page Name</th>
                                              
                                                <th>Created by</th>
                                                <th>Created Date</th>
                                                <th>Status</th>
                                                <th><center>Action</center></th>
                                                 <!--<th>Salary</th>-->
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                               <th>Page Name</th>
                                              
                                                <th>Created by</th>
                                                <th>Created Date</th>
                                                <th>Status</th>
                                                <th>Action<th>
                                                <!--<th>Salary</th>-->
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                     <?php
                                     for($i=0; $i<$count; $i++)
                                              {
                                              if($val[$i]['status'] == 'Show')
                                              {
                                              $action = "Hide";
                                              $gly = "glyphicon glyphicon-eye-close";
                                              }
                                              else
                                              {
                                               $action = 'Show';
                                               $gly = "glyphicon glyphicon-eye-open";
                                              }
                                     // echo $path.$val[$i]['post_img']."<br/>";

                                     ?>       	
					      <tr>
                                             
                                                <td class="padding_right_px"><?php echo $val[$i]['pageTitle']; ?></td>
                                                 <td class="padding_right_px"><?php //echo $val[$i]['createdBy'];  
                                                 $uid = $val[$i]['createdBy'];
                                               $na = $gt->getUserData($clientid,$uid);
                                               $name = json_decode($na,true);
                                              echo  $name[0]['firstName']." ".$name[0]['lastName'];
                                                 
                                                 
                                                 ?></td>
                                                <td class="padding_right_px"><?php echo $val[$i]['createdDate'];  ?></td>
                                              
                                              <td class="padding_right_px"><?php echo  $val[$i]['status']; ?></td>
                                               <td>
                                             <a href="<?php echo $val[$i]['fileName']; ?>" target="_blank" style="color:#00a4fd;margin-left:29px !important;" > View Page</a>
                                               
                                             <a href ="update_page.php?pageid=<?php echo $val[$i]['pageId'];  ?>" style="color:#00a4fd;margin-left:29px !important;">Edit</a> 
                <a href="view_page.php?page_id=<?php echo $val[$i]['pageId']?>&status=<?php echo $action; ?>" style="color:#CE3030;margin-left:29px !important;"><?php echo $action; ?>
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