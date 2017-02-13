<html>
<head>
<style>
			.chart-container {
				width: 900px;
				height: auto;
				font-weight: bold;
                                font-size: xx-large;
                                color: blue;
				
			}
		</style>
		<script type="text/javascript" src="lib/js/jquery.min.js"></script>
 <script src ="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.min.js"></script>
	        <script type="text/javascript" src="analytic_js/app.js"></script>
</head>
<body>
<form method="post">
	<select name="clientid" id="clientid">
	<option selected>select</option>
	<option value ='CO-7'>Bconect demo</option>
	<option value ='CO-17'>Beconnect</option>
	<option value ='CO-16'>Mahle Connect</option>
	
	</select>
	</form>
          
           
                                <div class="chart-container">
			<canvas id="mycanvas"></canvas>
		</div>          
</body>
</html>