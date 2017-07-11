<?php include 'navigationbar.php';?>
		<?php  include 'leftSideSlide.php';?>

<script type="text/javascript" src="js/analytic/analyticLogingraph.js"></script>                            
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

<script>
function tableexport() {
var exdata = document.getElementById('exportdata').value;
var extitle = document.getElementById('eventtitle').value;
//alert(extitle);
var jsonData = JSON.parse(exdata);
//alert(jsonData.length);
                    if (jsonData.length > 0)
                    {
						if (confirm('Are You Sure, You want to Export Record?')) {
                        JSONToCSVConvertor(exdata, extitle, true);
						return true;
						}
						else
						{
							return false;
						}
                    }
					else
					{
					alert("No record available");	
					}
					
}
</script>
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
                                    <div class="title">Save The Date Registration Details
									
									</div>
									
                                    </div>
									<?php
									
									$exportdata = $obj->eventRegistrationExportData($clientid,$eventid);
									$data = json_decode($exportdata,true);
									//print_r($data);
									//count($data);
									 $etitle = "Save the Date - " . $data[0]['title'];
									$post = array ();
									for($i=0; $i<count($data); $i++)
									{
										
										 $pst['sn'] = $data[$i]['sn'] = $i+1;
										 $pst['company'] = $data[$i]['company'];
										 $pst['name'] = $data[$i]['name'];
										 $pst['employeeCode'] = $data[$i]['employeeCode'];
										 $pst['department'] = $data[$i]['department'];
										 $pst['designation'] = $data[$i]['designation'];
										 $pst['location'] = $data[$i]['location'];
										 array_push($post,$pst);
									}
									$jdata = json_encode($post);
									?>
									
									<textarea name="exportdata" id="exportdata" style="display:none;"><?php echo $jdata; ?></textarea>
									<textarea name="eventtitle" id="eventtitle" style="display:none;"><?php echo $etitle; ?></textarea>
									
									<button type="button" class="btn btn-primary " onclick="return tableexport();" style="float:right;">Export</button>
									
                                
								</div>
								
  
                                <div class="card-body">
                                    <table class="datatable table table-responsive" cellspacing="2" width="100%" id="myTable">
                                        <thead>
                                            <tr>
                                                <!--<th>Image</th>-->
                                                <th>Name</th>
                                                <th>Employee Id</th>
                                                <th>Email Id </th>
												<th>Company</th>
                                                <th>Department</th>
                                                <th>Designation</th>
                                               <th>Location</th>
                                              
                                            </tr>
                                        </thead>
                                       <tfoot>
                                            <tr>
                                              <!--<th>Image</th>-->
                                                <th>Name</th>
                                                 <th>Employee Id</th>
                                                <th>Email Id </th>
												<th>Company</th>
                                                <th>Department</th>
                                                <th>Designation</th>
                                               <th>Location</th>
                                            </tr>
                                        </tfoot> 
                                        <tbody>
                                     <?php
                                 
                                     for($i=0; $i<$count; $i++)
                                              {
                                             
                                     ?>       	
					      <tr>
                                              <!--<td><img src="<?php echo $val['user'][$i]['userImage']; ?>"class="img img-circle img-responsive" id="news_images" onerror='this.src="images/u.png"'/></td>-->
                                                <td><?php echo $val['user'][$i]['firstName']." ".$val['user'][$i]['middleName']." ".$val[$i]['lastName']; ?></td>
                                                
                                                 <td><?php echo $val['user'][$i]['employeeCode']; ?></td>
                                                 <td><?php echo $val['user'][$i]['emailId']; ?></td>
												 <td><?php echo $val['user'][$i]['companyName']; ?></td>
                                                 <td><?php echo $val['user'][$i]['department']; ?></td>
                                                 <td><?php echo $val['user'][$i]['designation']; ?></td>
												 <td><?php echo $val['user'][$i]['location']; ?></td>
                                             
                                               
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