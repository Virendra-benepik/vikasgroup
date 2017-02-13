<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';?>
<?php 
session_start();
$client_id = $_SESSION['client_id'];
echo $client_id;
$string = "cid=$client_id";

$sub_req_url ="http://admin.benepik.com/employee/virendra/benepik_admin/lib/link_get_suggestion.php";
$ch = curl_init($sub_req_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($ch, CURLOPT_POSTFIELDS,  "$string");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);

$resp = curl_exec($ch);
curl_close($ch);
$val = json_decode($resp,true);
$count  = count($val);

?>
<style>
#RecentComment, #latest_activity {
    padding: 20px !important;
    border-radius:2px !important;
   
    box-shadow: rgb(136, 136, 136) -1px 1px 5px 2px;
</style>
	<div class="container-fluid">
	<div class="addusertest">
			<!--<button type="button"class="btn btn-sm btn-default"style="text-shadow:none;"data-toggle="modal" data-target="#ADDuserpopup"><b>Add User</b></button> 		--->	
		</div>
		
			 <!-- *********************************************************Modal for add user************************* -->
 <link rel="stylesheet" href="style.css" type="text/css">
		
 
        <div class="side-body padding-top">
		 <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:100px;">
		<!------------------------------------------------------------------------------------------------------> 
		 <h3><strong>Suggestion Box</strong></h3>
		 <hr>
		
            <div class="row ">
					<?php
						
			for($i=0; $i<$count; $i++)
				{
							                $vis = $val[$i]['visiblity'];
                                            if($vis == 'yes')
                                            {
                                            $path = "http://admin.benepik.com/employee/virendra/benepik_admin/";
                                            $emailid = 'Anonymous';
                                            $putimg = "http://admin.benepik.com/employee/virendra/benepik_admin/Client_img/user_img/download.png";
                                            }
                                            else
                                            {
                                            $path = "http://admin.benepik.com/employee/virendra/benepik_admin/";  
                                            $putimg = $path.$val[$i]['userImage'];
                                            $emailid = $val[$i]['emailId'];
                                            }
                                               ?>
			
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					
					<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				
					<div id="RecentComment">
						<p class="LatestActivitiesHeading"><img style="    width: 50px;
    height: 50px;border:1px solid #dcdcdc;
    border-radius: 100%;
    margin-right: 10px;
    " src="<?php echo $putimg; ?>" onerror='this.src="images/u.png"'/><b><?php echo $emailid; ?></b><br>
<span style="margin-left: 60px;"><?php echo $val[$i]['date_of_sugestion'];  ?></span></p>
						<hr>
						
					<div class="row">
						<div class="col-xs-6 col-sm-4 col-md-2 col-lg-2">
							<span class="glyphicon glyphicon-comment"></span>
						</div>
						<div class="col-xs-6 col-sm-8 col-md-10 col-lg-10">
				               <?php echo $val[$i]['content']; ?>
							   
						</div>
						<!--<div class="col-xs-6 col-sm-8 col-md-10 col-lg-10">
                                                  <span class="glyphicon glyphicon-calendar"></span>
				                  <?php echo $val[$i]['date_of_sugestion'];  ?>
						</div>-->
						
					</div>

					</div>
					</div>
					</div>
					
				</div>
				<?php } ?>
						
			</div>
				
                    
         </div>
	</div>
<?php include 'footer.php';?>