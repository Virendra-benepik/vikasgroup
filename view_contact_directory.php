<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';?>
	                             

	<!----------------------------------------------------------->
	
	
<?php
session_start();
error_reporting(E_ALL);
ini_set('display_error',1);
include_once('Class_Library/class_contact_directory.php');
$clientid = $_SESSION['client_id'];
//$clientid = 'CO-22';
//echo $clientid;
$obj = new ContactPerson();
$resp = $obj->clientContactDetails($clientid);
$getval = json_decode($resp,true);
$count = count($getval['posts']);
//echo "<pre>";
//print_r($getval);
?>
<style>
.top{
    margin-bottom: 30px !important;
}
.bottom{
margin-top:60px !important;
}
</style>
	<!--------------------------------------------------------->
	
			<div class="container-fluid">
			<!--<div class="addusertest">
			<a href="create_post.php"><button type="button"class="btn btn-sm btn-default"style="text-shadow:none;"><b>Create Post</b></button></a>
	</div> -->
	              <div class="side-body">
                    <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="card">
                                <div class="card-header">

                                    <div class="card-title">
                                    <div class="title"><strong>Contact List</strong></div>
                                    </div>
                                    <div class="card-title" style="float:left;">
                                    <div class="title"><a href="create_contact_directory.php"><button type="button" class="btn btn-primary btn-sm">Create New Contact</button></a></div>
                                    </div>
                                </div>
  
                                <div class="card-body">
                                    <table class="datatable table table-responsive" id="myTable" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Name</th>
                                                 <th>Company</th>
                                                <th>Location</th>
                                                <th>Department</th>
                                                  <th>Contact No.(Office)</th>
                                                 <th>Contact No.(Personal)</th>
                                           <th><center>Action</center>	</th> 
                                                  <!-- <th>Salary</th>-->
                                            </tr>
                                        </thead>
                                       <tfoot>
                                            <tr>
                                             <th>Image</th>
                                                <th>Name</th>
                                                <th>Company</th>
                                                <th>Location</th>
                                                <th>Department</th>
                                                 <th>Contact No.(Office)</th>
                                                 <th>Contact No.(Personal)</th>
                                             <th>Action</th> 
                                           <!--      <th>Salary</th>-->
                                            </tr>
                                        </tfoot> 
                                        <tbody>
                                     <?php
									
                                     for($i=0; $i<$count; $i++)
                                              {
                                     $name = $getval['posts'][$i]['userName'];
                                     ?>       	
					      <tr>
                                              <td><img src="<?php echo $getval['posts'][$i]['imgPath']; ?>"class="img img-circle img-responsive" onerror='this.src="images/u.png"' id="news_images2" /></td>
                                                <td class="padding_right_px"><?php echo $name; ?></td>
                                                 <td class="padding_right_px"><?php echo $getval['posts'][$i]['companyName']; ?></td>
                                                 <td class="padding_right_px"><?php echo $getval['posts'][$i]['locationName']; ?></td>
                                                 <td class="padding_right_px"><?php echo $getval['posts'][$i]['departmentName']; ?></td>
                                                 <td class="padding_right_px"><?php echo $getval['posts'][$i]['contactNoOffice']; ?></td>
                                                  <td class="padding_right_px"><?php echo $getval['posts'][$i]['contactNoPersonal']; ?></td>
                                           
                                                
                                      <td><a href="edit_contact_directory.php?contactid=<?php echo $getval['posts'][$i]['contactId']; ?>" style="color:#00a4fd;margin-left:29px !important;">Edit</a>
                       
                       <!--<a href="view_contact_directory.php?cp_id=<?php echo $getval['posts'][$i]['contactId']; ?>" onclick="return confirm('Are you sure you want to delete this item?');" style="color:#CE3030;margin-left:30px !important"> </span> Delete</a>-->            
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