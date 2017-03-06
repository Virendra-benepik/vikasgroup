function MainCtrl($scope, $http,$location) {

$scope.choices = [];
$scope.groupName = "";
$scope.groupDescription = "";

var clientId = $location.search().clientid;
console.log(clientId);
var groupId = $location.search().groupid;
$scope.values = [];
console.log($location.search());

var queryParams = "&clientid="+clientId +"&groupid="+groupId;

console.log(queryParams);
//var url = "http://admin.benepik.com/employee/virendra/Mahle_AdminPanel/Link_Library/link_update_client.php?callback=JSON_CALLBACK"+queryParams;
var url = "http://52.66.130.250/Benepik_testing/vikasgroup/Link_Library/link_update_client.php?callback=JSON_CALLBACK"+queryParams;

$http.jsonp(url)
.success(function(data){
$scope.groupName = data.posts.groupName;

$scope.groupDescription= data.posts.groupDescription;
for(var i=0;i<data.posts.adminEmails.length;i++)

$scope.choices.push(data.posts.adminEmails[i]);



$scope.isCheckedDemographic= function(columnName,value) {

console.log(columnName + " " +value);
for(var i=0;i<data.posts.demographics.length;i++)      
{  
if(data.posts.demographics[i].columnName == columnName)
{
console.log(data.posts.demographics[i].columnValue[0]);
if(data.posts.demographics[i].columnValue[0] == "All")
return true;
else{
var flag = false;

for(var j=0;j<data.posts.demographics[i].columnValue.length;j++)
{
    if(data.posts.demographics[i].columnValue[j] == value)
    {    flag = true;
         break;
    }
              
}
return flag;
}
}  
}

};
});


$scope.addNewChoice = function() {
var newItemNo = $scope.choices.length+1;
var option = {};
option.name = "";
$scope.choices.push(option);
};

$scope.removeChoice = function() {
var lastItem = $scope.choices.length-1;
$scope.choices.splice(lastItem);
};



$scope.values = [];

//var url = "http://admin.benepik.com/employee/virendra/Mahle_AdminPanel/Link_Library/link_get_client_demography.php?callback=JSON_CALLBACK"+queryParams;
var url = "http://52.66.130.250/Benepik_testing/vikasgroup/Link_Library/link_get_client_demography.php?callback=JSON_CALLBACK"+queryParams;

$http.jsonp(url)
.success(function(data){

$scope.posts = data.posts;


});

}