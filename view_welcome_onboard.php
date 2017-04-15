<?php include 'navigationbar.php'; ?>
<?php include 'leftSideSlide.php'; ?>	                             
<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once('Class_Library/class_get_onboard.php');

$object = new GetWelcomeOnboard();
$clientid = $_SESSION['client_id'];
$user_uniqueid = $_SESSION['user_unique_id'];
$user_type = $_SESSION['user_type'];

$result = $object->getAllOnboard($clientid, $user_uniqueid, $user_type);
$val = json_decode($result, true);
//echo "<pre>";
//print_r($val);
$count = count($val['posts']);
$path = SITE_URL;
//$path = "http://admin.benepik.com/employee/virendra/benepik_client/";
?>

<div class="container-fluid">
    <div class="addusertest">

    </div>
    <div class="side-body">

        <div class="row">
            <div class="col-xs-12">
                <div class="card">
                    <div class="card-header">

                        <div class="card-title">
                            <div class="title">All Welcome Aboard Details</div>
                        </div>

                    </div>

                    <div class="card-body">
                        <table class="datatable table table-responsive" cellspacing="2" width="100%" id="myTable">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>Image</th>
									<th>Total View</th>
									<th>Unique View</th>
                                    <th>Joinee's Name</th>
									<th>Created By</th>
									<th>Status</th>
                                    <th>Publish Date</th>
                                    <th>Action</th>

                                </tr>
                            </thead>

                            <tbody>
                            <form name="form1" id="form1" method="post">
                                <?php
                                for ($i = 0; $i < $count; $i++) {
                                    $k = $val['posts'][$i]['status'];
                                    //  echo $k;

                                    if ($k == 'Unpublish') {
                                        $action = 'Publish';
                                    } else {
                                        $action = 'Unpublish';
                                    }

                                    // echo $path.$val[$i]['post_img']."<br/>";
                                    ?>       	
                                    <tr>
                                        <td>

                                            <img src="<?php echo $val['posts'][$i]['post_img']; ?>"class="img img-rounded"id="news_images" onerror='this.src="images/u.png"'/> </td>

                                       
										<td style="padding-left:20px;"><?php echo $val['posts'][$i]['Total_View']; ?></td>
										<td style="padding-left:20px;"><?php echo $val['posts'][$i]['Unique_View']; ?></td>
										<td style="width:14% !important;"><?php
										$cont = $val['posts'][$i]['post_title'];
										$words = explode(" ", $cont);
										$word = implode(" ", array_splice($words, 0, 10));
										echo $word;
										?>
                                        </td>                                       
									   <td style="padding-left:20px;"><?php echo $val['posts'][$i]['created_by']; ?></td>
									   <td style="padding-left:20px;"><?php echo $val['posts'][$i]['status']; ?></td>
                                        <td style="padding-left:20px;"><?php echo $val['posts'][$i]['created_date']; ?></td>

                                        <td  style="width:16% !important;">
    <!--<a onClick="javascript:if(confirm('Are you sure want to Delete Post ?')){return true;} else{return false}" href="Link_Library/delete_post.php?idonboard=<?php echo $val[$i]['post_id']; ?>">
    <button type="button"class="btn btn-sm  btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete
    </button>
    </a>-->

                                            <a target="_blank" href="full_view_onboard.php?idonboard=<?php echo $val['posts'][$i]['post_id']; ?>&dev=d2" style="color:#00a4fd;margin-left:29px !important;">View</a>
											
											<a href="Link_Library/link_post_status.php?postid=<?php echo $val['posts'][$i]['post_id']; ?>&poststatus=<?php echo $val['posts'][$i]['status']; ?>&page=onboard" style="color:#CE3030;margin-left:30px !important"><?php echo $action; ?></a>

    <!---<a href="Link_Library/post_status.php?postid=<?php echo $val[$i]['post_id']; ?>&poststatus=<?php echo $val[$i]['status']; ?>">
    <button type="button"class="btn btn-sm btn-danger unpublishBtn">
    <?php echo $action; ?>
    </button>
    </a>-->

                                        </td>

                                    </tr>

    <?php
}
?>
                            </form>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>