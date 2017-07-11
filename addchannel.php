<?php include 'navigationbar.php'; ?>
<?php include 'leftSideSlide.php'; ?>

<!-------------------------------SCRIPT START FROM HERE   --------->	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="angularjs/updateGroup.js"></script>

<script>
            function check() {
            if (confirm('Are You Sure, You want to create this group?')) {
            return true;
            } else {
            return false;
            }
            }
</script>
<!-------------------------------SCRIPT END FROM HERE   --------->	
<div ng-controller="MainCtrl1">

    <div  class="side-body padding-top">
        <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;">
            <div class="bs-example">

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <h3>Create Group</h3><hr>
                    </div>
                </div>

                <!------------------------------------------message portal start from here------------------------------------------------>	
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                        <!----------------------------------------message  start from here---------------------------------------->	
                        <div class="row">
                            <form role="form" method="post" action="Link_Library/link_group.php" onsubmit="return check()">

                                <input type="hidden" ng-model="groupid" ng-init="groupid = '<?php echo $_GET['groupid']; ?>'" name = "idgroup" value="<?php echo $_GET['groupid']; ?>">
                                <input type="hidden" name = "channel_author" value="<?php echo $_SESSION['user_unique_id']; ?>">
                                <input type="hidden"  name = "id_author" value="<?php echo $_SESSION['client_id']; ?>">
                                <input type="hidden"  name = "id_author" ng-model="clientid" ng-init="clientid = '<?php echo $_SESSION['client_id']; ?>'" value="<?php echo $_SESSION['client_id']; ?>">
                                <input type="hidden" name = "device" value="d2">	



                                <div class="form-group col-sm-6">
                                    <label for="exampleInputPassword1">Group Name<span style="color:red;">*</span></label>
                                    <input ng-model = "groupName" type="text" name="group_title" class="form-control" id="exampleInputPassword1" placeholder="Group Name" required>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="exampleInputEmail1">About Group<span style="color:red;">*</span></label>
                                    <textarea ng-model = "groupDescription" cols="10" id="message" name="groupdesc" class="form-control"  rows="1" required>	
                                    </textarea>
                                </div>

                                <div class="form-group col-sm-12">
                                    <label for="exampleInputEmail1">Select Demography Parameter</label>
                                    <br/>

                                    <div >

                                        <div ng-repeat = "singleColumnValues in posts">
                                            <div class="col-md-3">
                                                <div style="border:1px solid #dcdcdc;padding:8px;">
                                                    <p style="font-size:12px;font-weigtht:bold;text-transform:capitalize;"><b>{{singleColumnValues.columnName}}</b></p>
                                                    <hr />
                                                    <div style="max-height:200px; overflow-y: auto;">
                                                        <input type="text" style="display:none;" name="countvalue" ng-model= posts.length />

                                                        <input type="checkbox" ng-model="all" name="group{{$index}}[]" value="{{singleColumnValues.columnName}}|All" id="id{{$index}}">  All<br>
                                                        <div ng-repeat = "distinctValuesWithinColumn in singleColumnValues.distinctValuesWithinColumn">

                                                            <input type="checkbox" ng-checked="all" name="group{{$parent.$index}}[]" class="form-group" value="{{singleColumnValues.columnName}}| {{distinctValuesWithinColumn}}" ng-click="sayhello({{$parent.$index}});">  {{distinctValuesWithinColumn}}

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!---------------------this script for show text box on select radio button---------------------->                        
                                <div class="col-md-12">
                                    <label for="exampleInputPassword1"></label>

                                    <div>
                                        <input type="text" style="display:none;"  name="countadmin" ng-model = choices.length />
                                        {{employeeName}}                                      <div data-ng-repeat="choice in choices">
                                            <div class="form-group col-sm-11">  
                                                <input type="text" required class="form-control" name="admin{{$index}}" ng-model = "employeeName" id="vishalNewId{{$index}}" placeholder="Enter First Name / Employee ID / Email ID" ng-keyup="search(employeeName, $index)">
                                                <input type="hidden" ng-model = "employeeid" id="empid{{$index}}" name="adminid{{$index}}">
                                            </div>
                                            <div class="form-group col-sm-1">
                                                <button type="button" class="btn btn-danger btn-small" ng-show="$last" ng-click="removeChoice()"> - </button>
                                                {{$length}}
                                            </div>

                                        </div>


                                        <div class="dataHere" ng-hide="statusDivTable">
                                            <table cellpadding="10">
                                                <tr><th>First Name</th><th>Last Name</th><th>Employee Id</th><th>Designation</th><th>Company</th><th>Email Id</th></tr>
                                                <tr ng-repeat="dataHere in tabularFormData" ng-click="getEmployeeDataFromHere(dataHere, indexValue)"><td>{{dataHere.firstName}}</td><td>{{dataHere.lastName}}</td><td>{{dataHere.employeeCode}}</td><td>{{dataHere.designation}}</td><td>{{dataHere.companyName}}</td><td>{{dataHere.emailId}}</td></tr>
                                            </table>
                                        </div>  

                                        <button type="button" class="btn btn-success btn-xs" ng-click="addNewChoice()">Assign Group Admin</button>

                                    </div>
                                </div>
                                <!------------Adobe script for show text box on select radio button---------------------->

                                <div class="form-group col-sm-12">
                                    <center><input type="submit" name ="news_post" class="btn btn-md btn-info" style="text-shadow:none;font-weight:normal;" value="Create Group" id="getData" /></center>
                                </div>


                            </form>





                        </div>

                    </div>
                    <!-----------------------------------message form end from here---------------------------------->				
                </div>

            </div>


        </div>

    </div> 
</div>
<?php include 'footer.php'; ?>