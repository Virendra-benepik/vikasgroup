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

			var data = {
    labels: topicwithvalue,
    datasets: [
        {
            label: "Counter Approve Topic",
            backgroundColor: "rgba(179,181,198,0.2)",
            borderColor: "rgba(179,181,198,1)",
            pointBackgroundColor: "rgba(179,181,198,1)",
            pointBorderColor: "#fff",
            pointHoverBackgroundColor: "#fff",
            pointHoverBorderColor: "rgba(179,181,198,1)",
            data: countapprove
        }
        
    ]
};
			var ctx = $("#mycanvas1");
                             new Chart(ctx, {
    type: "radar",
    data: data,
    options: {
            scale: {
                reverse: true,
                ticks: {
                    beginAtZero: true
                }
            }
    }
});
	
		},
		error : function(data) {
		alert("hello");
                        console.log(data);
		}
	});  
});