<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';?>	                             
<?php require_once('Class_Library/class_training.php');

$object = new Training();
$clientid = $_SESSION['client_id'];

$result = $object->viewemployeeleariningdetaillist($clientid);
$val = json_decode($result,true);
//echo "<pre>";
//print_r($val);


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
                                    <div class="title"><strong>Employee Learning Details</strong></div>
                                    </div>
                                    <div style="float:left; margin-top:13px; font-size:20px;"> 
                                    <a href="addEmpLearning.php">
                 <button type="button" class="btn btn-primary btn-sm">Create New Employee Learining</button>
                                    </a>
                                     </div>
                                </div>
 
                                <div class="card-body">
                                    <table class="datatable table table-responsive" cellspacing="2" width="100%" id="1myTable">
                                        <thead class="thead-inverse">
                                            <tr>
                                                <th>Learning Name</th>
                                                <th>Employee Name</th>
                                                 <th>Learining Date</th>
                                                 <th>Remarks</th>
                                                 
                                            </tr>
                                        </thead>
                                       <?php 
									   for($i=0; $i<count($val); $i++)
									   {
										$trainingname = $val[$i]['trainingName'];
										$employeename = $val[$i]['employeename'];
										$trainingdate = $val[$i]['trainingDate'];
										$remark = $val[$i]['remark'];   
									   ?>
									   <tr>
									   <td style="text-align:justify; padding-left:20px;"><?php echo $trainingname; ?></td>
										<td style="text-align:justify; padding-left:20px;"><?php echo $employeename; ?></td>
										<td style="text-align:justify; padding-left:20px;"><?php echo $trainingdate; ?></td>
										<td style="text-align:justify; padding-left:20px;"><?php echo $remark; ?></td>
									   
									   </tr>
									   <?php
									   }
									   ?>
                                        <tbody>
										
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