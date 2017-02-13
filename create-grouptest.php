
<!DOCTYPE html>
<html data-ng-app="demo">
 <head>
   <script data-require="angular.js@1.1.5" data-semver="1.1.5" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.1.5/angular.js"></script>
   <link rel="stylesheet" href="style.css" />
   <script src="script.js"></script>
   <script>
   function jsonp_example($scope, $http) {
  $scope.values = [];
   
       var url = "http://admin.benepik.com/employee/Sparsh/hehe.php?callback=JSON_CALLBACK";
      
       $http.jsonp(url)
           .success(function(data){
               
               var posts = data.posts;
              for(i=0;i<posts.length;i++)
                  {
                      if(i+20<posts.length)
                          i=i+20;
                      console.log(posts[i].branch_id);
                     $scope.values.push(posts[i].branch_id);
                  
              }
           
           });
}
   </script>
 </head>
 <body>
     
     
     
     <div ng-app ng-controller="jsonp_example">
         
        <br> <input type="checkbox" ng-model="all" name="group" value="group">  All<br>
     <li ng-repeat="x in values">
         {{$index}}
         <input type="checkbox" ng-checked="all" name="group" value="group">  {{ x }}
   </li>
     
    </div>
     
  
   <!-- <input data-ng-model="newItem"><button data-ng-click="addItem(newItem)">Add</button> -->
  
 </body>
</html>