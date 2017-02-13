function MainCtrl($scope, $http) 
{
  $scope.choices = [];
  
  $scope.addNewChoice = function() {
    var newItemNo = $scope.choices.length+1;
    $scope.choices.push(newItemNo);
  };
    
  $scope.removeChoice = function() {
    var lastItem = $scope.choices.length-1;
    $scope.choices.splice(lastItem);
  };
  $scope.jsonp_example = function(){
};
  
}

function jsonp_example($scope, $http) {
 $scope.values = [];
 
      var url = "http://admin.benepik.com/employee/virendra/benepik_client/Link_Library/link_get_client_demography.php?callback=JSON_CALLBACK&clientid=co-9";
     
      $http.jsonp(url)
          .success(function(data){
             
              $scope.posts = data.posts;
             console.log(data);
         
          });
}