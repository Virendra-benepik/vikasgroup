var myApp = angular.module('myApp',[]);
myApp.controller("myController",function($scope,$http,$location)
{
	$scope.message = "i m here to see you";

var clientId ="CO-16";
var groupId = $location.search().groupid;

console.log($location.search());

var queryParams = "&clientid="+clientId +"&groupid="+groupId;


var url = "http://admin.benepik.com/employee/virendra/benepik_client/Link_Library/link_get_client_demography.php?callback=JSON_CALLBACK"+queryParams;

$http.jsonp(url).success(function(data){
$scope.posts = data.posts;

});


});