<?php  include 'navigationbar.php';?>
<?php  include 'leftSideSlide.php';?>

<?php
require_once('Class_Library/class_HappinesQuestion.php');
$obj = new HappinessQuestion();
   
$qid = $_GET['qid'];
$clientid = $_GET['clientid'];
$sid = $_GET['sid'];
$ques1 =  $obj->getSurveyquestion($qid,$clientid,$sid);
//echo $ques1;
$ques = json_decode($ques1, true);
//print_r($ques);
//echo $sid;
?>
<!--------------------------------------------------------- start from here-------------------------------->

  <div class="container-fluid">
                <div class="side-body">
                    <input type="hidden" name="qid" id ="qid" value = "<?php echo $qid; ?>">
                     <input type="hidden" name="qid" id ="clientid" value = "<?php echo $clientid; ?>">
                      <input type="hidden" name="qid" id ="sid" value = "<?php echo $sid; ?>">
                 <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;margin-top:20px;">
                    <div class="row">
                        <div class="col-xs-10 col-md-offset-1">
                            <div class="card">
                               <div class="card-header">

                                    <div class="card-title">
                  <div class="title"> <span style="font-size:17px;font-weight:bold;">Survey Question</span></div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div>
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                           
<div class='col-md-12 col-xs-12 col-sm-12 col-lg-12' style="font-size:16px;">
    <p><?php echo $ques['question']; ?></p>

</div>
               
                                            </div>
                                        </div>
                                    </div>
                                   
                 <div >
                     <p style="font-size:16px;font-weight:500;font-weight:bold;">Survey Answer</p>
                    
                 </div>
                           <div class="panel panel-default">
                                            <div class="panel-body">
                                           
							<div class="col-md-10" id="anlyticgraph">
							
					     <div id="chart-container">FusionCharts will render here</div>
                                                          
					   
                                        </div>
                                       
                                    </div>
                                   
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
     </div>
			
			<script src="js/analytic/questionresult.js"></script>
<script src="js/analytic/fusioncharts.charts.js"></script>
<script src="js/analytic/fusioncharts.js"></script>
<script type="text/javascript">
 var quid = $("#qid").val(); //"Android";
    var sid = $("#sid").val();//"2016-12-30"; 
    var clientid = $("#clientid").val(); 
   showGraphFunction1(quid,sid,clientid);
  
</script>
				<?php include 'footer.php';?><?php

