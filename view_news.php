<?php
error_reporting(E_ALL); ini_set('display_errors', 1);
include 'navigationbar.php';
include 'leftSideSlide.php';
require_once('Class_Library/class_getpost.php');

$object = new GetPOST();
$clientid = $_SESSION['client_id'];
$user_uniqueid = $_SESSION['user_unique_id'];
$user_type = $_SESSION['user_type'];

$result = $object->getAllNews($clientid, $user_uniqueid, $user_type);
$val = json_decode($result, true);
//echo "<pre>";
//print_r($val);
$servername = $_SERVER['SERVER_NAME'];
$path = SITE;

$count = count($val);
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
                                <div class="title"><strong>All News Details</strong></div>
                            </div>
                         <!---   <div style="float:left; margin-top:13px; font-size:20px;"> 
                                <a href="postnews.php">
                                    <button type="button" class="btn btn-primary btn-sm">Create New Whats Up</button>
                                </a>
                            </div> --->
                        </div>

                        <div class="card-body">
                            <table class="datatable table table-responsive" cellspacing="2" width="100%" id="1myTable">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
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

                                <tbody>
                                <form name="form1" id="form1" method="post">
                                    <?php
                                    for ($i = 0; $i < $count; $i++) {

                                        $k = $val[$i]['status'];
                                        //  echo $k;

                                        if ($k == 'Unpublish') {
                                            $action = 'Publish';
                                        } else {
                                            $action = 'Unpublish';
                                        }
                                        ?>       	
                                        <tr>
                                            <td>

                                                <img src="<?php echo $path . $val[$i]['post_img']; ?>"class="img img-rounded"id="news_images" onerror='this.src="images/board.png"'/> </td>

                                            <td class="padding_right_px" style="width:14% !important;"><a target="_blank" href="full_view_news.php?idpost=<?php echo $val[$i]['post_id'] ?>"><?php
                                                    $cont = $val[$i]['post_title'];
                                                    $words = explode(" ", $cont);
                                                    $word = implode(" ", array_splice($words, 0, 10));
                                                    echo $word;

                                                    // echo $val[$i]['post_title']; 
                                                    ?></a></td>
                                            <td><center><?php echo $val[$i]['TotalCount']; ?></center></td>
                                        <td><center><?php echo $val[$i]['ViewPostCount']; ?></center></td>
                                        <td><center><?php echo $val[$i]['likeCount']; ?></center></td>
                                        <td><center><?php echo $val[$i]['commentCount']; ?></center></td>

                                        <td class="padding_right_px"><?php echo $val[$i]['status']; ?></td>
                                        <td class="padding_right_px"><?php echo $val[$i]['created_date']; ?></td>

                                        <td  style="width:16% !important;">
    <!--<a onClick="javascript:if(confirm('Are you sure want to Delete Post ?')){return true;} else{return false}" href="Link_Library/delete_post.php?idpost=<?php echo $val[$i]['post_id']; ?>">
    <button type="button"class="btn btn-sm  btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete
    </button>
    </a>-->

                                            <a target="_blank" href="full_view_news.php?idpost=<?php echo $val[$i]['post_id'] ?>" style="color:#00a4fd;margin-left:29px !important;">View</a>
											
											<a target="_blank" href="update_news.php?idpost=<?php echo $val[$i]['post_id'] ?>&page=news" style="color:#00a4fd;margin-left:29px !important;">Edit</a>
											
											 <!--<a target="_blank" href="update_news.php?idpost=<?php echo $val[$i]['post_id'] ?>&page=news" style="color:#00a4fd;margin-left:29px !important;">Edit</a>-->
                                            <a href="Link_Library/link_post_status.php?postid=<?php echo $val[$i]['post_id']; ?>&poststatus=<?php echo $val[$i]['status']; ?>" style="color:#CE3030;margin-left:30px !important">

                                                <?php echo $action; ?>

                                            </a>

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
</div>
<?php include 'footer.php'; ?>