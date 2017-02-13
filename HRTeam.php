	<?php include 'navigationbar.php';?>
		<?php include 'leftSideSlide.php';?>

                             
<?php require_once('Class_Library/class_getpost.php'); 
$object = new GetPOST();
$result = $object->getAllPost();
$val = json_decode($result,true);
$count  = count($val);
?>

				<div class="container-fluid">
				<div class="addusertest">
			<a href="HR_post.php"><button type="button"class="btn btn-sm btn-default"style="text-shadow:none;"><b>Create Post</b></button></a>
	</div>
                <div class="side-body padding-top">
				
				<h3>No posts found<br></h3>
				
						<div class="card-body">
                                    <table class="datatable table table-responsive" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Title</th>
                                                <th>Status</th>
                                                <th>Last Updates</th>
                                                <th>Action</th>
                                                 <!--<th>Salary</th>-->
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                              <th>Image</th>
                                                <th>Title</th>
                                                <th>Status</th>
                                                <th>Last Updates</th>
                                                <th>Action</th>
                                                <!--<th>Salary</th>-->
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                           
                                            <?php
                                     for($i=0; $i<$count; $i++)
                                              {
                                     //  echo $val[$i]['post_id']."<br/>";
                                           ?>   
                                        <tr>
                                              <td><img src="img/aa.jpg"class="img"id="news_images"/></td>
                                                <td><?php echo $val[$i]['post_title']; ?></td>
                                                <td><button type="button"class="btn btn-sm  btn-success"><span class="glyphicon glyphicon-thumbs-up"></span><?php echo $val[$i]['post_title']; ?></button></td>
                                                <td><?php echo $val[$i]['created_date'];  ?></td>
                                              
                                             <td>		<button type="button"class="btn btn-sm  btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete</button></td>
                                               
                                            </tr>
                                       <?php
                                       }
                                       ?>   
                                            
                                        </tbody>
                                    </table>
							</div>
				</div>
				</div>
				<?php include 'footer.php';?>