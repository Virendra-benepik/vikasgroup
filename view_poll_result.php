<?php  include 'navigationbar.php';?>
<?php  include 'leftSideSlide.php';?>

<?php  require_once('Class_Library/class_getpoll.php'); ?> 
                  
<?php 
$poll_obj = new GetPoll();

$clientids = $_GET['clientid'];
$pollids = $_GET['pollid'];

$result = $poll_obj->getAnswerOptions($pollids,$clientids);
$getcat = json_decode($result,true);

$count = count($getcat['option']);
$ques = $getcat['poll_question'];
$quesimg = $getcat['poll_image'];

$value = $getcat['option'];

?>

 <?php
  $idpoll = $_GET['pollid'];
 
$result = $poll_obj->getAnswerResult($idpoll);
$output = json_decode($result,true);

$total = $output['posts1'][0]['Alltotals'];
$value = $output['posts'];
$val =count($output['posts']);

for($i=0;$i<$val;$i++)
{

if($value[$i]['ansInImage']!="")
{

$res = ($optTol*100)/$total."%";
}
else
{
$optTol = $value[$i]['TotalAnswerOFoption'];
$res = ($optTol*100)/$total."%";

}
}
?>
<!--------------------------------------------------------- start from here-------------------------------->
  <div class="container-fluid">
                <div class="side-body">
                 <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;margin-top:20px;">
                    <div class="row">
                        <div class="col-xs-10 col-md-offset-1">
                            <div class="card">
                               <div class="card-header">

                                    <div class="card-title">
                                    <div class="title"> <span style="font-size:17px;font-weight:bold;">Feedback Question</span></div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div>
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                           
<div class='col-md-12 col-xs-12 col-sm-12 col-lg-12' style="font-size:16px;">
<?php echo $ques; ?>
</div>

                                              
                                            </div>
                                        </div>
                                    </div>
                                   
                 <div ><p style="font-size:16px;font-weight:500;font-weight:bold;">Feedback Option</p><span style="float:right;margin-top:-3%;">Respondents: <?php echo $total;  ?> </span></div>
                             <div class="panel panel-default">
                                           <?php

                                     for($i=0; $i<$count; $i++)
                                     {
                                     $path = "http://admin.benepik.com/employee/virendra/benepik_client/";
                                      $optTol = $value[$i]['TotalAnswerOFoption'];
                                     if($total == 0)
                                      {
                                      $res = '0%';
                                      }
                                      else
                                      {
                                      $res = ($optTol*100)/$total."%";
                                      }
                                      $ansimg = $getcat['option'][$i]['ansInImage'];
                                      $ans = $getcat['option'][$i]['ansInText'];
				
                                     
                                  ?>
                                          
                                           <div class="panel-body">
                                           
                                           <?php
                                               if($ans != "")
                                                {
                                                ?>
                                                 
							<div class="col-md-10">
							<?php echo $ans; ?>
							<div class="progress">
    <div class="progress-bar progress-bar-striped progress-bar-info active" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $res; ?>"> 
     </div>
     
							</div>
							
							
						<?php	
						}
						else
						{
						$fullpath = $path.$ansimg;
					        ?>
					     
					     <div class="col-md-3">
					     <img src="<?php echo $fullpath; ?>" class="img" width="150" height="80">
					    
					     </div>
					     
					     <div class="col-md-8">
							
							<div class="progress">
    <div class="progress-bar progress-bar-striped progress-bar-info active" role="progressbar"  
    aria-valuemin="0" aria-valuemax="100" style="width:<?php echo $res; ?>"> 
     </div>
							</div>
					     
					     <?php
					     }
					     ?>
                                            
                                           </div>
					 <div class="col-md-2"><?php echo $res; ?></div>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                      
                                       
                                          
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
     </div>
			
			
				<?php include 'footer.php';?>