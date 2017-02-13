<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';?>	                             
<?php require_once('Class_Library/class_recognize_analytics.php');
require_once('Class_Library/class_get_useruniqueid.php');
$gt = new RecognizeAnalytic();

$clientid = $_SESSION['client_id'];
$user_uniqueid = $_SESSION['user_unique_id'];
$user_type = $_SESSION['user_type'];

$result = $gt->getUseVoucherDetails($clientid);
$val = json_decode($result,true);
$count  = count($val['data']);
$path = "http://admin.benepik.com/employee/virendra/benepik_admin/";

?>
	
			<div class="container-fluid">
			<div class="addusertest">
			
	</div>
	              <div class="side-body">
                    <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;margin-top:-45px;">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="card">
                                <div class="card-header">

                                    <div class="card-title">
                                    <div class="title"><strong>All Recognition Details</strong></div>
                                    </div>
                                   
                                </div>
 
                                <div class="card-body">
                                    <table class="datatable table table-responsive" cellspacing="2" width="100%" id="myTable">
                                        <thead class="thead-inverse">
                                            <tr>
                                                <th>Voucher Name</th>
                                                
                                                <th>Voucher Amount</th>
                                                 <th>Total Purchase</th>
                                                  <th>Total Amount</th>
                                               
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                            <th>Voucher Name</th>
                                           
                                                <th>Voucher Amount</th>
                                                 <th>Total Purchase</th>
                                                  <th>Total Amount</th>
                                            </tr>
                                        </tfoot> 
                                        <tbody>
<form name="form1" id="form1" method="post">
                                     <?php
                               /*  echo "<pre>";
                                 print_r($val);
                                 echo "</pre>";
                                  echo  "count of table- ".$count;*/
                                     for($i=0; $i<$count; $i++)
                                              {
                                         
                                              ?>       	
					      <tr>
                                              <td><?php echo  $val['data'][$i]['name'];?></td>
                                               <td><?php echo $val['data'][$i]['voucherPoints'];?></td>
                                                <td><?php echo $val['data'][$i]['totalvoucher']; ?></td>
                                                  <td><?php echo $val['data'][$i]['totalamount']; ?></td>
                                              
                                     <td  style="width:16% !important;">
<!--<a onClick="javascript:if(confirm('Are you sure want to Delete Post ?')){return true;} else{return false}" href="Link_Library/delete_post.php?idpost=<?php echo $val[$i]['post_id']; ?>">
<button type="button"class="btn btn-sm  btn-danger"><span class="glyphicon glyphicon-trash"></span> Delete
</button>
</a>--->

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
				<?php include 'footer.php';?>