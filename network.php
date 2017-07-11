<?php
//error_reporting(E_ALL);ini_set('display_errors','1');
 include 'navigationbar.php';  include 'leftSideSlide.php'; 
?>
<script type="text/javascript" src="js/analytic/analyticLogingraph.js"></script>
<?php
require_once('Class_Library/class_getuser.php');
//@session_start();   
$cid = $_SESSION['client_id'];
$ucompany = $_SESSION['companyUniqueId'];
$access = $_SESSION['user_type'];

$object = new GetUser();
$result = $object->getAllUser($cid,$ucompany,$access);
//print_r($result);
$val = json_decode($result, true);
/*echo "<pre>";
print_r($val);
echo "</pre>";*/
//echo "<pre>";print_r($val);die;
$count = count($val);
$path = SITE;
$userid = "";
$access = "";

/**************** for export data **************/
$expd = array(); 
for ($i = 0; $i < $count; $i++) {
$expdata['sn'] = $val[$i]['sn'] = $i+1 ; 
$expdata['name'] = $val[$i]['firstName'] . ' ' . $val[$i]['lastName']; 
$expdata['employeeid'] = $val[$i]['employeeCode'];
$expdata['companyname'] = $val[$i]['companyName'];
$expdata['emailId'] = $val[$i]['emailId'];
$expdata['contact'] = $val[$i]['contact'];
$expdata['department'] = $val[$i]['department'];
$expdata['designation'] = $val[$i]['designation'];
$expdata['accessibility'] = $val[$i]['accessibility'];
//$expdata['status'] = $val[$i]['status'];
array_push($expd ,$expdata );
}
$exprecord = json_encode($expd);

/**************** / for export data ************/
/*----------------------------------------------------------->*/

if (isset($_GET['eid']) && isset($_GET['status']) && isset($_GET['accessbility'])) {
    $idpoll = $_GET['eid'];
    $status = $_GET['status'];
    echo $status;
    $access = $_GET['accessbility'];
    if ($status == 'Active') {
        $status1 = 'InActive';
    }
    $result = $object->updateUserStatus($idpoll, $status1,$access);
    $output = json_decode($result, true);
//    echo "<pr>";
//    print_r($output);
//    echo "</pre>";
    $value = $output['success'];
    $message = $output['message'];

    if ($value == 1) {
        echo "<script>alert('$message')</script>";
        echo "<script>window.location='network.php'</script>";
    }
}
?>

<!--------------------------------------------------------->
<script>
function tableexport() {
var exdata = document.getElementById('exportdata').value;
var jsonData = JSON.parse(exdata);
//alert(jsonData.length);
                    if (jsonData.length > 0)
                    {
						if (confirm('Are You Sure, You want to Export directory?')) {
                        JSONToCSVConvertor(exdata, "Directory", true);
						return true;
						}
						else
						{
							return false;
						}
                    }
					else
					{
					alert("No data available");	
					}
					
}
</script>

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
							
							<textarea name="exportdata" id="exportdata" style="display:none;"><?php echo $exprecord; ?></textarea>
									
									<button type="button" class="btn btn-primary " onclick="return tableexport();" style="float:right;">Export</button>
							
                        </div>
						
						
									
                        <div class="card-body">
                            <table class="datatable table table-responsive" cellspacing="2" width="100%" id="myTable">
                                <thead>
                                    <tr >
                                        <!--<th>Image</th>-->
                                        <th>Name</th>
                                        <th>Employee Id</th>
										<th>Company</th>
                                        <th>Email Id</th>
										<th>Contact No.</th>
                                        <th>Department</th>
                                        <th>Designation</th>

                                        <th>Accessibility</th>
                                        <!--<th>Status</th>-->
                                        <th>Action</th>
                                       <!-- <th>Salary</th>-->
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <!--<th>Image</th>-->
                                        <th>Name</th>
                                        <th>Employee Id</th>
										<th>Company</th>
										<th>Email Id </th>
										<th>Contact</th>
                                        <th> Department </th>
                                        <th>Designation</th>

                                        <th>Accessibility</th>
                                       <!--<th>Status</th>-->
                                        <th>Action</th>
                             <!--      <th>Salary</th>-->
                                    </tr>
                                </tfoot> 
                                <tbody>
                                    <?php
                                    for ($i = 0; $i < $count; $i++) {
                                        if ($val[$i]['status'] == "Active") {
                                            $sta = "InActive";
                                            $gly = "glyphicon glyphicon-eye-close";
                                            $dis = "";
                                            $status = "Active";
                                        } else {
                                            $sta = "InActive";
                                            $gly = "glyphicon glyphicon-eye-open";
                                            $dis = "disabled";
                                            $status = "InActive";
                                        }
                                        $uimg = $val[$i]['userImage'];
                                        if ($uimg == "") {
                                            $uimg = "images/u.png";
                                        }
                                        ?>       	
                                        <tr>
                                            <!--<td><img src="<?php echo $uimg; ?>" class="img img-circle img-responsive" onerror='this.src="images/u.png"' id="news_images2" /></td>-->
                                            <td class="padding_right_px"><?php echo $val[$i]['firstName'] . " " . $val[$i]['middleName'] . " " . $val[$i]['lastName']; ?></td>

                                            <td class="padding_right_px"><?php echo $val[$i]['employeeCode']; ?></td>
											<td class="padding_right_px"><?php echo $val[$i]['companyName']; ?></td>
                                            <td class="padding_right_px"><?php echo $val[$i]['emailId']; ?></td>
											<td class="padding_right_px"><?php echo $val[$i]['contact']; ?></td>
                                            <td class="padding_right_px"><?php echo $val[$i]['department']; ?></td>
                                            <td class="padding_right_px"><?php echo $val[$i]['designation']; ?></td>
                                            <td><?php echo $val[$i]['accessibility']; ?></td>
                                            <!--<td class="padding_right_px"><?php echo $status; ?></td>-->


                                            <td> <a href="network.php?eid=<?php echo $val[$i]['employeeId']; ?>&status=<?php echo $status; ?>&accessbility=<?php echo $val[$i]['accessibility']; ?>">
                                                    <button style="background-color:#fff;color:red" type="button" onclick="return confirm('Are you sure you want to InActive this User?');" class="btn btn-sm" <?php echo $dis . ">" . $sta; ?></span></button></a></td>




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

<?php include 'footer.php'; ?>
