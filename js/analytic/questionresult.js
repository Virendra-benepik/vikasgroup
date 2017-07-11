/*************************** login analytic graph ******************************/
function showGraphFunction1(quid, sid, clientid)
{
    //alert("hi inside function");
    var postData =
            {
                "questionid": quid,
                "clientid": clientid,
                "surveyid": sid
            }
    var dataString = JSON.stringify(postData);
    // alert(dataString);
    jQuery.ajax({
        type: "POST",
        //dataType: "json",
        //contentType: "application/json; charset=utf-8",
        url: "surveyresult.php",
        data: {"mydata": dataString},
        success: function (response) {
            var resdata = response; 
          //  alert(resdata);
             /* var jsonData = JSON.parse(resdata)["data"];
              
              alert(jsonData);
             if (jsonData.length > 0)
             {
             surveyGraph(resdata);
             }  
             else
             {
             alert("No Record Found");
             }*/
            surveyGraph(resdata);
        },
        error: function (e) {
            alert(e);
            console.log(e.message);
        }
    });
}
/*********************************************** end login analytic graph **********************************/

/********************************** draw chart function ********************************************************/
function surveyGraph(resdata) {
   // alert(resdata);
    //  console.log(resdata);
  
    var categorydata = resdata;
    console.log(categorydata);
    //console.log(JSON.parse(categorydata).length);
    FusionCharts.ready(function () {
        var visitChart = new FusionCharts({
         //  type: 'bar2d',
           type: 'doughnut2d',
        renderAt: 'chart-container',
        width: '850',
        height: '450',
        dataFormat: 'json',
        dataSource: {
            "chart": {
                "caption": "Survey Respondent",
                 "subCaption": "Percentage of respondent with respect to normal, sad ,happy and  extra happy",
                "numberPrefix": "",
                "paletteColors": "#0075c2,#1aaf5d,#f2c500,#f45b00,#8e0000",
                "bgColor": "#ffffff",
                "showBorder": "0",
                "use3DLighting": "0",
                "showShadow": "0",
                "enableSmartLabels": "0",
                "startingAngle": "310",
                "showLabels": "0",
                "showPercentValues": "1",
                "showLegend": "1",
                "legendShadow": "0",
                "legendBorderAlpha": "0",
               // "defaultCenterLabel": "Total Respondent:".JSON.parse(categorydata).length,
                "centerLabel": " $label: $value",
                "centerLabelBold": "1",
                "showTooltip": "0",
                "decimals": "0",
                "captionFontSize": "14",
                "subcaptionFontSize": "14",
                "subcaptionFontBold": "0"
             /*        "numberPrefix": "user ",
                "paletteColors": "#0075c2,#1aaf5d,#f2c500,#f45b00,#8e0000",
                "bgColor": "#ffffff",
                "showBorder": "0",
                "showCanvasBorder": "0",
                "usePlotGradientColor": "0",
                "plotBorderAlpha": "10",
                "yAxisName": "No. of users",
                "placeValuesInside": "1",
                "valueFontColor": "#ffffff",
                "showAxisLines": "1",
                "axisLineAlpha": "25",
                "divLineAlpha": "10",
                "alignCaptionWithCanvas": "0",
                "showAlternateVGridColor": "0",
                "captionFontSize": "14",
                "subcaptionFontSize": "14",
                "subcaptionFontBold": "0",
                "toolTipColor": "#ffffff",
                "toolTipBorderThickness": "0",
                "toolTipBgColor": "#000000",
                "toolTipBgAlpha": "80",
                "toolTipBorderRadius": "2",
                "toolTipPadding": "5"*/
            },  
            "data": JSON.parse(categorydata)
           
        }   
        }).render();
    });
}
/************************************** end draw chart function **************************************/