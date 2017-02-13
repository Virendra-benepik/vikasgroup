<?php include 'navigationbar.php';?>
		<?php  include 'leftSideSlide.php';?>
	                             
<?php require_once('Class_Library/class_event_registration.php'); 
$obj = new EventRegistration();
//$path = "http://admin.benepik.com/employee/virendra/Mahle_AdminPanel/";
?>
	<!----------------------------------------------------------->
<?php
$eventid = $_GET['eventid'];
$clientid = $_GET['clientid'];

$val1 = $obj->getAllEventRegistration($clientid,$eventid);

$val = json_decode($val1,true);


//echo "<pre>";
//print_r($val);

$count = count($val['user']);
echo $count;
?>
	<!--------------------------------------------------------->
	
	
			<div class="container-fluid">
			<!--<div class="addusertest">
			<a href="create_post.php"><button type="button"class="btn btn-sm btn-default" style="text-shadow:none;"><b>Create Post</b></button></a>
	</div> -->
	              <div class="side-body">
                   
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="card">
                                <div class="card-header">

                                    <div class="card-title">
                                    <div class="title">Event Registration Details</div>
                                    </div>
                                </div>
  
                                <div class="card-body">
                                    <table class="datatable table table-responsive" cellspacing="2" width="100%" id="myTable">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Employee Id</th>
                                                <th>Email Id </th>
                                                <th>Department</th>
                                                <th>Designation</th>
                                               
                                              
                                            </tr>
                                        </thead>
                                       <tfoot>
                                            <tr>
                                              <th>Image</th>
                                                <th>Name</th>
                                                 <th>Employee Id</th>
                                                <th>Email Id </th>
                                                <th>Department</th>
                                                <th>Designation</th>
                                               
                                            </tr>
                                        </tfoot> 
                                        <tbody>
                                     <?php
                                 
                                     for($i=0; $i<$count; $i++)
                                              {
                                             
                                     ?>       	
					      <tr>
                                              <td><img src="<?php echo $val['user'][$i]['userImage']; ?>"class="img img-circle img-responsive" id="news_images" onerror='this.src="images/u.png"'/></td>
                                                <td><?php echo $val['user'][$i]['firstName']." ".$val['user'][$i]['middleName']." ".$val[$i]['lastName']; ?></td>
                                                
                                                 <td><?php echo $val['user'][$i]['employeeCode']; ?></td>
                                                 <td><?php echo $val['user'][$i]['emailId']; ?></td>
                                                 <td><?php echo $val['user'][$i]['department']; ?></td>
                                                 <td><?php echo $val['user'][$i]['designation']; ?></td>
                                             
                                               
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