
var app = angular.module('myproject', []);

 demo.controller('fessCntrl', function ($scope) {
 i=0;
});


demo.$inject = ['$scope'];

  demo.directive("boxCreator", function($compile){   
    return{
      restrict: 'A',
      link: function(scope , element){        
         element.bind("click", function(e){
            alert(i++)
             var childNode = $compile('<input type="text" name="text"'+i+' ><br>')(scope)
          element.parent().prepend(childNode);
             
         });
          
         
      }
  }
 });