<?php session_start(); ?>
<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';?>

<style>
			.chart-container {
				width: 1000px;
				height: auto;
				font-weight: bold;
                                font-size: 14px;
                               
				
			}
		</style>
 <script src ="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.min.js"></script>
	        <script type="text/javascript" src="analytic_js/app.js"></script>

<div class="container-fluid">
			<div class="addusertest">
			
	</div>
	              <div class="side-body">
                   <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;margin-top:10px;">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="card">
                                <div class="card-header">


                                    <div class="card-title">
                                    <div class="title"><strong>Approve Recognize Point</strong></div>
                                    </div>
                                   
                                </div>
                                   <input type="hidden" name="clientid" id="clientid" value="<?php echo $_SESSION['client_id']; ?>">

                           <!--     <div class="card-body">
                               
     
                                </div>
                                -->
                                <div class="chart-container">
			<canvas id="mycanvas"></canvas>
		</div>
		<br>
		<br>
                            </div>
                        </div>
                    </div>
                </div>
				</div>
            </div>


		
	<?php include 'footer.php';?>