<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';?>	                             
<?php require_once('Class_Library/class_recognize.php');
require_once('Class_Library/class_get_useruniqueid.php');
$gt = new UserUniqueId();
$object = new Recognize();
$clientid = $_SESSION['client_id'];
$user_uniqueid = $_SESSION['user_unique_id'];
$user_type = $_SESSION['user_type'];

$result = $object->getRecognizeDetails($clientid);
$val = json_decode($result,true);

$status = $val[$i]['status'];
$count  = count($val);
$path = "http://admin.benepik.com/employee/virendra/benepik_client/";

?>
	
			<div class="container-fluid">
			<div class="addusertest">
			
	</div>
	              <div class="side-body">
                   <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="card">
                                <div class="card-header">

                                    <div class="card-title">
                                    <div class="title"><strong>All Recognition Details</strong></div>
                                    </div>
                                   
                                </div>
 
                                <div class="card-body">
                                    <table class="datatable table table-responsive" cellspacing="2" width="100%" id="myTable">
                                        <thead class="thead-inverse">
                                            <tr>
                                                <th>Recognize By</th>
                                                <th>Recognize To</th>
                                                 <th>Quality(Topic)</th>
                                                  <th>Points</th>
                                                 <th>Title</th>
                                                  <th>Comment</th>
                                                 
                                                <th>Status</th>
                                               <th>Created Date </th>
                                               <th>Action</th>
                                                   
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                            <th>Recognize By</th>
                                                <th>Recognize To</th>
                                                 <th>Quality(Topic)</th>
                                                  <th>Points</th>
                                                 <th>Title</th>
                                                  <th>Comment</th>
                                                 
                                                <th>Status</th>
                                               <th>Created Date </th>
                                             <th>Action</th> 
                                               
                                            </tr>
                                        </tfoot> 
                                        <tbody>
<form name="form1" id="form1" method="post">
                                     <?php
                                 
                                  
                                     for($i=0; $i<$count; $i++)
                                              {
                                             
                                               $k = $val[$i]['status'];
                                            $recogid = $val[$i]['recognitionId'];

                                     ?>       	
					      <tr>
                                              <td class="padding_right_px"><?php //echo $val[$i]['recognitionBy'];
                                               $uid = $val[$i]['recognitionBy'];
                                               $na = $gt->getUserData($clientid,$uid);
                                               $name = json_decode($na,true);
                                              echo  $name[0]['firstName']." ".$name[0]['lastName'];
                                              
                                               ?></td>
                                               <td class="padding_right_px"><?php 
                                                $uid1 = $val[$i]['recognitionTo'];
                                               $na = $gt->getUserData($clientid,$uid1);
                                               $name = json_decode($na,true);
                                              echo  $name[0]['firstName']." ".$name[0]['lastName'];
                                               
                                                ?></td>
                                                <td class="padding_right_px"><?php echo $val[$i]['topic']; ?></td>
                                                  <td class="padding_right_px"><?php echo $val[$i]['points']; ?></td>
                                                <td class="padding_right_px"><?php echo $val[$i]['title']; ?></td>
                                              
                                                <td class="padding_right_px"><?php 
                                               $cont =  $val[$i]['text'];
                                        $words = explode(" ",$cont);
                                        $word = implode(" ", array_splice($words, 0, 10));
                                                echo $word; 
                                               ?>
                                               </td>
                                          
                                               <td class="padding_right_px"><?php echo $val[$i]['status']; ?></td>
                                         <td class="padding_right_px"><?php echo $val[$i]['dateOfEntry'];  ?></td>
                                              
                                     <td  style="width:16% !important;">
<!--<a onClick="javascript:if(confirm('Are you sure want to Delete Post ?')){return true;} else{return false}" href="Link_Library/delete_post.php?idpost=<?php echo $val[$i]['post_id']; ?>">
<button type="button"class="btn btn-sm  btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete
</button>
</a>--->

<a target="_blank" href="full_view_recognize.php?idreg=<?php echo $recogid; ?>" style="color:#00a4fd;margin-left:10px;">
 <?php $ft = ($val[$i]['status'] == "Approve")? "Disabled" : "" ; echo  $ft; ?> View Recognition
</a><br>
<a href="view_recognize_user_account.php?recogid=<?php echo $uid1; ?>&clientid=<?php echo $val[$i]['clientId']; ?>" style="color:#7FFF00;margin-left:10px;">

Account Details

</a>

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