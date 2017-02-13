<?php include 'navigationbar.php'; ?>
<?php include 'leftSideSlide.php'; ?>	               
<?php
require_once('Class_Library/class_getaward.php');
$object = new Getaward();
//$clientid = $_SESSION['client_id'];
//echo $clientid;
$clientid = 'CO-22';
$result = $object->getAllAward($clientid);
$val = json_decode($result, true);
//echo "<pre>";
//print_r($val);
$path=SITE;
$no = count($val['Data']);
//$path = "http://admin.benepik.com/employee/virendra/benepik_client/";
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
                                <div class="title"><strong>All Award Lists</strong></div>

                            </div>
                            <div style="float:left; margin-top:13px; font-size:20px;"> 
                                <a href="employeeAdd_Awards.php">
                                    <button type="button" class="btn btn-sm btn-info createNewsBtn">Create New Award</button>
                                </a>
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="datatable table table-responsive" cellspacing="2" width="100%" id="1myTable">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>Image</th>
                                        <th>Award Name</th>
                                        <th>Award Description</th>
                                        <th>Created Date</th>

                                        <th>Status</th>

                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                <form name="form1" id="form1" method="POST">  
                                    <?php
                                    for ($row = 0; $row < $no; $row++) {
										?>	
                                        <tr>
                                            <td><img src="<?php echo $path.$val['Data'][$row]['imageName']; ?>"class="img img-rounded"id="news_images" onerror='this.src="images/m.png"'/> </td>
                                            <td><?php echo $val['Data'][$row]['awardName']; ?></td>
                                            <!--<td><?php echo $val['Data'][$row]['awardDescription']; ?></td>-->

                                            <?php
                                            $string = strip_tags($val['Data'][$row]['awardDescription']);
                                            if (strlen($string) > 50) {
                                                $stringCut = substr($string, 0, 50);
                                                $string = substr($stringCut, 0, strrpos($stringCut, ' ')) . '......';
                                                //$string = substr($stringCut, 0, strrpos($stringCut, ' ')).'....<a href="#">Read More</a>';
                                                //$string = substr($stringCut, 0, strrpos($stringCut, ' '))."....<a href='#=".$val['Data'][$row]['awardDescription']."'>Read More</a>";   
                                            }
                                            echo "<td>" . $string . "</td>";
                                            ?>

                                            <td><?php echo $val['Data'][$row]['createdDate']; ?></td>
                                            <td><?php echo ($val['Data'][$row]['status'] == 0) ? 'Not Active' : 'Active'; ?></td>


                                            <td>
                                                <a target="_blank" href="view_awardListDetails.php?awardid=<?php echo $val['Data'][$row]['awardId']; ?>">
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
</div>

<?php include 'footer.php'; ?>