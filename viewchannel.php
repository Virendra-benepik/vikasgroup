<?php include 'navigationbar.php'; ?>
<?php include 'leftSideSlide.php'; ?>

<?php
include 'Class_Library/class_get_group.php';
require_once('Class_Library/class_get_useruniqueid.php');
$gt = new UserUniqueId();
?>                   
<?php
session_start();
$clientid = $_SESSION['client_id'];

$obj = new Group();

$result = $obj->getGroup($clientid);
$value = json_decode($result, TRUE);
$getcat = $value['posts'];
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
                                <div class="title"><strong>View Groups</strong></div>
                            </div>
                            <div style="float:right; margin-top:13px; font-size:20px;margin-right: 10px;"> 
                                <a href="addchannel.php?clientid=<?php echo $_SESSION['client_id']; ?>">
                                    <button type="button" class="btn btn-primary btn-sm">Create New General Group</button>
                                </a>
                            </div> 
                            &nbsp;&nbsp;

                            <div style="float:right; margin-top:13px; font-size:20px;margin-right: 10px;"> 
                                <a href="addcustomgroup.php?clientid=<?php echo $_SESSION['client_id']; ?>">
                                    <button type="button" class="btn btn-primary btn-sm">Create New Custom Group</button>
                                </a>
                            </div> 
                        </div>


                        <div class="card-body">
                            <table class="datatable table table-responsive" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                    <th>Group Name</th>

                                    <th>Description</th>
                                    <th>Group Type </th>
                                    <th>Created by</th>
                                    <th>Created Date</th>
                                  <!--  <th>Status</th>-->
                                    <th>Action</th> 
                                     <!--<th>Salary</th>-->
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                    <th>Group Name</th>
                                    
                                    <th>Description</th>
                                    <th>Group Type </th>
                                    <th>Created by</th>
                                    <th>Created Date</th>
                                  <!--  <th>Status</th>-->
                                    <th>Action</th> 
                                    <!--<th>Salary</th>-->
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
//                                    echo "<pre>";
//                                    print_r($getcat);
                                    for ($i = 0; $i < count($getcat); $i++) {
                                         if ($getcat[$i]['groupType'] == 2) {
                                           
                                            $grouptype = "Custom";
                                        } else {
                                             $grouptype = "General";
                                        }
                                        ?>       	
                                        <tr>

                                        <td class="padding_right_px"><?php echo $getcat[$i]['groupName']; ?></td>

                                        <td class="padding_right_px"><?php echo $getcat[$i]['groupDescription']; ?></td>
                                         <td class="padding_right_px"><?php echo $grouptype; ?></td>
                                        <td class="padding_right_px"><?php
                                    $uid = $getcat[$i]['createdBy'];
                                    //  echo $uid;
                                    $na = $gt->getUserData($clientid, $uid);
                                    $name = json_decode($na, true);
                                    echo $name[0]['firstName'] . " " . $name[0]['lastName'];
                                        ?></td>
                                  <td class="padding_right_px"><?php echo $getcat[$i]['createdDate']; ?></td>   
                                          <td>
                   <?php
                                                if ($getcat[$i]['groupType'] == 1) {
                                                    ?> 
                                                    <a href="view_oneChannel.php?clientid=<?php echo $getcat[$i]['clientId']; ?>&groupid=<?php echo $getcat[$i]['groupId']; ?>&grouptype=<?php echo $getcat[$i]['groupType']; ?>"style="color:#00a4fd;margin-left:10px !important;"><span class="glyphicon glyphicon"></span>View</a>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <a href="viewCustomGroupDetail.php?clientid=<?php echo $getcat[$i]['clientId']; ?>&groupid=<?php echo $getcat[$i]['groupId']; ?>&grouptype=<?php echo $getcat[$i]['groupType']; ?>"style="color:#00a4fd;margin-left:10px !important;"><span class="glyphicon glyphicon"></span>View</a>
                                                    <?php
                                                }
                                                ?>

                                            </td>
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