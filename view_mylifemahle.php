<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';?>	                             
<?php require_once('Class_Library/class_get_mylife.php');

$object = new GetMyLifeMahle();
$clientid = $_SESSION['client_id'];
$user_uniqueid = $_SESSION['user_unique_id'];
$user_type = $_SESSION['user_type'];

$result = $object->getAllMahleLife($clientid,$user_uniqueid,$user_type);
$val = json_decode($result,true);
//echo "<pre>";
//print_r($val);
$count  = count($val['posts']);
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
                                    <div class="title"><strong>My Life at Mahle</strong></div>
                                    </div>
                                    <div style="float:left; margin-top:13px; font-size:20px;"> 
                                    <a href="mylifeatmahle.php">
                 <button type="button" class="btn btn-primary btn-sm">Create Post My Life at Mahle</button>
                                    </a>
                                     </div>
                                </div>
 
                                <div class="card-body">
                                    <table class="datatable table table-responsive" cellspacing="2" width="100%" id="myTable">
                                        <thead class="thead-inverse">
                                            <tr>
                                                <th>Image</th>
                                                <th>Title</th>
                                               
                                                <th>Created By</th>
                                                <th>Last Updates</th>
                                                <th>Action</th>
                                               
                                            </tr>
                                        </thead>
                                       
                                        <tbody>
<form name="form1" id="form1" method="post">
                                     <?php
                             
                                     for($i=0; $i<$count; $i++)
                                              {
                                               $k = $val[$i]['status'];
                                              echo $k;
                                              
if($k == 'Unpublish')
{
$action = 'Publish';
}
else
{
$action = 'Unpublish';
}
                                              
                                     // echo $path.$val[$i]['post_img']."<br/>";

                                     ?>       	
					      <tr>
                                              <td>

<img src="<?php echo $val['posts'][$i]['post_img']; ?>"class="img img-rounded"id="news_images"/> </td>
                                               
                                                <td class="padding_right_px"><?php 
                                                $cont =  $val['posts'][$i]['post_title'];
                                        $words = explode(" ",$cont);
                                        $word = implode(" ", array_splice($words, 0, 10));
                                                echo $word; ?>
                                        </td>
                                         <td class="padding_right_px"><?php echo $val['posts'][$i]['created_by'];  ?></td>
                                         <td class="padding_right_px"><?php echo $val['posts'][$i]['created_date'];  ?></td>
                                              
                                        <td  class="padding_right_px">
<!--<a onClick="javascript:if(confirm('Are you sure want to Delete Post ?')){return true;} else{return false}" href="Link_Library/delete_post.php?idpost=<?php echo $val[$i]['post_id']; ?>">
<button type="button"class="btn btn-sm  btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete
</button>
</a>-->

<a target="_blank" href="full_view_mylifemahle.php?idpost=<?php echo $val['posts'][$i]['post_id']?>" style="color:#00a4fd;">View
</a>

<!---<a href="Link_Library/post_status.php?postid=<?php echo $val[$i]['post_id']; ?>&poststatus=<?php echo $val[$i]['status']; ?>">
<button type="button"class="btn btn-sm btn-danger unpublishBtn">
<?php echo $action; ?>
</button>
</a>-->

</td>
                                               
                                            </tr>
                                      
                                        <?php
                                        }
                                        ?>
</form>
                                          </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
				<?php include 'footer.php';?>