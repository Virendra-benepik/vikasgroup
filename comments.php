<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';?>	                             
<?php require_once('Class_Library/class_getComment.php');
require_once('Class_Library/class_get_useruniqueid.php');
$gt = new UserUniqueId();
 
$object = new GetComment();

if(isset($_GET['com_id']))
{
$id_com = $_GET['com_id'];
$result = $object->delete_comment($id_com);
if($result)
{echo "<script>alert('Comment delete successfully')</script>";}
}

if(isset($_GET['comid']) and isset($_GET['comstatus']) )
{
$idcom = $_GET['comid'];
$statuscom = $_GET['comstatus'];

if($statuscom == 'show')
{
$status ="hide";
$object->status_Comment($idcom,$status);
}
else
{
$status ="show";
$object->status_Comment($idcom,$status);

}

}
$cid = $_SESSION['client_id'];
$result = $object->getAllComment($cid);
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
                                    <div class="title"><strong>Comments</strong></div>
                                    </div>
                                  
                                </div>
                               

                                <div class="dcard-body">
                                    <table class="datatable table table-responsive" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Post Title</th>
                                                 <th>Post Content</th>
                                                 <th>Comment</th>
                                                <th>Commented By</th>
                                                 <th>Date</th>
                                                 <th>Status</th>
                                                  <th>Action</th>
                                                 <!--<th>Salary</th>-->
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                            <th>Post Title</th>
                                                 <th>Post Content</th>
                                                 <th>Comment</th>
                                                <th>Commented By</th>
                                                 <th>Date</th>
                                                 <th>Status</th>
                                                  <th>Action</th>
                                                <!--<th>Salary</th>-->
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                     <?php
                                     for($i=0; $i<$count; $i++)
                                              {
                                            if($val[$i]['post_title'] == "")
                                            {
                                            $title = "This is Message";
                                            }
                                            else
                                            {
                                            $title = $val[$i]['post_title'];
                                            }

                                     ?>       	
					      <tr>
                                              <td><?php echo $title; ?></td>
                                                <td><div style="width:200px;height:73px;border:1px solid #ccc;overflow-y:scroll"><?php echo strip_tags($val[$i]['post_content']); ?></div></td>  
                                                 <td class="padding_right_px"><?php echo $val[$i]['comment']; ?></td>
                                              <td class="padding_right_px"><?php
                                              // echo $val[$i]['commentBy']; 
                                                $uid = $val[$i]['commentBy'];;
                                               $na = $gt->getUserData($cid,$uid);
                                               $name = json_decode($na,true);
                                              echo  $name[0]['firstName']." ".$name[0]['lastName'];
                                             
                                               ?></td>
                                                <td class="padding_right_px"><?php echo $val[$i]['commentDate'];  ?></td>
                                                <td class="padding_right_px"><?php echo $val[$i]['status'];  ?></td>
                                              
                                             <td>
                                            <a href="comments.php?comid=<?php echo $val[$i]['commentId']; ?>&comstatus=<?php echo $val[$i]['status']; ?>"style="color:#CE3030;margin-left:19px !important;"><?php
if($val[$i]['status'] == 'show')
{ echo "hide";}
else
{ echo "show";}
?></a>
                                             <!--<button type="button"class="btn btn-sm  btn-danger"><span class="glyphicon glyphicon-trash"></span><a href="comments.php?com_id=<?php echo $val[$i]['commentId']; ?>">Delete<a/></button>--></td>
                                               
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