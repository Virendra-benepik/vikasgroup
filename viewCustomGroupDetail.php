<?php  include 'navigationbar.php';  ?>
<?php  include 'leftSideSlide.php';  ?>
<script type="text/javascript" src="js/analytic/analyticLogingraph.js"></script>
<?php
session_start();
require_once('Class_Library/class_get_group.php');
if (!class_exists("PushNotification")) {
    include_once('Class_Library/class_push_notification.php');
}
if (!class_exists("User")) {
    include_once('Class_Library/class_user.php');
}
//session_start();
$cid = $_SESSION['client_id'];
$obj = new Group();
$generalgroupobj = new PushNotification();
$userobj = new User();

$groupid = $_GET['groupid'];
$grouptype = $_GET['grouptype'];

//echo $groupid;
//echo $grouptype;


if ($grouptype == 2) {
   // echo "i am here";
    $result = $obj->getCustomGroupDetails($groupid, $cid);
    $val = json_decode($result, true);
    
    $usercount = count($val['posts']);
    $userdata = $val['posts'];
    echo "<pre>";
    print_r($userdata);
} else {
    $usertype = "general";
    $ur1[] = $groupid;
    // print_r($ur1);
    $result1 = $generalgroupobj->get_Employee_details($usertype, $ur1, $cid);
    
    $groupresult = $obj->getGroupDetails($cid,$groupid);
    print_r($groupresult);
$value = json_decode($groupresult, TRUE);
$getcat1 = $value['posts'][0];

//echo "<pre>";
//print_r($getcat1);

    $val1 = json_decode($result1, true);

    $count = count($val1);
    //echo "this is count 1-".$count;
    $val = array();
    for ($k = 0; $k < $count; $k++) {
        $uuid = $val1[$k];
        //  echo "this is uuid-".$uuid;
        $data = $userobj->getUserDetail($cid, $uuid);
//    echo "<pre>";
//   print_r($data);
        $data1['empcode'] = $data['userName']['employeeCode'];
        $data1['employeeId'] = $data['userName']['employeeId'];
        $data1['empname'] = $data['userName']['firstName'] . " " . $data['userName']['lastName'];
        $data1['emailId'] = $data['userName']['emailId'];
        $data1['contact'] = $data['userName']['contact'];
        $data1['department'] = $data['userName']['department'];
        $data1['designation'] = $data['userName']['designation'];
        $data1['location'] = $data['userName']['location'];
        $data1['status'] = $data['userName']['status'];
        $data1['accessibility'] = $data['userName']['accessibility'];
        $data1['branch'] = $data['userName']['branch'];
         $data1['groupName'] = $getcat1['groupName'];
          $data1['groupDescription'] = $getcat1['groupDescription'];
//       echo "<pre>";
//       print_r($data1);
        array_push($val, $data1);
    }
    $usercount = count($val);
    $userdata = $val;
}


/* * ************** for export data ************* */
if($grouptype == 2)
{
$count = count($val['posts']);

$expd = array();
for ($i = 0; $i < $count; $i++) {
    $expdata['sn'] = $val['posts'][$i]['sn'] = $i + 1;
    $expdata['name'] = $val['posts'][$i]['empname'];
    $expdata['employeeid'] = $val['posts'][$i]['empcode'];
    $expdata['emailId'] = $val['posts'][$i]['emailId'];
    $expdata['contact'] = $val['posts'][$i]['contact'];
    $expdata['department'] = $val['posts'][$i]['department'];
    $expdata['designation'] = $val['posts'][$i]['designation'];
    $expdata['branch'] = $val['posts'][$i]['branch'];
    array_push($expd, $expdata);
}
$exprecord = json_encode($expd);
//print_r($expd);
}
 else {
    $count = count($val);
$expd = array();
for ($i = 0; $i < $count; $i++) {
    $expdata['sn'] = $val[$i]['sn'] = $i + 1;
    $expdata['name'] = $val[$i]['empname'];
    $expdata['employeeid'] = $val[$i]['empcode'];
    $expdata['emailId'] = $val[$i]['emailId'];
    $expdata['contact'] = $val[$i]['contact'];
    $expdata['department'] = $val[$i]['department'];
    $expdata['designation'] = $val[$i]['designation'];
    $expdata['branch'] = $val[$i]['branch'];
    array_push($expd, $expdata);
}
$exprecord = json_encode($expd);
//print_r($expd);
 }
/* * ************** / for export data *********** */
?>

<!----------------------------------------------------------->
<!--------------------------------------------------------->
<script>
    function tableexport() {
        var exdata = document.getElementById('exportdata').value;
        var exporttitle = document.getElementById('exporttitle').value;
        var jsonData = JSON.parse(exdata);
//alert(jsonData.length);
        if (jsonData.length > 0)
        {
            if (confirm('Are You Sure, You want to Export Record?')) {
                JSONToCSVConvertor(exdata, exporttitle, true);
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            alert("No Record Available");
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
                                <div class="title"><strong><?php echo $userdata[0]['groupName']; ?></strong></div>
                            </div>

                            <textarea name="exportdata" id="exportdata" style="display:none;"><?php echo $exprecord; ?></textarea>
                            <textarea name="exporttitle" id="exporttitle" style="display:none;"><?php echo $userdata[0]['groupName']; ?></textarea>

                            <button type="button" class="btn btn-primary " onclick="return tableexport();" style="float:right;">Export</button>
                        </div>

                        <div class="row" style="margin-top:20px;margin-left:10px;">
                            <div class="col-xs-8"><b>About Group :   </b>
<?php echo $userdata[0]['groupDescription']; ?> 
                            </div>
                        </div>

                        <div class="card-body">
                            <div style="overflow-x:auto !important; width:100%">
                                <table class="datatable table table-responsive" cellspacing="2" width="100%" id="myTable">
                                    <thead>
                                        <tr >
                                            <th>Name</th>
                                            <th>Employee Id</th>
                                            <th>Email Id</th>
                                            <th>Contact</th>
                                            <th>Department</th>
                                            <th>Designation</th>
                                            <th>Branch</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Employee Code</th>
                                            <th>Email Id </th>
                                            <th>Contact</th>
                                            <th> Department </th>
                                            <th>Designation</th>
                                            <th>Branch</th>
                                        </tr>
                                    </tfoot> 
                                    <tbody>
<?php
for ($i = 0; $i < $usercount; $i++) {
    ?>       	
                                            <tr>

                                                <td class="padding_right_px"><?php echo $userdata[$i]['empname']; ?></td>

                                                <td class="padding_right_px"><?php echo $userdata[$i]['empcode']; ?></td>
                                                <td class="padding_right_px"><?php echo $userdata[$i]['emailId']; ?></td>
                                                <td class="padding_right_px"><?php echo $userdata[$i]['contact']; ?></td>
                                                <td class="padding_right_px"><?php echo $userdata[$i]['department']; ?></td>
                                                <td class="padding_right_px"><?php echo $userdata[$i]['designation']; ?></td>
                                                <td class="padding_right_px"><?php echo $userdata[$i]['branch']; ?></td>
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
    </div>

<?php include 'footer.php'; ?>