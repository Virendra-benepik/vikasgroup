angular.module('myapp',[]).directive('yearDrop',function(){
   	function getYears(offset, range){
        var currentYear = new Date().getFullYear();
        var years = [];
        for (var i = 0; i < range + 1; i++){
            years.push(currentYear + offset + i);
        }
        return years;
    }
    return {
        link: function(scope,element,attrs){
            scope.years = getYears(+attrs.offset, +attrs.range);
            scope.selected = scope.years[0];
        },
        template: '<select ng-model="selected" ng-options="y for y in years"></select>'
    }
});