<?php
include 'navigationbar.php';
include 'leftSideSlide.php';
require_once('Class_Library/class_getpost.php');
$object = new GetPOST();
$clientid = $_SESSION['client_id'];
$user_uniqueid = $_SESSION['user_unique_id'];
$user_type = $_SESSION['user_type'];

$result = $object->getAllMessage($clientid, $user_uniqueid, $user_type);
$val = json_decode($result, true);
//echo "<pre>";
//print_r($val);
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
                                <div class="title"><strong>ALL Messages</strong></div>
								<!--<?php echo $user_type;
								echo $clientid;
								echo $user_uniqueid;
								
								?>-->
                            </div>
                            <!-- <div style="float:left; margin-top:13px; font-size:20px;"> 
                                 <a href="postmessage.php">
                                     <button type="button" class="btn btn-primary btn-sm">Create New Message</button>
                                 </a>
                             </div>--->
                        </div>


                        <div class="card-body">
                            <table class="datatable table table-responsive" cellspacing="2" width="100%" id="myTable">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Message</th>
                                        <th>Total View</th>
                                        <th>Unique View</th>
                                        <th>Like</th>
                                        <th>Comment</th> 
                                        <th>Status</th> 
                                        <th>Last Updates</th>
                                        <th><center>Action</center></th>
                                         <!--<th>Salary</th>-->
                                </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Title</th>
                                        <th>Message</th>
                                        <th>Total View</th>
                                        <th>Unique View</th>
                                        <th>Like</th>
                                        <th>Comment</th> 

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
                                        $d = $val[$i]['created_date'];
                                        //echo $d;
                                        if ($k == 'Unpublish') {
                                            $action = 'Publish';
                                        } else {
                                            $action = 'Unpublish';
                                        }


                                        // echo $path.$val[$i]['post_img']."<br/>";
                                        ?>       	
                                        <tr>
                                                                                <!--<td style="padding-left:40px;"><?php echo $val[$i]['post_title']; ?></td>-->
                                            <td style="width:15% !important;"><a target="_blank" href="full_view_message.php?idpost=<?php echo $val[$i]['post_id'] ?>"> <?php
                                                    $cont = $val[$i]['post_title'];
                                                    $words = explode(" ", $cont);
                                                    $word = implode(" ", array_splice($words, 0, 25));
                                                    echo $word;
                                                    //echo $val[$i]['post_content']; 
                                                    ?></div></a></td>

                                            <?php
                                            $string = strip_tags($val[$i]['post_content']);
                                            if (strlen($string) > 50) {
                                                $stringCut = substr($string, 0, 50);

                                                $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . "....<a style='color:#00a4fd;margin-left:30px !important' href='full_view_message.php?idpost=" . $val[$i]['post_id'] . "'>Read More</a>";
                                            }
                                            ?>



                                            <td style="padding-left:40px;"><?php echo $string; ?></td>

                                            <td style="padding-left:40px;"><?php echo $val[$i]['TotalCount']; ?></td>
                                            <td style="padding-left:40px;"><?php echo $val[$i]['ViewPostCount']; ?></td>
                                            <td style="padding-left:30px;"><?php echo $val[$i]['likeCount']; ?></td>
                                            <td style="padding-left:40px;"><?php echo $val[$i]['commentCount']; ?></td>

                                            <td class="padding_right_px"><?php echo $val[$i]['status']; ?></td> 
                                       <!--  <a href="Link_Library/post_status.php?postid=<?php echo $val[$i]['post_id']; ?>&poststatus=<?php echo $val[$i]['status']; ?>&page=mesg">
                                            <button type="button"class="btn btn-sm  btn-success"><?php echo $val[$i]['status']; ?>
    </button>
    </a> --->

                                            <td class="padding_right_px"><?php echo $d; ?></td>

            <td><!--<a onClick="javascript:if(confirm('Are you sure want to Delete Post ?')){return true;} else{return false}" href="Link_Library/delete_post.php?idpost=<?php echo $val[$i]['post_id']; ?>&page=mesg"><button type="button"class="btn btn-sm  btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</button></a>-->

                                                <a target="_blank" href="full_view_message.php?idpost=<?php echo $val[$i]['post_id'] ?>" style="color:#00a4fd;margin-left:29px !important;" >View</a>

												<a target="_blank" href="update_message.php?idpost=<?php echo $val[$i]['post_id']; ?>&page=message" style="color:#00a4fd;margin-left:29px !important;">Edit</a>
												
                                                <a href="Link_Library/link_post_status.php?postid=<?php echo $val[$i]['post_id']; ?>&poststatus=<?php echo $val[$i]['status']; ?>&page=mesg" style="color:#CE3030;margin-left:30px !important"><?php echo $action; ?>

                                                </a>

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

    <?php include 'footer.php'; ?>