var chart;
var chartData = [];
var chartCursor;
location1 = "";
department1 = "";
age1 = ""; 
month = "";
year = "";

$(document).ready(function(){
  
  var date = new Date();
  
  month = date.getMonth()+1;
  year = date.getFullYear();
  
  $("#selectmonth").change(function(){
     var date = new Date();
    //getAverageData(date.getMonth()+1,date.getFullYear());
     console.log(document.getElementById("selectmonth").value + " " + 2016);
     
     chartData = [];
     console.log();
     
     month = document.getElementById("selectmonth").value;
    year = document.getElementById("myAwesomeYear").value;
    
  getAverageData(month,year,location1,department1,age1);
    
  });
  
  	$('#location_selector').change(function()
	{
		/* setting currently changed option value to option variable */
		 location1 = $(this).find('option:selected').val();
	console.log(location1);	
	
  chartData = [];	
  getAverageData(month,year,location1,department1,age1);
		
	});
  
  $('#department_selector').change(function()
	{
		/* setting currently changed option value to option variable */
		 department1 = $(this).find('option:selected').val();	

chartData = [];		
  getAverageData(month,year,location1,department1,age1);
	});
	
	 $('#age_selector').change(function()
	{
		/* setting currently changed option value to option variable */
		 age1 = $(this).find('option:selected').val();
		
		
 chartData = [];
  getAverageData(month,year,location1,department1,age1);
		
	});
	
  getAverageData(date.getMonth()+1,date.getFullYear(),location1,department1,age1);
  
});

function getAverageData(sMonth,sYear,location,department,age)
{
   console.log(location +" "+department+" "+ age);
    console.log(sMonth+" "+sYear);
    $.ajax({
      type:"post",
      data: {
        month: sMonth,
        year:  sYear,
        location:location,
        department:department,
        age:age
      },
      url:"happiness_score.php",
      success:function(data){
       console.log(data);
        generateChartData(data);
        
        // SERIAL CHART
        chart = new AmCharts.AmSerialChart();
        
        chart.dataProvider = chartData;
        chart.categoryField = "date";
        var balloon = chart.balloon;
        // set properties
        balloon.adjustBorderColor = true;
        balloon.color = "#000000";
        balloon.fillColor = "#FFFFFF";
        balloon.fixedPosition = true;
        
        
        // listen for "dataUpdated" event (fired when chart is rendered) and call zoomChart method when it happens
        chart.addListener("dataUpdated", zoomChart);
        
        // AXES
        // category
        var categoryAxis = chart.categoryAxis;
        categoryAxis.parseDates = true; // as our data is date-based, we set parseDates to true
        categoryAxis.minPeriod = "DD"; // our data is daily, so we set minPeriod to DD
        categoryAxis.dashLength = 1;
        categoryAxis.minorGridEnabled = true;
        categoryAxis.twoLineMode = true;
        
        
        categoryAxis.dateFormats = [{
          period: 'fff',
          format: 'JJ:NN:SS'
        }, {
          period: 'ss',
          format: 'JJ:NN:SS'
        }, {
          period: 'mm',
          format: 'JJ:NN'
        }, {
          period: 'hh',
          format: 'JJ:NN'
        }, {
          period: 'DD',
          format: 'DD'
        }, {
          period: 'WW',
          format: 'DD'
        }, {
          period: 'MM',
          format: 'MMM'
        }, {
          period: 'YYYY',
          format: 'YYYY'
        }];
        
        categoryAxis.axisColor = "#DADADA";
        
        // value
        var valueAxis = new AmCharts.ValueAxis();
        valueAxis.axisAlpha = 0;
        valueAxis.dashLength = 1;
        chart.addValueAxis(valueAxis);
        
        // GRAPH
        var graph = new AmCharts.AmGraph();
        graph.title = "red line";
        graph.valueField = "visits";
        graph.bullet = "round";
        graph.bulletBorderColor = "#FFFFFF";
        graph.bulletBorderThickness = 2;
        graph.bulletBorderAlpha = 1;
        graph.balloonFunction = adjustBalloonText;
        graph.lineThickness = 2;
        graph.lineColor = "#5fb503";
        graph.negativeLineColor = "#ff0000";
        graph.hideBulletsCount = 50; // this makes the chart to hide bullets when there are more than 50 series in selection
        chart.addGraph(graph);
        
        // CURSOR
        chartCursor = new AmCharts.ChartCursor();
        chartCursor.cursorPosition = "mouse";
        chartCursor.pan = false; // set it to fals if you want the cursor to work in "select" mode
        chart.addChartCursor(chartCursor);
        
        // SCROLLBAR
        
        chart.creditsPosition = "bottom-left";
        
        // WRITE
        chart.write("chartdiv");
        
        
      }
      
    });

  }
  
  
  
  function adjustBalloonText(graphDataItem, graph){
    // console.log(graphDataItem);
    var item =  parseFloat(Math.round(graphDataItem.dataContext.visits * 100) / 100).toFixed(1);

     console.log(graphDataItem.dataContext.visits + " " + item + " Respondents " + graphDataItem.dataContext.totalCount);
    return item + " Respondents " + graphDataItem.dataContext.totalCount;
  }
  
  
  
  // generate some random data, quite different range
  
  function generateChartData(data) {
    
    var obj = JSON.parse(data);
     
   
  console.log(obj.maverage);
 var myAverage = parseFloat(Math.round(obj.maverage * 100) / 100).toFixed(1);
    $("#avgValue").html(myAverage);
    
   var postAvailable = 0;
    
    for(var i=0;i<obj.value.length;i++)
    {
     postAvailable = 1;
      
      var newDate = new Date(obj.value[i].date);
      newDate.setDate(newDate.getDate());
      chartData.push({
        
        totalCount : obj.value[i].TOTALfeedback,
        date: newDate,
        visits: obj.value[i].avg
      });
    }
    
   if(postAvailable == 0)
  {$("#info").html(obj.message)
   $("#avgValue").html("");
   }
   else
   {$("#info").html("");
       
   }
    
   
    
  }
  
  /* function generateChartData() {
    var firstDate = new Date(obj.value[i].date);
    firstDate.setDate(firstDate.getDate() - 30);
    
    for (var i = 0; i < 30; i++) {
      // we create date objects here. In your data, you can have date strings
      // and then set format of your dates using chart.dataDateFormat property,
      // however when possible, use date objects, as this will speed up chart rendering.
      var newDate = new Date(firstDate);
      newDate.setDate(newDate.getDate() + i);
      
      var visits = obj.value[i].avg;
      
      chartData.push({
        date: newDate,
        totalCount : obj.value[i].TOTALfeedback,
        visits: visits
      });
    }
  }
  */
  
  // this method is called when chart is first inited as we listen for "dataUpdated" event
  function zoomChart() {
    // different zoom methods can be used - zoomToIndexes, zoomToDates, zoomToCategoryValues
    chart.zoomToIndexes(chartData.length - 40, chartData.length - 1);
  }
  
  // changes cursor mode from pan to select
  function setPanSelect() {
    if (document.getElementById("rb1").checked) {
      chartCursor.pan = false;
      chartCursor.zoomable = true;
    } else {
      chartCursor.pan = true;
    }
    chart.validateNow();
  }
