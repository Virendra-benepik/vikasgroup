<!DOCTYPE html>
<html ng-app="app">
<head>
<title> this is angular chart </title>
<link rel="stylesheet" href="jsfile/angular-chart.css">
<link rel="stylesheet" href="jsfile/angular-chart.min.css">
<script src="jsfile/jquery.min.js"></script>
<script src="jsfile/angular-chart.js"></script>
  <script src="jsfile/angular-chart.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.6/Chart.js"></script>
  <script src="jsfile/app.js"></script>
</head>
<body>
<div ng-controller= "LineCtrl">
<canvas id="line" class="chart chart-line" chart-data="data"
chart-labels="labels" chart-series="series" chart-options="options"
chart-dataset-override="datasetOverride" chart-click="onClick"
</canvas> 
</div>
</body>
</html>