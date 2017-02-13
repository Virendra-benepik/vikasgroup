<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';?>
	                             
<?php require_once('Class_Library/class_get_recognition_user_account.php'); 
$object = new RecognizeUserAccount();

$clientid = $_SESSION['client_id'];
$user_uniqueid = $_SESSION['user_unique_id'];
$user_type = $_SESSION['user_type'];
$nid = $_GET['recogid'];

$result = $object->getRecognitionUserAccountData($clientid,$nid);
$val = json_decode($result,true);

$result1 = $object->getUserAccountBalance($clientid,$nid);
$val1 = json_decode($result1,true);

$count  = count($val['data']);
$path = "http://admin.benepik.com/employee/virendra/benepik_client/";

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
                                    <div class="title">User Personal Account Details</div>
                                    <?php
                          echo  "<p>    Total Amount:    <b>". $val1['Totalamount']."</b>    </p>";
                           echo "<p>   Total Redeem Ammount:  <b>  ". $val1['TotalRedeem']." </b> </p>";
                             echo "<p> Balance :   <b>  ". $val1['balance']. " </b> </p>";
                                    ?>
                                    </div>
                                   
                                </div>
                             

                                <div class="card-body">
                                    <table class="datatable table table-responsive table-striped" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Entry Date</th>
                                              
                                                <th>Recognize By/Redeemed By</th>
                                                <th>Earning Amount</th>
                                               <th>Redeem Amount</th>
                                               
                                            </tr>
                                        </thead>
                                        <tfoot>
                                           <tr>
                                                <th>Entry Date</th>
                                              
                                                <th>Recognize By</th>
                                                <th>Earning Amount</th>
                                               <th>Redeem Amount</th>
                                               
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                     <?php
                                   
                                     for($i=0; $i<$count; $i++)
                                              {
                                              
                                     ?>       	
					      <tr>
                                             
                                                <td><?php echo $val['data'][$i]['entryDate']; ?></td>
                                                 <td><?php echo $val['data'][$i]['RecognizeBy'];  ?></td>
                                                <td><?php   echo $val['data'][$i]['EarningPoint'];  ?></td> 
                                               
                                                <td> <?php  echo $val['data'][$i]['redeempoint']; 
?>
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