<?php include 'navigationbar.php'; ?>
<?php include 'leftSideSlide.php'; ?>	                             
<?php
require_once('Class_Library/class_upload_album.php');

$object = new Album();
$clientid = $_SESSION['client_id'];
$user_uniqueid = $_SESSION['user_unique_id'];
$user_type = $_SESSION['user_type'];
$device = "panel";
$result = $object->getAlbum($clientid, $user_uniqueid, $device);

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
                                <div class="title"><strong>All Galleries</strong></div>
                            </div>
                          <!--  <div style="float:left; margin-top:13px; font-size:20px;"> 
                                <a href="multipleImageUpload.php">
                                    <button type="button" class="btn btn-primary btn-sm">Create New Album</button>
                                </a>
                            </div>--->
                        </div>

                        <div class="card-body">
                            <table class="datatable table table-responsive" cellspacing="2" width="100%" id="myTable">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
										<th>Last Updates</th>
                                        <th>Action</th>

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

                                        // echo $path.$val[$i]['post_img']."<br/>";
                                        ?>       	
                                        <tr>
                                            <td>

                                                <img src="<?php echo $val['posts'][$i]['image']; ?>"class="img img-rounded"id="news_images" onerror='this.src="images/u.png"'/> </td>

                                            <td class="padding_right_px"><?php
                                                $cont = $val['posts'][$i]['title'];
                                                $words = explode(" ", $cont);
                                                $word = implode(" ", array_splice($words, 0, 10));
                                                echo $word;
                                                ?>
                                            </td>
                                            
                                            <td class="padding_right_px"><?php echo $val['posts'][$i]['createdDate']; ?></td>

                                            <td  style="width:16% !important;">
    <!--<a onClick="javascript:if(confirm('Are you sure want to Delete Post ?')){return true;} else{return false}" href="Link_Library/delete_post.php?idpost=<?php echo $val[$i]['post_id']; ?>">
    <button type="button"class="btn btn-sm  btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete
    </button>
    </a>-->

                                                <a target="_blank" href="full_view_album.php?albumid=<?php echo $val['posts'][$i]['albumId'] ?>" style="color:#00a4fd;margin-left:10px !important;">View</a>

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