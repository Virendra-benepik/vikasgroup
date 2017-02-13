<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';?>	                             
<?php require_once('Class_Library/class_training.php');

$object = new  Training();
$clientid = $_SESSION['client_id'];

$result = $object->viewleariningDetails($clientid);
$val = json_decode($result,true);

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
                                    <div class="title"><strong>Learning Details</strong></div>
                                    </div>
                                    <div style="float:left; margin-top:13px; font-size:20px;"> 
                                    <a href="addLearning.php">
                 <button type="button" class="btn btn-primary btn-sm">Create New Learning</button>
                                    </a>
                                     </div>

                                </div>
 
                                <div class="card-body">
                                    <table class="datatable table table-responsive" cellspacing="2" width="100%" id="1myTable">
                                        <thead class="thead-inverse">
                                            <tr>
                                                <th>Learning Name</th>
                                                <th>Learning Description</th>
                                                 <th>Created Date</th>
                                                 <th>Status</th>
                                                 
                                            </tr>
                                        </thead>
										<tbody>
<?php							 
//echo "<pre>";
//print_r($val);
//echo count($val);
for($i=0; $i<count($val); $i++)
{
	$trainingname = $val[$i]['trainingName'];
	$trainingdescription = $val[$i]['trainingDescription'];
	$createddate = $val[$i]['createdDate'];
	$status = $val[$i]['status'];
if($status == 1)
{
$statusres = "Active";
}
else
{
$statusres = "Inactive";
}

?>
										<tr>
										<td style="text-align:justify; padding-left:20px;"><?php echo $trainingname; ?></td>
										<td style="text-align:justify; padding-left:20px;"><?php echo $trainingdescription; ?></td>
										<td style="text-align:justify; padding-left:20px;"><?php echo $createddate; ?></td>
										<td style="text-align:justify; padding-left:20px;"><?php echo $statusres; ?></td>
										
<?php 
}
?>
										</tr>
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