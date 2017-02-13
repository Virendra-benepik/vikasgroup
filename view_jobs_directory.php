<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include 'navigationbar.php';
include 'leftSideSlide.php';
require_once('Class_Library/class_jobpost.php');
$object = new JobPost();

@session_start();
$clientid = $_SESSION['client_id'];
$user_uniqueid = $_SESSION['user_unique_id'];
$user_type = $_SESSION['user_type'];

$result = $object->getJobs($clientid);
$val = json_decode($result, true);
//echo "<pre>";print_r($val);
$count = count($val);
//$path = "http://admin.benepik.com/employee/virendra/benepik_client/";
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
                                <div class="title"><strong>All Opportunities</strong></div>
                            </div>
                            <!--                            <div style="float:left; margin-top:13px; font-size:20px;"> 
                                                            <a href="postmessage.php">
                                                                <button type="button" class="btn btn-primary btn-sm">Create New Message</button>
                                                            </a>
                                                        </div>-->
                        </div>


                        <div class="card-body">
                            <table class="datatable table table-responsive" cellspacing="2" width="100%" id="myTable">
                                <thead>
                                    <tr>
                                        <th>Job Title</th>
                                        <th>Job Company</th>
                                        <th>Job Location</th>
<!--                                        <th>Total View</th>
                                        <th>Unique View</th>-->
                                        <th>Status</th>
                                        <th>Last Updates</th>
                                        <th><center>Action</center></th>
                                         <!--<th>Salary</th>-->
                                </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Job Title</th>
                                        <th>Job Company</th>                                        
                                        <th>Job Location</th>
<!--                                        <th>Total View</th>
                                        <th>Unique View</th>-->
                                        <th>Status</th>
                                        <th>Last Updates</th>
                                        <th>Action</th>
                                        <!--<th>Salary</th>-->
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    for ($i = 0; $i < $count; $i++) {

                                        $k = $val[$i]['status'];
                                        // $d  = date("d M Y H:i A", strtotime($val[$i]['created_date'])); 
                                        $d = $val[$i]['createdDate'];
                                        //echo $d;
                                        if ($k == 'Unpublish') {
                                            $action = 'Publish';
                                        } else {
                                            $action = 'Unpublish';
                                        }


                                        // echo $path.$val[$i]['post_img']."<br/>";
                                        ?>       	
                                        <tr>
                                            <td style="width:15% !important;"><a target="_blank" href="full_view_job.php?jobId=<?php echo $val[$i]['jobId'] ?>"> <?php
                                                    $cont = $val[$i]['jobTitle'];
                                                    $words = explode(" ", $cont);
                                                    $word = implode(" ", array_splice($words, 0, 15));
                                                    echo $word;
                                                    //echo $val[$i]['post_content']; 
                                                    ?></div></a></td>
                                            <td style="padding-left:40px;"><?php echo $val[$i]['companyName']; ?></td>
                                            <td style="padding-left:40px;"><?php echo $val[$i]['jobLocation']; ?></td>
    <!--                                            <td style="padding-left:40px;"><?php // echo $val[$i]['TotalCount'];             ?></td>
                                            <td style="padding-left:40px;"><?php // echo $val[$i]['ViewPostCount'];             ?></td>-->
                                            <td class="padding_right_px">
                                                <?php
                                                if ($val[$i]['status'] == 0) {
                                                    $status = "Pending";
                                                } else if ($val[$i]['status'] == 1) {
                                                    $status = "Approved";
                                                } else {
                                                    $status = "Dissaproved ";
                                                }
                                                echo $status;
                                                ?>
                                            </td>
                                           <!-- <a href="Link_Library/post_status.php?postid=<?php echo $val[$i]['jobId']; ?>&poststatus=<?php echo $val[$i]['status']; ?>&page=mesg">
                                            <button type="button"class="btn btn-sm  btn-success"><?php echo $val[$i]['status']; ?>
    </button>
    </a>
    </td>
         --->                                   <td class="padding_left_px"><?php echo $d; ?></td>

                                            <td>

                                                <a target="_blank" href="full_view_job.php?jobId=<?php echo $val[$i]['jobId']; ?>" style="color:#00a4fd;margin-left:29px !important;" >View</a>
                                                &emsp;&emsp;
                                                <?php
//                                                if ($val[$i]['status'] == 0) {
//                                                    
                                                ?>
    <!--                                                    <input type="checkbox" name="approval" class='approve_dissapprove' onclick="Job_approve_dissapprove('//<?php echo $val[$i]['jobId'] ?>', 1);" /> Approve
                                                    <input type="checkbox" name="approval" class='approve_dissapprove' onclick="Job_approve_dissapprove('//<?php echo $val[$i]['jobId'] ?>', 2);" /> Disapprove-->
                                                <?php
//                                                } else {
                                             /*  
											 if ($val[$i]['status'] == 0) {
                                                    echo "Pending";
                                                } else if ($val[$i]['status'] == 1) {
                                                    echo "Approved";
                                                } else {
                                                    echo "Dissaproved";
                                                }
											*/	
                                                //                                                }
                                                ?>
                                               <!-- &emsp;&emsp;-->
                                                <a onClick="javascript:if (confirm('Are you sure want to Delete Post ?')) {
                                                                return true;
                                                            } else {
                                                                return false
                                                            }" href="Link_Library/delete_job.php?jobid=<?php echo $val[$i]['jobId']; ?>&page=jobs"><button type="button"class="btn btn-sm  btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</button></a>
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
    <script>
        var jobId;
        var status;
        function Job_approve_dissapprove(jobId, status) {
            window.location.href = "Link_Library/job_status.php?jobid=" + jobId + "&poststatus=" + status + "&page=job";
        }
    </script>

    <?php include 'footer.php'; ?>