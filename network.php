<?php include 'navigationbar.php';?>
		<?php include 'leftSideSlide.php';?>
	                             
<?php require_once('Class_Library/class_getuser.php'); 
$cid = $_SESSION['client_id'];
$object = new GetUser();
$result = $object->getAllUser($cid);
$val = json_decode($result,true);
//echo "<pre>";
//print_r($val);
$count  = count($val);
$path = SITE;
$userid = "";
$access = "";
?>
	<!----------------------------------------------------------->
<?php
/*$userid = $_GET['user_id'];
$access = $_GET['access'];
if(isset($userid) && isset($access))
{

if($access == "User")
{
$sta = "Sub-Admin";
}
else
{
$sta = "User";
}
$string = "user_id=$userid&user_status=$sta";
//echo "<script>alert('".$string."')</script>";
$sub_req_url ="http://admin.benepik.com/employee/virendra/benepik_client/Link_Library/link_update_user_access.php";
$ch = curl_init($sub_req_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($ch, CURLOPT_POSTFIELDS,  "$string");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);

$resp = curl_exec($ch);

curl_close($ch);
$getcat = json_decode($resp,true);

$val = $getcat['success'];

if($val == 1)
{
echo "<script>alert('User accessibilty has changed')</script>";
echo "<script>window.location='network.php'</script>";
}
}

*/

?>
	<!--------------------------------------------------------->
	
	
			<div class="container-fluid">
			
	              <div class="side-body">
                   <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;margin-top:20px;">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="card">
                                <div class="card-header">

                                    <div class="card-title">
                                    <div class="title"><strong> Directory</strong></div>
                                    </div>
                                </div>
  
                                <div class="card-body">
                                    <table class="datatable table table-responsive" cellspacing="2" width="100%" id="myTable">
                                        <thead>
                                            <tr >
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Employee Id</th>
                                                <th>Email Id</th>
                                                <th>Department</th>
                                                <th>Designation</th>
                                                <th>Status</th>
                                                <!-- <th>Accessibility</th>
                                                 
                                                   <th>Action</th>  -->
                                                  <!-- <th>Salary</th>-->
                                            </tr>
                                        </thead>
                                       <tfoot>
                                            <tr>
                                              <th>Image</th>
                                                <th>Name</th>
                                                 <th>Employee Code</th>
                                                <th>Email Id </th>
                                                <th> Department </th>
                                                <th>Designation</th>
                                                <th>Status</th>
                                               <!---  <th>Accessibility</th>
                                                 
                                                      <th>Action</th>  -->
                                           <!--      <th>Salary</th>-->
                                            </tr>
                                        </tfoot> 
                                        <tbody>
                                     <?php
                                     
                                     for($i=0; $i<$count; $i++)
                                              {
												  $uimg = $val[$i]['userImage'];
												  if($uimg == "")
												  {
													  $uimg = "images/u.png";
												  }
                                    

                                     ?>       	
					                    <tr>
                                              <td><img src="<?php echo $uimg; ?>" class="img img-circle img-responsive" onerror='this.src="images/u.png"' id="news_images2" /></td>
                                                <td class="padding_right_px"><?php echo $val[$i]['firstName']." ".$val[$i]['middleName']." ".$val[$i]['lastName']; ?></td>
                                                
                                                 <td class="padding_right_px"><?php echo $val[$i]['employeeCode']; ?></td>
                                                 <td class="padding_right_px"><?php echo $val[$i]['emailId']; ?></td>
                                                 <td class="padding_right_px"><?php echo $val[$i]['department']; ?></td>
                                                 <td class="padding_right_px"><?php echo $val[$i]['designation']; ?></td>
                                               <!--  <td><?php echo $val[$i]['accessibility']; ?></td> -->
                                                 <td class="padding_right_px"><?php echo $val[$i]['status']; ?></td>
                                           
                                                
                                              <!--   <td><button type="button"class="btn btn-sm  btn-warning">Edit</button></td>  -->
                                              
                                              
                                            
                                               
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