<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';?>
	                             
<?php require_once('Class_Library/class_thought.php');
require_once('Class_Library/class_get_useruniqueid.php');
$gt = new UserUniqueId();
$thought_obj = new ThoughtOfDay();
$clientid = $_SESSION['client_id'];

$result = $thought_obj->thoughtDetails($clientid);
$getcat = json_decode($result,true);
//print_r($result);
$value = $getcat['posts'];
$count = count($value);

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
                                    <div class="title"><strong>Previous Thought Details</strong></div>
                                    </div>
                                    <div style="float:left; margin-top:13px; font-size:20px;"> 
                                    <a href="todays_thought.php">
                 <button type="button" class="btn btn-primary btn-sm">Create New Thought</button>
                                    </a>
                                     </div>
                                </div>
                                

                                <div class="card-body">
                                    <table class="datatable table table-responsive" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Thought Images</th>
                                                
                                                <th>Thought Quote</th>
                                                <th>Created by</th>
                                                <th>Created Date</th>
                                                <!--<th>Status</th>
                                                <th>Action</th>
                                                 <th>Salary</th>-->
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Thought Images</th>
                                                
                                                <th>Thought Quote</th>
                                                <th>Created by</th>
                                                <th>Created Date</th>
                                                <!--<th>Status</th>
                                                <th>Action</th>
                                                 <th>Salary</th>-->
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                     <?php
                                     for($i=0; $i<$count; $i++)
                                       {
$imagevalue = $value[$i]['thoughtImage'];

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
if(strlen($value[$i]['message'])>50)
{
echo substr($value[$i]['message'],0,50)."<b>...</b>";
}
else
{
echo $value[$i]['message'];
} ?></td>
                                                <td class="padding_right_px"><?php 
                                                
                                               $uid = $value[$i]['createdBy'];
                                                $na = $gt->getUserData($clientid,$uid);
                                              //  echo $na;
                                               $name = json_decode($na,true);
                                              echo  $name[0]['firstName']." ".$name[0]['lastName'];
                                              
                                                
                                                ?></td>
                                   <td class="padding_right_px"><?php echo $value[$i]['publishingTime']; ?></td>                                             
                                                <!--<td><?php echo $value[$i]['status'];  ?></td>
                                             <td>                                                                                        
<a href="view_poll_result.php?pollid=<?php echo $value[$i]['pollId']; ?>&clientid=<?php echo $value[$i]['clientId']; ?>"> <button type="button"class="btn btn-sm  btn-default"><span class="glyphicon glyphicon-filter"></span>Result</button></a>
<a href="#"> <button type="button"class="btn btn-sm  btn-default"><span class="glyphicon glyphicon-thumbs-up"></span>View</button></a>
 </td>-->
                                               
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