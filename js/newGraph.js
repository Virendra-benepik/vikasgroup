function compareChartGraph(departmentQuestionAvg, surveyTitle) {
    Highcharts.chart('container', {
        title: {
            text: surveyTitle
        },
        subtitle: {
            text: ''
        },
        yAxis: {
            title: {
                text: 'Score Points'
            }
        },
        xAxis: {
            title: {
                text : 'Questions'
            },
            tickPositions : [1,2,3,4]
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
        plotOptions: {
            series: {
                pointStart: 1
            }
        },
        series: departmentQuestionAvg
//    series: [{
//            "name": "Overall Avg",
//            "data": surveyQuestions
//        }]
    });
}