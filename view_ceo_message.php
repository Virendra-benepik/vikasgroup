<?php include 'navigationbar.php'; ?>
<?php include 'leftSideSlide.php'; ?>	                             
<?php
require_once('Class_Library/class_get_ceomessage.php');

$object = new GetCEOMessage();
$clientid = $_SESSION['client_id'];
$user_uniqueid = $_SESSION['user_unique_id'];
$user_type = $_SESSION['user_type'];

$result = $object->getAllCEOMessage($clientid, $user_uniqueid, $user_type);
$val = json_decode($result, true);
//echo "<pre>";
//print_r($val);
$count = count($val['posts']);
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
                                <div class="title"><strong>Leadership Message</strong></div>
                            </div>
                            <!--    <div style="float:left; margin-top:13pxpx; font-size:20px;"> 
                                <a href="postnews.php">
             <button type="button" class="btn btn-primary btn-sm">Create New Message</button>
                                </a>
                                 </div>-->
                        </div>

                        <div class="card-body">
                            <table class="datatable table table-responsive" cellspacing="2" width="100%" id="myTable">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>Image</th>
                                        <th>Total View</th>
                                        <th>Unique View</th>
                                        <th>Like</th>
                                     <th>Comment</th>
                                        <th>Title</th>

                                        <th>Description</th>
                                        <th>Last Updates</th>
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
                                            <td><?php echo $val['posts'][$i]['TotalCount']; ?></td>
                                             <td><?php echo $val['posts'][$i]['ViewPostCount']; ?></td>
                                            <td><?php echo $val['posts'][$i]['likeCount']; ?></td>
                                            <td><?php echo $val['posts'][$i]['commentCount']; ?></td>
                                           

                                            <td class="padding_right_px"><?php
                                    $cont = $val['posts'][$i]['post_title'];
                                    $words = explode(" ", $cont);
                                    $word = implode(" ", array_splice($words, 0, 10));
                                    echo $word;
                                    ?>
                                            </td>
                                            <td class="padding_right_px"><?php
                                                $cont1 = $val['posts'][$i]['post_content'];

                                                $words = explode(" ", $cont1);
                                                $word = implode(" ", array_splice($words, 0, 7));
                                                echo $word."..";
                                                ?></td>
                                            <td class="padding_right_px"><?php echo $val['posts'][$i]['created_date']; ?></td>

                                            <td class="padding_right_px">
    <!--<a onClick="javascript:if(confirm('Are you sure want to Delete Post ?')){return true;} else{return false}" href="Link_Library/delete_post.php?idpost=<?php echo $val[$i]['post_id']; ?>">
    <button type="button"class="btn btn-sm  btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete
    </button>
    </a>-->

                                                <a target="_blank" href="full_view_CEOMessage.php?idpost=<?php echo $val['posts'][$i]['post_id'] ?>"style="color:#00a4fd;">View
                                                </a>

												<!--<a target="_blank" href="update_news.php?idpost=<?php echo $val['posts'][$i]['post_id'] ?>&page=leadership"style="color:#00a4fd;"> Edit
                                                </a>-->
												
												<a target="_blank" href="update_leadership.php?idpost=<?php echo $val['posts'][$i]['post_id'] ?>&page=leadership"style="color:#00a4fd;"> Edit
                                                </a>
												
                                                <a href="Link_Library/link_post_status.php?postid=<?php echo $val['posts'][$i]['post_id']; ?>&poststatus=<?php echo $val['posts'][$i]['status']; ?>&page=ceomessage" style="color:#CE3030;margin-left:30px !important">
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