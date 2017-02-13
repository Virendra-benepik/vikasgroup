$(document).ready(function(){
    var str = "";
    str = $("#clientid").val();
//alert(str);
	$.ajax({
		url : "http://admin.benepik.com/employee/virendra/benepik_client/analytic_data/recog_topic.php",
		 type : 'POST',
                 datatype : 'JSON',
		data : { clientid : str },
		success : function(data){
		       
			var topic = [];
			var points = [];
			var countapprove = [];
			var topicwithvalue = [];
			
 var json = $.parseJSON(data);
  for(var i=0; i<json.length;i++)
  {
  topic.push(json[i].title);
  points.push(json[i].amount);
  countapprove.push(json[i].no);
  topicwithvalue.push(json[i].topicvalue);
  }

console.log(points);
console.log(topic);
console.log(countapprove);

			var chartdata = {
				labels: topicwithvalue,
				datasets: [
					{
						label: "topic",
					        					
						hoverBackgroundColor: 'rgba(211, 72, 54, 0.75)',
						hoverBorderColor: 'rgba(200, 200, 200, 1)',
						
						
						 backgroundColor: [
            "#FF6384",
            "#4BC0C0",
            "#FFCE56",
            "#E7E9ED",
            "#36A2EB"
        ],
						borderColor: "rgba(59, 89, 152, 1)",
						data: points,
						
					
					}
					
				     
				]
			};

			var ctx = $("#mycanvas");
                              var barGraph = new Chart(ctx, {
				type: 'bar',
				data: chartdata
			});
			

		},
		error : function(data) {
		alert("hello");
                        console.log(data);
		}
	});  
});