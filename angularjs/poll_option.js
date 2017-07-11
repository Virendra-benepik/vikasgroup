  // myproject defined in navigationbar page at html tag
       function ctrl($scope) {
            $scope.totalNumberOfOptions = 0;
            $scope.allOptions = [];
            

            $scope.makeArray = function () {
                $scope.allOptions.length = 0;
                if(parseInt($scope.totalNumberOfOptions) > 4)
                    alert("Maximum 4 Questions can be sent");
                else{
                    //console.log(parseInt($scope.cols));
                    for (var i = 0; i < parseInt($scope.totalNumberOfOptions) ; i++) {
                           
                            $scope.allOptions.push(i);
                    }
                }
            }   
        }





