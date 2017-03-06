<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- <script src="js/get_department.js" type="text/javascript"></script> -->


<?php
include 'navigationbar.php';

session_start();
$client_id = $_SESSION['client_id'];
?>
<?php include 'leftSideSlide.php'; ?>
<script>
    $(document).ready(function () {

        $("#add_location").click(function () {

            var idclient = "<?php echo $client_id; ?>";
            var nameloc = $("#contact_location").val();
            if (nameloc == '')
            {
                alert("please write location name");
                $("#contact_location").focus();
                return false;
            }
            $.ajax({
                type: 'POST',
                url: "<?php echo SITE; ?>Link_Library/link_create_location.php",
                data: {
                    clientid: idclient,
                    contact_location: nameloc
                },
                success: function (data) {
                    alert("Add location successfully");
                    viewAllLocations();
                    $("#contact_location").val('');
                }
            });

        });

        $("#location").change(function () {

            var myvalue = $("#location").val();
            var idclient = "<?php echo $client_id ?>";

            $.ajax({
                type: 'POST',
                url: "<?php echo SITE; ?>Link_Library/link_view_departments.php",
                data: {
                    clientid: idclient,
                    locationName: myvalue
                },
                success: function (data) {
                    $("#departmentid").html(data);
                }
            });

        });

        $("body").delegate('.delete_location', 'click', function () {
            var locationDelete = $(this).attr("location_delete");

            $.ajax({
                type: 'POST',
                url: "<?php echo SITE; ?>Link_Library/link_delete_location.php",
                data: {
                    locationid: locationDelete,
                },
                success: function (data) {
                    alert('You successfully delete location');
                    viewAllLocations();
                }
            });

        });

        $("body").delegate('.delete_department', 'click', function () {
            var cid = "<?php echo $client_id; ?>";
            var loc = $(this).attr("department_delete_loc");
            var departmentDelete = $(this).attr("department_delete");

            $.ajax({
                type: 'POST',
                url: "<?php echo SITE; ?>Link_Library/link_delete_department.php",
                data: {
                    departmentid: departmentDelete,
                },
                success: function (data) {
                    alert('You delete department successfully');
                    viewDepartmentsAll(cid, loc);
                }
            });

        });

        $("body").delegate('.edit_location', 'click', function () {

            $("#EditLocation").css({"display": "block"});

            var locationEdit = $(this).attr("location_edit");
            var locationName = $(this).attr("location_name");
            var locationClientid = "<?php echo $client_id; ?>";

            document.getElementById("idlocation").value = locationEdit;
            document.getElementById("idclient").value = locationClientid;
            document.getElementById("locname").value = locationName;

        });

        $("body").delegate('.edit_department', 'click', function () {

            $("#EditDepartment").css({"display": "block"});

            var departmentEdit = $(this).attr("department_edit");
            var departmentName = $(this).attr("department_name");
            var departmentlocid = $(this).attr("department_edit_loc");

            document.getElementById("iddepartment").value = departmentEdit;
            document.getElementById("departname").value = departmentName;
            document.getElementById("departlocationid").value = departmentlocid;

        });

        $("#updatelocation").click(function () {

            var clientids = $("#idclient").val();
            var nameloc = $("#locname").val();
            var idloc = $("#idlocation").val();

            if (nameloc == "")
            {
                alert("Please Enter Location Name");
                $("#locname").focus();
                return false;

            }

            $.ajax({
                type: 'POST',
                url: "<?php echo SITE; ?>Link_Library/link_update_location.php",
                data: {
                    clientid: clientids,
                    locationid: idloc,
                    locationname: nameloc,
                },
                success: function (data) {
                    alert('Edit location successfully');
                    $("#EditLocation").css({"display": "none"});
                    viewAllLocations();
                }
            });

        });

        $("#updatedepart").click(function () {

            var clientids = "<?php echo $client_id; ?>";
            var deptid = $("#iddepartment").val();
            var deptname = $("#departname").val();
            var deptlocid = $("#departlocationid").val();

            if (deptname == "")
            {
                alert("Please Enter Department Name");
                $("#departname").focus();
                return false;
            }

            $.ajax({
                type: 'POST',
                url: "<?php echo SITE; ?>Link_Library/link_update_department.php",
                data: {
                    clientid: clientids,
                    locationid: deptlocid,
                    departmentid: deptid,
                    departmentname: deptname,
                },
                success: function (data) {
                    alert('Edit Department successfully');
                    $("#EditDepartment").css({"display": "none"});
                    viewDepartmentsAll(clientids, deptlocid);
                    viewAllLocations();
                }
            });

        });

        $("#locationDepart").change(function () {
            var departlocid = $("#locationDepart").val();
            var idcli = "<?php echo $client_id; ?>";

            $.ajax({
                type: 'POST',
                url: "<?php echo SITE; ?>Link_Library/link_view_departments.php",
                data: {
                    clientid: idcli,
                    locationid: departlocid,
                },
                success: function (data) {
                    viewAllDepartments(data);
                }
            });
        });

        $("#locationDepart2").change(function () {
            var departlocid = $("#locationDepart2").val();
            var idcli = "<?php echo $client_id; ?>";

            $.ajax({
                type: 'POST',
                url: "<?php echo SITE; ?>Link_Library/link_view_departments.php",
                data: {
                    clientid: idcli,
                    locationid: departlocid,
                },
                success: function (data) {
                    viewAllDepartments(data);
                }
            });
        });

        $("#addDepartment").click(function () {

            var loc = $("#locationDepart").val();
            var depart = $("#department").val();
            var idclient = "<?php echo $client_id; ?>";

            if (depart == '')
            {
                alert("please write Department");
                $("#department").focus();
                return false;
            }


            $.ajax({
                type: 'POST',
                url: "<?php echo SITE; ?>Link_Library/link_create_department.php",
                data: {
                    cid: idclient,
                    location: loc,
                    department: depart,
                },
                success: function (data) {
                    alert("Add department successfully");
                    viewDepartmentsAll(idclient, loc)
                    $("#department").val('');
                }
            });

        });
    });

    function viewDepartmentsAll(cid, loc)
    {

        $.ajax({
            type: 'POST',
            url: "<?php echo SITE; ?>Link_Library/link_view_departments.php",
            data: {
                clientid: cid,
                locationid: loc,
            },
            success: function (data) {
                viewAllDepartments(data);
            }
        });
    }

    function viewAllDepartments(data)
    {

        var jsonData = JSON.parse(data);

        $("#departments2").empty();
        $('#nameDepartments').empty();

        if (jsonData.success == 1)
        {
            $('#nameDepartments').empty();
            for (i = 0; i < jsonData.posts.length; i++)
            {
                var locname = jsonData.posts[i].departmentName;
                var locid = jsonData.posts[i].deptId;
                var idloc = jsonData.posts[i].locationId;

                $('#nameDepartments').append($('<div><div class="row"><div class="col-xs-4 col-sm-6 col-md-6 col-lg-6" style="margin-bottom:10px;"><p style="margin-top:7px;">' + locname + "</p></div><div class='col-xs-4 col-sm-3 col-md-3 col-lg-3'style='margin-bottom:10px;'><span class='delete_department' department_delete='" + locid + "' department_delete_loc='" + idloc + "'><button type='button'class='btn btn-danger btn-xs closeBtn'> Delete</button></span>" + "</div><div class='col-xs-4 col-sm-3 col-md-3 col-lg-3'style='margin-bottom:10px;'><span class='edit_department' department_edit='" + locid + "'  department_name='" + locname + "' department_edit_loc='" + idloc + "'><button type='button'class='btn btn-info btn-xs editbtn'> Edit</button></span>" + '</div></div></div>'));

                $("#departments2").append($("<option></option>").attr("value", locid).text(locname));
            }
        }
        else
        {
            $('#nameDepartments').text("No departments add here");
        }

    }

    function viewAllLocations()
    {
        var idclient = "<?php echo $client_id; ?>";

        $.ajax({
            type: 'POST',
            url: "<?php echo SITE; ?>Link_Library/link_view_location.php",
            data: {
                clientid: idclient,
            },
            success: function (data)
            {
                afterActionLocations(data);
            }
        });
    }

    function afterActionLocations(data)
    {

        var jsonData = JSON.parse(data);

        $('#displaylocations').empty();
        $("#locationDepart").empty();
        $("#locationDepart2").empty();

        for (i = 0; i < jsonData.posts.length; i++)
        {
            var locname = jsonData.posts[i].locationName;
            var locid = jsonData.posts[i].locationId;
            $('#displaylocations').append($('<div>' + '<div class="row"><div class="col-xs-6 col-sm-8 col-md-8 col-lg-8"style="margin-bottom:10px;"><p style="margin-top:7px">' + locname + "</p></div><div class='col-xs-3 col-sm-2 col-md-2 col-lg-2'style='margin-bottom:10px;'><span class='delete_location' location_delete='" + locid + "'><button type='button'class='btn closeBtn btn-xs'> Delete</button></span>" + "</div><div class='col-xs-3 col-sm-2 col-md-2 col-lg-2' style='margin-bottom:10px;'><span class='edit_location' location_edit='" + locid + "' location_name='" + locname + "'><button type='button'class='btn editbtn btn-xs'> Edit</button></span>" + '</div></div></div>'));

            $("#locationDepart").append($("<option></option>").attr("value", locid).text(locname));
            $("#locationDepart2").append($("<option></option>").attr("value", locid).text(locname));

        }

    }
    viewAllLocations();

</script>
<div class="container-fluid">
    <div class="side-body padding-top">
        <?php
        if (isset($_SESSION['msg'])) {

            echo "<div class='alert alert-success' role='alert'>" . " <strong>Well !</strong>" . $_SESSION['msg']
            . "</div>";
        }
        ?>                               
    </div>

    <?php
    /* $cid = $_SESSION['client_id'];
      echo $cid;
      $string = "clientid=$cid";

      $sub_req_url ="http://admin.benepik.com/employee/virendra/benepik_admin/lib/link_view_locations.php";
      $ch = curl_init($sub_req_url);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
      curl_setopt($ch, CURLOPT_POSTFIELDS,  "$string");
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_POST, 1);

      $resp = curl_exec($ch);
      curl_close($ch);
      $val = json_decode($resp,true);
      $value = $val['posts'];
      $count = count($value); */
    ?>
    <script>
        $(document).ready(function () {
            $("#CloseLocationButton123").click(function () {
                $("#EditLocation").hide();
            });
            $("#CloseDepartmentButton123").click(function () {
                $("#EditDepartment").hide();
            });

        });


        function conperson()
        {
            var empcode = document.contactperson.empid;
            var location = document.contactperson.locationDepart2;
            var department = document.contactperson.departments2;
            var designation = document.contactperson.designation;
            var empname = document.contactperson.empname;
            var contact_personal = document.contactperson.contact_personal;
            var contact_office = document.contactperson.contact_office;
            //var emailId = document.contactperson.emailId;
            var x = document.contactperson.emailId.value;
            var atpos = x.indexOf("@");
            var dotpos = x.lastIndexOf(".");

            if (empcode.value == "")
            {
                alert("Please Enter Employee Code");
                empcode.focus();
                return false;
            }
            if (location.value == 0)
            {
                alert("Please Select Location");
                location.focus();
                return false;
            }
            if (department.value == 0)
            {
                alert("Please Select Department");
                department.focus();
                return false;
            }
            if (designation.value == "")
            {
                alert("Please Enter Designation");
                designation.focus();
                return false;
            }
            if (empname.value == "")
            {
                alert("Please Enter Name");
                empname.focus();
                return false;
            }
            if (contact_personal.value == "")
            {
                alert("Please Enter Personal Contact Number");
                contact_personal.focus();
                return false;
            }
            if (isNaN(contact_personal.value))
            {
                alert("Please Enter valid Personal Number");
                contact_personal.focus();
                return false;
            }
            if ((contact_personal.value.length < 10) || (contact_personal.value.length > 15))
            {
                alert("Please Enter valid Personal Number");
                contact_personal.focus();
                return false;
            }

            if (contact_office.value == "")
            {
                alert("Please Enter Office Contact Number");
                contact_office.focus();
                return false;
            }
            if (isNaN(contact_office.value))
            {
                alert("Please Enter valid Office Number");
                contact_office.focus();
                return false;
            }
            if ((contact_office.value.length < 10) || (contact_office.value.length > 15))
            {
                alert("Please Enter valid Office Number");
                contact_office.focus();
                return false;
            }

            if (x == "")
            {
                alert("Please Enter EmailID");
                document.contactperson.emailId.focus();
                return false;
            }
            /*	if (emailId.value.indexOf("@", 0) < 0)
             {
             window.alert("Please Enter A Valid E-Mail Address.");
             emailId.focus();
             return false;
             }
             
             if (emailId.value.indexOf(".", 0) < 0)
             {
             window.alert("Please Enter A Valid E-Mail Address.");
             emailId.focus();
             return false;
             }
             */
            if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length)
            {
                alert("Please Enter Valid Email Address");
                document.contactperson.emailId.focus();
                return false;
            }
            return true;
        }



        function check() {
            if (confirm('Are You Sure, You want to Add this Contact?')) {
                return true;
            } else {
                return false;
            }
        }
    </script>



</script>



<div id="EditLocation" style="    width: 350px;
     height: 180px;
     border: 1px solid;
     position: fixed;
     background: white;
     z-index: 100;
     left: 40%;
     display:none;    box-shadow:gray -2px 1px 10px 9px;

     ">

    <button type="button"class="btn btn-danger btn-xs"id="CloseLocationButton123"style="float:right;margin:5px;">Close</button>
    <center>
        <input type="hidden" name="idlocation" id="idlocation"><br>
        <input type="hidden" name="idclient" id="idclient"><br><br>
        Location Name : <input type="text" name="locname" id="locname"><br><br>

        <input type="button" id="updatelocation" value="Edit location"/></center>
</div>

<div id="EditDepartment" style="    width: 350px;
     height: 180px;
     border: 1px solid;
     position: fixed;
     background: white;
     z-index: 100;
     left: 40%;
     display:none;    box-shadow:gray -2px 1px 10px 9px;">

    <button type="button"class="btn btn-danger btn-xs"id="CloseDepartmentButton123"style="float:right;margin:5px;">Close</button>
    <center>
        <input type="hidden" name="iddepartment" id="iddepartment"><br>
        <input type="hidden" name="idclient" id="idclient" value="<?php echo $client_id; ?>"><br><br>
        Department Name : <input type="text" name="departname" id="departname"><br>
        <input type="hidden" name="departlocationid" id="departlocationid" /><br><br>
        <input type="button" id="updatedepart" value="Edit department"/></center>
</div>


<div class="row">
    <div class="col-xs-10 col-sm-offset-1">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <div class="title">Create Contact</div>

                </div>
            </div>
            <div class="card-body">
                <div class="step">
                    <ul class="nav nav-tabs nav-justified" role="tablist">
<!--                        <li role="step" class="active">
                            <a href="#step1" id="step1-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">
                                <div class="icon fa fa-map-marker"></div>
                                <div class="step-title">
                                    <div class="title">Create Location </div>
                                    <div class="description">Add Location for contact directory</div>
                                </div>
                            </a>
                        </li>
                        <li role="step">
                            <a href="#step2" role="tab" id="step2-tab" data-toggle="tab" aria-controls="profile">
                                <div class="icon fa fa-users"></div>
                                <div class="step-title">
                                    <div class="title">Create Department</div>
                                    <div class="description">Add department for contact directory</div>
                                </div>
                            </a>
                        </li>
                        <li role="step">
                            <a href="#step3" role="tab" id="step2-tab" data-toggle="tab" aria-controls="profile">
                                <div class="icon fa fa-user"></div>
                                <div class="step-title">
                                    <div class="title">Create person </div>
                                    <div class="description">Add Person in particular department</div>
                                </div>
                            </a>
                        </li> -->
                        <li role="step" class="active">
                            <a href="#step4" role="tab" id="step2-tab" data-toggle="tab" aria-controls="profile">
                                <div class="icon fa fa-user"></div>
                                <div class="step-title">
                                    <div class="title">Create Contact Directory</div>
                                    <div class="description">Upload CSV of Contact Directory</div>
                                </div>
                            </a>
                        </li>

                    </ul>
                    <div class="tab-content">
<!--                        <div role="tabpanel" class="tab-pane fade in active" id="step1" aria-labelledby="home-tab">
                            <div class="row">
                                <div class="col-sm-12">

                                    <div class="text-center" style="border:1px solid #e6e6e6; box-shadow:0 1px 5px rgba(0, 0, 0, 0.1); padding:10px;height:380px !important">
                                        <form role="form" method="post" enctype="multipart/form-data" action="Link_Library/link_create_location.php">
                                        <div class="form-group col-sm-6">
                                            <input type="hidden" name="clientid" value="<?php echo $_SESSION['client_id']; ?>">
                                            <label for="exampleInputEmail1">All Locations</label>
                                            <div id="displaylocations" style="width:89%;height:300px;border:1px solid #ccc; text-align: left;padding: 15px 20px;font-size: 14px;overflow:scroll;">
                                                <?php /*
                                                  for($r=0;$r<$count;$r++)
                                                  {
                                                  echo $value[$r]['locationName']."&nbsp;&nbsp;&nbsp;<span class='delete_location' location_delete='".$value[$r]['locationId']."' >Delete</span>&nbsp;&nbsp;&nbsp;<span class='edit_location' location_edit='".$value[$r]['locationId']."' location_name='".$value[$r]['locationName']."' >Edit</span><br>";
                                                  } */
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputPassword1">Location<span style="color:red">*</span></label>
                                            <input type="text" name="contact_location" id="contact_location" class="form-control" id="exampleInputPassword1" placeholder="Add New Location">
                                        </div>


                                        <input type="button" name="add_location" id="add_location" class="btn btn-success btn-sm commonColorSubmitBtn" value="Adds"  />
                                        </form>
                                    </div>


                                </div>
                            </div>
                        </div>-->

<!--                        <div role="tabpanel" class="tab-pane fade" id="step2" aria-labelledby="profile-tab">
                            <div class="row">
                                <form method="post" action="Link_Library/link_create_department.php">
                                <div class="form-group col-sm-4">
                                    <label for="exampleInputPassword1">Select Location</label>
                                    <select name="locationDepart" id="locationDepart" style="width:300px;">
                                        <option selected>------- Select Location --------</option>
                                        <?php
                                        /* for($r=0;$r<$count;$r++)
                                          {
                                          echo " <option value=" .$val['posts'][$r]['locationId'].">".$val['posts'][$r]['locationName']."</option>";
                                          } */
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="exampleInputEmail1">Departments</label>
                                    <div id="nameDepartments" style="    width: 100%;
                                         overflow-y: scroll;
                                         max-height: 150px;min-height:33px;padding:5px;
                                         border: 1px solid #ccc;">

                                    </div>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label for="exampleInputEmail1">Department<span style="color:red">*</span></label>
                                    <input type="text" name="department" id="department" class="form-control" id="exampleInputEmail1" placeholder="Add New deparment">
                                </div>


                                <div class="form-group col-sm-12">
                                    <center> <button type="button" name="addDepartment" id="addDepartment" class="btn btn-success addBTN">Add Department</button></center>
                                </div>
                                </form>
                            </div>
                        </div> -->



<!--                        <div role="tabpanel" class="tab-pane fade" id="step3" aria-labelledby="profile-tab">
                            <div class="row">
                                <form method="post" name="contactperson" action="Link_Library/link_create_contact.php" onsubmit="return check()">
                                    <div class="form-group col-sm-4">
                                        <label for="exampleInputEmail1">Employee Code<span style="color:red">*</span></label>
                                        <input type="hidden" name="cid" value="<?php echo $client_id; ?>" />
                                        <input type="text" name="empid" class="form-control" id="exampleInputEmail1" placeholder="Employee Code">
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="exampleInputPassword1">Select Location<span style="color:red">*</span></label>
                                        <select name='locationDepart2' id='locationDepart2' style="width:300px;" id="sel_location">
                                            <option selected value="0">----Select Location----</option>
                                        </select>

                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label for="exampleInputEmail1">Department<span style="color:red">*</span></label>
                                        <select name='departments2' id='departments2' style="width:300px;">
                                            <option selected value="0">----Select Department----</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="exampleInputEmail1">Designation<span style="color:red">*</span></label>
                                        <input type="text" name="designation" class="form-control" id="exampleInputEmail1" placeholder="Your Designation">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="exampleInputEmail1">Name<span style="color:red">*</span></label>
                                        <input type="text" name="empname" class="form-control" id="exampleInputEmail1" placeholder="Employee Full name">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="exampleInputEmail1">Contact No.(Personal)<span style="color:red">*</span></label>
                                        <input type="text" name="contact_personal" class="form-control" id="exampleInputEmail1" placeholder="Add Personal Contact No. Ex- 9876543210  OR  0124987654">
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label for="exampleInputEmail1">Contact No.(Office)<span style="color:red">*</span></label>
                                        <input type="text" name="contact_office" class="form-control" id="exampleInputEmail1" placeholder="Add Office Contact No. Ex- 9876543210  OR  0124987654">
                                    </div>        
                                    <div class="form-group col-sm-12">
                                        <label for="exampleInputEmail1">Email Id<span style="color:red">*</span></label>
                                        <input type="text" name="emailId" class="form-control" id="exampleInputEmail1" placeholder="Add Email Id">
                                    </div>  


                                    <div class="form-group col-sm-12"><center>
                                            <button type="submit" name="user_form" class="btn btn-success commonColorSubmitBtn" onclick = "return conperson();">Submit</button></center>
                                    </div>
                                </form>
                            </div>
                        </div>	-->

                        <!---------------------------------------------------------------------------------------------------------->


                        <div role="tabpanel" class="tab-pane fade in active" id="step4" aria-labelledby="profile-tab">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="col-sm-6 col-sm-offset-2">
                                        <div class="panel panel-success">
                                            <div class="panel-heading">Upload User Details</div>
                                            <div class="panel-body">
                                                <div class="text-center" style="border:1px solid #e6e6e6; box-shadow:0 1px 5px rgba(0, 0, 0, 0.1); padding:10px;">
                                                    <form role="form" method="post" enctype="multipart/form-data" action="Link_Library/link_contact_directory_csv.php">
                                                        <div class="form-group text-center">
                                                            <label for="exampleInputFile">Upload CSV File</label>
                                                            <center>  <input class="text-center" accept = ".csv" name="contact_csv_file" type="file" id="exampleInputFile" required></center>

                                                        </div>
                                                        <input type="submit" name="user_csv"class=" btn btn-success btn-sm commonColorSubmitBtn" value="Submit" />
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <span style="    position: absolute;
                                          font-size: 16px;
                                          right: 9%;
                                          bottom: 15%;
                                          text-decoration: underline;"><a href="demoCSVfile/contactsDirectoryCSVFormat.csv"> CSV file format</a></span>
                                </div>
                            </div>
                        </div> 

                        <!------------------------------------------------------------------------>					
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
unset($_SESSION['msg']);
?>          


</div>
<?php include 'footer.php'; ?>