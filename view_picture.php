<?php include 'navigationbar.php';?>
		<?php include 'leftSideSlide.php';?>
	                             
<?php require_once('Class_Library/class_getpost.php'); 
$object = new GetPOST();

$clientid = $_SESSION['client_id'];
$user_uniqueid = $_SESSION['user_unique_id'];
$user_type = $_SESSION['user_type'];

$result = $object->getAllPicture($clientid,$user_uniqueid,$user_type);
$val = json_decode($result,true);
//echo "<pre>";
//print_r($val);
$count  = count($val);
$servername = $_SERVER['SERVER_NAME'];
$path = SITE;


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
                                    <div class="title"><strong>ALL Pictures Details</strong></div>
                                    </div>
                                 <!--   <div style="float:left; margin-top:13px; font-size:20px;"> 
                                    <a href="postpicture.php">
                 <button type="button" class="btn btn-primary btn-sm">Create New Picture</button>
                                    </a>
                                     </div> -->
                                </div>
                                

                                <div class="card-body">
                                    <table class="datatable table table-responsive" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Caption</th>
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
                                              <th>Image</th>
                                                <th>Caption</th>
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
									 function charfunction($myStr,$limit=15) 
												{    
													$result = "";
													for($i=0; $i<$limit; $i++) {
														$result .= $myStr[$i];
													}
													return $result;    
												}
                                 //    print_r($val);
                                     for($i=0; $i<$count; $i++)
                                              {
                                              
                                              $k = $val[$i]['status'];
                                             // echo $k;
if($k == 'Unpublish')
{
$action = 'Publish';
}
else
{
$action = 'Unpublish';
}
                                              
                                              
                                     // echo $path.$val[$i]['post_img']."<br/>";

                                     ?>       	
					      <tr>
                                              <td>
                                  
                                              <img src="<?php echo $path.$val[$i]['post_img']; ?>"class="img img-rounded"id="news_images" onerror='this.src="images/u.png"'/>
                                              </td>
                                                <td>
												
												<p style="width:15% !important;"><?php 
												
                                                 $cont =  $val[$i]['post_content'];
												 $words = explode(" ",$cont);
											     $word = implode(" ", array_splice($words, 0, 17));
												 
												 $strres = charfunction($word);
												 if(strlen($strres) < 15)
												 {
													$result = $strres; 
												 }
												 else
												 {
													$result = $strres.".........<a style='color:#00a4fd;' href='full_view_picture.php?idpost=".$val[$i]['post_id']."'>Read&nbsp;More</a>"; 
												 }
												 echo $result;
										
					  
                                                
                                             //   echo $val[$i]['post_content']; ?></p></td>
                                                <td><center><?php echo $val[$i]['TotalCount']; ?></center></td>
                                                <td><center><?php echo $val[$i]['ViewPostCount']; ?></center></td>
                                                <td><center><?php echo $val[$i]['likeCount']; ?></center></td>
                                                <td><center><?php echo $val[$i]['commentCount']; ?></center></td>
                                                <td class="padding_right_px"><?php echo $val[$i]['status']; ?></td>
                                             
                                                <td class="padding_right_px"><?php echo $val[$i]['created_date'];  ?></td>
                                              
                                             <td  style="width:16% !important;"><!--<a onClick="javascript:if(confirm('Are you sure want to Delete Post ?')){return true;} else{return false}" href="Link_Library/delete_post.php?idpost=<?php echo $val[$i]['post_id']; ?>&page=picture">	<button type="button"class="btn btn-sm  btn-danger"><span class="glyphicon glyphicon-trash"></span>  Delete</button></a>-->
                                                                                        
<a target="_blank" href="full_view_picture.php?idpost=<?php echo $val[$i]['post_id']?>" style="color:#00a4fd;margin-left:29px !important;">View</a>


<a href="Link_Library/post_status.php?postid=<?php echo $val[$i]['post_id']; ?>&poststatus=<?php echo $val[$i]['status']; ?>&page=picture" style="color:#CE3030;margin-left:30px !important"><?php echo $action; ?></a>

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
			
				<?php include 'footer.php';?>