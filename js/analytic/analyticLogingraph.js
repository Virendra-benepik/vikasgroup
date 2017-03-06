/*************************** login analytic graph ******************************/
		function showGraphFunction()
		{
	    //alert("hi inside function");
			
        var searchby = $("#device").val(); //"Android";
        var fromdte = $("#formdate").val();//"2016-12-01";
        var enddte = $("#enddate").val();//"2016-12-30"; 
        var clientid = $("#clientid").val();
        //alert("hello1");
        var postData =
                {
                    "start_date": fromdte,
                    "end_date": enddte,
                    "searchby": searchby,
                    "client": clientid
                }
        var dataString = JSON.stringify(postData);
        //alert(dataString);
        jQuery.ajax({
            type: "POST",
            //dataType: "json",
            //contentType: "application/json; charset=utf-8",
            url: "linkloginanalyticgraph.php",
            data: {"mydata": dataString},
            success: function (response) {
                var resdata = response;
				//alert(resdata);
				var jsonData = JSON.parse(resdata);
				if(jsonData.length > 0)
				{
				drawChart(resdata);
				}
				else
				{
					alert("No Record Found");
				}
					
            },
            error: function (e) {
                alert(e);
                console.log(e.message);
            }
        });
		}
/*********************************************** end login analytic graph **********************************/
		
/********************************** draw chart function ********************************************************/
function drawChart(resdata) {
    FusionCharts.ready(function () {
      // alert("hi graph side");
	//	alert(resdata);
        var jsondata = resdata;
//        prompt('data : ', jsondata);
        var revenueChart = new FusionCharts({
            type: 'doughnut2d',
//            type: 'bar3d',
            renderAt: 'chart-container',
            width: '400',
            height: '400',
            dataFormat: 'json',
            dataSource: {
                "chart": {
                    "caption": "Login Analytic Graph Report",
                    "subCaption": "",
                    "numberPrefix": "",
                    "paletteColors": "#0075c2,#1aaf5d,#f2c500,#f45b00,#8e0000",
                    "bgColor": "#ffffff",
                    "showBorder": "1",
                    "use3DLighting": "1",
                    "showShadow": "2",
                    "enableSmartLabels": "1",
                    "startingAngle": "310",
                    "showLabels": "0",
                    "showPercentValues": "1",
                    "showLegend": "1",
                    "legendShadow": "1",
                    "legendBorderAlpha": "1",
//                    "defaultCenterLabel": "Total Count: $64.08K",
                    "centerLabel": "Count for $label: $value",
                    "centerLabelBold": "5",
                    "showTooltip": "1",
                    "decimals": "1",
                    "captionFontSize": "14",
                    "subcaptionFontSize": "14",
                    "subcaptionFontBold": "0"
                },
                "data": JSON.parse(jsondata)
                        
					   /* [
                            {
                                "label": "Food",
                                "value": "28504"
                            },
                            {
                                "label": "Apparels",
                                "value": "14633"
                            },
                            {
                                "label": "Electronics",
                                "value": "10507"
                            },
                            {
                                "label": "Household",
                                "value": "4910"
                            }
                        ]*/
						
            }
        }).render();
    });
}//]]> 
/************************************** end draw chart function **************************************/

/************************************ json converter ********************************************/

function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
	//alert("JSONToCSVConvertor");
    //If JSONData is not an object then JSON.parse will parse the JSON string in an Object
    var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;
    var CSV = '';    
    //Set Report title in first row or line
    
    CSV += ReportTitle + '\r\n\n';

    //This condition will generate the Label/Header
    if (ShowLabel) {
        var row = "";
        
        //This loop will extract the label from 1st index of on array
        for (var index in arrData[0]) {
            
            //Now convert each value to string and comma-seprated
            row += index + ',';
        }

        row = row.slice(0, -1);
        
        //append Label row with line break
        CSV += row + '\r\n';
    }
    
    //1st loop is to extract each row
    for (var i = 0; i < arrData.length; i++) {
        var row = "";
        
        //2nd loop will extract each column and convert it in string comma-seprated
        for (var index in arrData[i]) {
            row += '"' + arrData[i][index] + '",';
        }

        row.slice(0, row.length - 1);
        
        //add a line break after each row
        CSV += row + '\r\n';
    }

    if (CSV == '') {        
        alert("Invalid data");
        return;
    }   
    
    //Generate a file name
    var fileName = "Report_";
    //this will remove the blank-spaces from the title and replace it with an underscore
    fileName += ReportTitle.replace(/ /g,"_");   
    
    //Initialize file format you want csv or xls
    var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);
    
    // Now the little tricky part.
    // you can use either>> window.open(uri);
    // but this will not work in some browsers
    // or you will not get the correct file extension    
    
    //this trick will generate a temp <a /> tag
    var link = document.createElement("a");    
    link.href = uri;
    
    //set the visibility hidden so it will not effect on your web-layout
    link.style = "visibility:hidden";
    link.download = fileName + ".CSV";
    
    //this part will append the anchor tag and remove it after automatic click
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

/*********************************** end json converter ***************************************/