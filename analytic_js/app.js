$(document).ready(function(){

    var str = "";
    str = $("#clientid").val();
// alert(str);
 
gettotalpoints(str);
 
 });
  function gettotalpoints(str)
  {
	$.ajax({
		url : "http://admin.benepik.com/employee/virendra/benepik_client/analytic_data/recog_data.php",
		 type : 'POST',
                 datatype : 'JSON',
		data : { clientid : str },
		success : function(data){
		       
			var dates = [];
			var points = [];
			
 var json = $.parseJSON(data);
  for(var i=0; i<json.length;i++)
  {
  dates.push(json[i].dateOfEntry);
  points.push(json[i].totalpoints);
  }

console.log(points);
console.log(dates);

			var chartdata = {
				labels: dates,
				datasets: [
					{
						label: "Point",
						fill: false,
						lineTension: 0.1,
						backgroundColor: "rgba(59, 89, 152, 0.75)",
						borderColor: "rgba(59, 89, 152, 1)",
						 borderCapStyle: 'butt',
            borderDash: [],
            borderDashOffset: 0.0,
            borderJoinStyle: 'miter',
						pointHoverBackgroundColor: "rgba(59, 89, 152, 1)",
						pointHoverBorderColor: "rgba(59, 89, 152, 1)",
						  pointBackgroundColor: "#fff",
						data: points
					}
				     
				]
			};

			var ctx = $("#mycanvas");
                       
			var LineGraph = new Chart(ctx, {
				type: 'line',
				
				data: chartdata
			});
			

		},
		error : function(data) {
		alert("hello");
                        console.log(data);
		}
	});
	}  