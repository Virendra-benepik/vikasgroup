<?php include 'navigationbar.php'; ?>
<?php include 'leftSideSlide.php'; ?>
<script>
    function check() {
        if (confirm('Are You Sure, You want to Add this User?')) {
            return true;
        } else {
            return false;
        }
    }
	
	function uploadcsv()
	{
		var user_csv_file = document.csvform.user_csv_file;
		if(user_csv_file.value == "")
	{
		alert("Please Select CSV File");
		user_csv_file.focus();
		return false;
	}
	return true;
	}

function addUserValidation()
{
	var first_name = document.adduserform.first_name;
	var last_name = document.adduserform.last_name;
	var dob = document.adduserform.dob;
	var empid = document.adduserform.emp_code;
	//var department = document.adduserform.department
	if(first_name.value == "")
	{
		alert("Please Enter First Name");
		first_name.focus();
		return false;
	}
	if(last_name.value == "")
	{
		alert("Please Enter Last Name");
		last_name.focus();
		return false;
	}
	if(dob.value == "")
	{
		alert("Please Enter Date Of Birth");
		dob.focus();
		return false;
	}
	if(empid.value == "")
	{
		alert("Please Enter Employee Id");
		empid.focus();
		return false;
	}
	/*if(department.value == "")
	{
		alert("Please Enter Course");
		department.focus();
		return false;
	}*/
	return true;
}
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

    <div class="row">
        <div class="col-xs-10 col-sm-offset-1" style="border:2px solid #dcdcdc;padding:5px;">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <div class="title"><strong>User Details</strong></div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="step">
                        <ul class="nav nav-tabs nav-justified" role="tablist">
                            <li role="step" class="active">
                                <a href="#step1" id="step1-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">
                                    <div class="icon fa fa-users"></div>
                                    <div class="step-title">
                                        <div class="title">Upload CSV</div>
                                        <div class="description">If Multiple User then Upload CSV File </div>
                                    </div>
                                </a>
                            </li>
                            <li role="step">
                                <a href="#step2" role="tab" id="step2-tab" data-toggle="tab" aria-controls="profile">
                                    <div class="icon fa fa-user"></div>
                                    <div class="step-title">
                                        <div class="title">Fill Form</div>
                                        <div class="description">If Single User Then Fill Form</div>
                                    </div>
                                </a>
                            </li>

                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="step1" aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="col-sm-6 col-sm-offset-2">
                                            <div class="panel panel-success">
                                                <div class="panel-heading">Upload User Details</div>
                                                <div class="panel-body">
                                                    <div class="text-center" style="border:1px solid #e6e6e6; box-shadow:0 1px 5px rgba(0, 0, 0, 0.1); padding:10px;">
                                                        <form role="form" name="csvform" method="post" enctype="multipart/form-data" action="Link_Library/link_client_user.php" onsubmit="return check()">
                                                            <div class="form-group text-center">
                                                                <label for="exampleInputFile">Upload CSV File</label>
                                                                <center>  <input style="color:#2d2a3b;" class="text-center" accept=".csv" name="user_csv_file" type="file" id="exampleInputFile"></center>

                                                            </div>
                                                            <input style="color:#2d2a3b;" onclick="return uploadcsv();" type="submit" name="user_csv"class=" btn btn-success btn-sm commonColorSubmitBtn" value="Submit"/>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <span style="    position: absolute;
                                              font-size: 16px;
                                              right: 9%;
                                              bottom: 15%;
                                              text-decoration: underline;"><a href="demoCSVfile/demoCSVformat.csv"> Download CSV file format</a></span>
                                    </div>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane fade" id="step2" aria-labelledby="profile-tab">

                                <form method="post" name="adduserform" action="Link_Library/link_client_user.php" onsubmit="return check()">
                                    <div class="row">
                                        <div class="form-group col-sm-4">
                                            <label for="exampleInputEmail1">First Name<span style="color:red">*</span></label>
                                            <input style="color:#2d2a3b;" type="text" name="first_name" class="form-control" id="exampleInputEmail1" placeholder="Enter First Name" required>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="exampleInputPassword1">Middle Name</label>
                                            <input style="color:#2d2a3b;" type="text" name="middle_name" class="form-control" id="exampleInputPassword1" placeholder="Enter Middle Name">
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="exampleInputEmail1">Last Name<span style="color:red">*</span></label>
                                            <input style="color:#2d2a3b;" type="text" name="last_name" class="form-control" id="exampleInputEmail1" placeholder="Enter Last Name">
                                        </div></div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                       <label for="exampleInputPassword1">Employee Id<span style="color:red">*</span></label>
                                       <input  style="color:#2d2a3b;" type="text" name="emp_code" class="form-control" id="exampleInputPassword1" placeholder="Enter Employee Id">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputEmail1">Date of Birth<span style="color:red">*</span></label>
                                          <!--  <input type="date" name="dob" required class="form-control" id="exampleInputEmail1" placeholder="Enter Email id">-->
                                            <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.js"></script>


                                            <input  style="color:#2d2a3b;" type="date" name="dob" class="form-control"  id="exampleInputEmail1" placeholder="YYYY-MM-DD"  />

                                        </div></div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputEmail1">Father's Name</label>
                                        <!--    <input type="date" name="doj" required class="form-control" id="exampleInputEmail1" placeholder="Enter Email id">-->
                                            <input style="color:#2d2a3b;" type="text" name="fathername" class="form-control" id="exampleInputEmail1" placeholder="Father Name" />
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputEmail1">Email Id</label>
                                            <input style="color:#2d2a3b;" type="email" name="email_id" class="form-control" id="exampleInputEmail1" placeholder="Enter Email id">
                                        </div>
                                    </div> <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputPassword1">Designation</label>
                                            <input style="color:#2d2a3b;" type="text" name="designation" class="form-control" id="designation" placeholder="Enter Designation">
                                        </div>
                                        <div class="form-group col-sm-6">
                                       <label for="exampleInputPassword1">Department</label>
                                            <input  style="color:#2d2a3b;" type="text" name="department" class="form-control" id="department" placeholder="Enter Department">
                                        </div>
                                    </div> <div class="row">                
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputPassword1">Mobile number</label>
                                            <input style="color:#2d2a3b;" type="text" class="form-control" name="contact" placeholder="Enter Contact number"></textarea>

                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputPassword1">Location</label>
                                            <input style="color:#2d2a3b;"type="text" class="form-control" name="location" placeholder="Enter Location"></textarea>

                                        </div>
                                    </div> <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputPassword1">Branch</label>
                                            <input style="color:#2d2a3b;" type="text" class="form-control" name="branch" placeholder="Enter Branch"></textarea>

                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputPassword1">Grade</label>
                                            <input style="color:#2d2a3b;" type="text" class="form-control" name="grade" placeholder="Enter Grade"></textarea>

                                        </div>

                                    </div>    <div class="row">              
                                        <div class="form-group col-sm-12">
                                            <label for="exampleInputPassword1">Gender</label>
                                            <div>
                                                <div class="radio3 radio-check radio-success radio-inline">
                                                    <input type="radio" id="radio5" name="gender" value="Male" checked>
                                                    <label for="radio5">
                                                        Male
                                                    </label>
                                                </div>
                                                <div class="radio3 radio-check radio-warning radio-inline">
                                                    <input type="radio" id="radio6" name="gender" value="Female">
                                                    <label for="radio6">
                                                        Female
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <center>   <button type="submit" name="user_form" class="btn btn-success commonColorSubmitBtn" onclick="return addUserValidation();">Submit</button></center> 
                                        </div>								</div>
                                </form>
                            </div>
                        </div>

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