function MainCtrl1($scope, $http, $location)
{
    $scope.statusDivTable = true;
    var BASE_PATH = document.domain + window.location.pathname.substr(0, window.location.pathname.lastIndexOf('/'));
    $scope.choices = [];
    $scope.groupName = "";
    $scope.groupDescription = "";

    $scope.search = function (a,b) {
        $scope.statusDivTable = false;
        console.log(a);
  var queryParams = "&searchid=" + a;//+ "&groupid=" + groupId;
        var url = "http://" + BASE_PATH + "/reademployeeinfo.php?callback=JSON_CALLBACK" + queryParams;
        $http.jsonp(url)
                .success(function (data) {
                    //alert(JSON.stringify(data));
            $scope.tabularFormData = data;
            $scope.indexValue = b ;
                 //   $scope.groupName = data.posts.groupName;
                });

            }

$scope.getEmployeeDataFromHere = function(a,b)
{
    $scope.statusDivTable = true;
    var newValue = "vishalNewId"+b;
    var vishalNewId = document.getElementById(newValue);
 
    vishalNewId.value = a.firstName +" (" +a.employeeCode +")";
    /*******************************************/
    var newValue1 = "empid"+b;
    var empid = document.getElementById(newValue1);
 
    empid.value = a.employeeCode;
}


            var clientId = $location.search().clientid;
            console.log(clientId);
            // alert(clientId);
            var groupId = $location.search().groupid;
            // alert(groupId);
            // var groupId = "Group1";
            // var groupId = "";
            //   console.log(groupId);
            $scope.values = [];
            // console.log($location.search());

            var queryParams = "&clientid=" + clientId;//+ "&groupid=" + groupId;

//    console.log(queryParams);
//
////var url = "http://admin.benepik.com/employee/virendra/Mahle_AdminPanel/Link_Library/link_update_client.php?callback=JSON_CALLBACK"+queryParams;
//    var url = "http://"+BASE_PATH+"/Link_Library/link_update_client.php?callback=JSON_CALLBACK" + queryParams;
// 
//    $http.jsonp(url)
//            .success(function (data) {
//                $scope.groupName = data.posts.groupName;
//
//                $scope.groupDescription = data.posts.groupDescription;
//                for (var i = 0; i < data.posts.adminEmails.length; i++)
//                    $scope.choices.push(data.posts.adminEmails[i]);
//


//                $scope.isCheckedDemographic = function (columnName, value)
//                {
//                    alert(value);
//                    alert(columnName);
//                    console.log(columnName + " " + value);
//                    for (var i = 0; i < data.posts.demographics.length; i++)
//                    {
//                        if (data.posts.demographics[i].columnName == columnName)
//                        {
//                            console.log(data.posts.demographics[i].columnValue[0]);
//                            if (data.posts.demographics[i].columnValue[0] == "All")
//                                return true;
//                            else {
//                                var flag = false;
//
//                                for (var j = 0; j < data.posts.demographics[i].columnValue.length; j++)
//                                {
//                                    if (data.posts.demographics[i].columnValue[j] == value)
//                                    {
//                                        flag = true;
//                                        break;
//                                    }
//
//                                }
//                                return flag;
//                            }
//                        }
//                    }
//
//                };
            //           });

            $scope.sayhello = function (a) {
                //alert("hello");
                var sd = "id" + a;
                //alert(sd);
                document.getElementById(sd).checked = false;

            }

            $scope.addNewChoice = function () {
                var newItemNo = $scope.choices.length + 1;
                var option = {};
                option.name = "";
                $scope.choices.push(option);
            };

            $scope.removeChoice = function () {
                var lastItem = $scope.choices.length - 1;
                $scope.choices.splice(lastItem);
            };



            $scope.values = [];

//var url = "http://admin.benepik.com/employee/virendra/Mahle_AdminPanel/Link_Library/link_get_client_demography.php?callback=JSON_CALLBACK"+queryParams;
            var url = "http://" + BASE_PATH + "/Link_Library/link_get_client_demography.php?callback=JSON_CALLBACK" + queryParams;

            $http.jsonp(url)
                    .success(function (data) {

                        $scope.posts = data.posts;

                        console.log(data);
                    });

        }