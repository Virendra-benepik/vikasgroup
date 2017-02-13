<html>
<head>
<title>Angular Test</title>
<script data-require="angular.js@1.1.5" data-semver="1.1.5" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.1.5/angular.js"></script>
<script src="angularjs/deepakangulartest.js"></script>
</head>
<body ng-app="">
<div ng-controller="MainCtrl">
<h1>{{text}}</h1><br>
<ul>
<li ng-repeat="contact in contacts">{{contact}}</li>
</ul>
</div>
</body>
</html>