<!-----------
Created BY - Monika Gupta
Created Date - 26/10/2016

------------>

<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';?>	               
              
<?php require_once('Class_Library/class_getaward.php');
$object = new Getaward();
$clientid = $_SESSION['client_id'];
//$user_uniqueid = $_SESSION['user_unique_id'];
//$user_type = $_SESSION['user_type'];

$result = $object->viewemployeeawardlist($clientid);
echo $json = json_decode($result, true);				
 //echo "<pre>";
 //print_r($json);
 echo $no = count($json['Data']);					
//print_r($val["Data"]);
//$count  = count($val);
//$path = "http://admin.benepik.com/employee/virendra/benepik_client/";
 $path=SITE;

?>

			<div class="container-fluid">
			<div class="addusertest">
			
	</div>
	              <div class="side-body" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;margin-top:60px;">
                   
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="card">
                                <div class="card-header">

                                    <div class="card-title">
                                    <div class="title">Employee Award Lists</div>
									
                                    </div>
                                    <div style="margin-top:15px; font-size:20px;"> 
                                    <a href="employeeAdd_Awards.php">
									<button type="button" class="btn btn-sm btn-info createNewsBtn">Add Employee Award</button>
                                    </a>
                                     </div>
                                </div>
 
                                <div class="card-body">
                                    <table class="datatable table table-responsive" cellspacing="2" width="100%" id="1myTable">
                                        <thead class="thead-inverse">
                                            <tr>
                                                <th>Image</th>
                                                <th>Employee Name</th>
                                                 <th>Award Name</th>
                                                 <th>Description</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                                
                                            </tr>
                                        </thead>
                                       
                                        <tbody>
										<form name="form1" id="form1" method="POST">  
<?php for($row=0; $row<$no; $row++ )
	  {
		 $userimage = $json['Data'][$row]['userImage'];
		 
		 
		 if($userimage != '')
		 { 
				
		     // $imgpath = 'http://localhost/benepik/benepic_admin/benepik_admin/';
			 // $_SERVER['SERVER_NAME'];
			  //$servername = $_SERVER['SERVER_NAME'];
			  //$imgpath = '/benepik/benepic_admin/benepik_admin/';
			  $userimg = $path.$userimage;
		 
		 }
		 else
		 {
			  $userimg = 'images/usericon.png';
		 }
?>			
										<tr>
                                         <td><img src="<?php echo $userimg; ?>"class="img img-rounded"id="news_images" onerror='this.src="images/usericon.png"'/></td>
                                          <td><?php echo $json['Data'][$row]['firstName']; ?></td>
                                          <td><?php echo $json['Data'][$row]['awardName']; ?></td>
										  
										  <?php $string = strip_tags($json['Data'][$row]['commentDesc']);
											if (strlen($string) > 50) 
											{
											$stringCut = substr($string, 0, 50);
											$string = substr($stringCut, 0, strrpos($stringCut, ' ')).'......'; 
											//$string = substr($stringCut, 0, strrpos($stringCut, ' ')).'....<a href="#">Read More</a>';
											//$string = substr($stringCut, 0, strrpos($stringCut, ' '))."....<a href='#=".$json['Data'][$row]['commentDesc']."'>Read More</a>";   
											}
											echo "<td>".$string."</td>";
										  ?>
										 
                                         
                                        <td><?php echo $json['Data'][$row]['awardDate']; ?></td>
                                        
                                              
                                        <td>
										<a target="_blank" href="view_employeeAwardListDetails.php?employeeAwardId=<?php echo $json['Data'][$row]['employeeAwardId'];?>">
										<button type="button"class="btn btn-sm btn-info viewNewsBtn"> View
										</button>
										</a>
										</td>
                                        </tr>
                                      <?php } ?>
                                      
</form>
                                          </tbody>
                                    </table>


	
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			
				<?php include 'footer.php';?>