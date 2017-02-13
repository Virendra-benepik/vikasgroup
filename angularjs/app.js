function Emphappinessgraph($scope,$location,$http) 
{

var clientId = $location.search().clientid;
console.log(clientId);

var queryParams = "&clientid="+clientId;

var url = "http://admin.benepik.com/employee/virendra/benepik_client/Link_Library/link_get_client_demography.php?callback=JSON_CALLBACK"+queryParams;

console.log(url);

$http.jsonp(url)
.success(function(data)
{
$scope.posts = data.posts;
console.log($scope.posts);
});

}