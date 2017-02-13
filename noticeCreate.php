<script src="angularjs/angular.min.js"></script>
<script src="angularjs/updateGroup1.js"></script>
<div ng-app="myApp">
<div ng-controller="myController">
{{message}}
<div ng-repeat="post in posts">
<p>
{{post.columnName}}
</p>
</div>

</div>
</div>