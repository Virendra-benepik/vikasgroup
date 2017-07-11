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
	var companyname = document.adduserform.companyname;
	var companycode = document.adduserform.companycode;
	//alert(companyname);
	//alert(companycode);
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
	if(companyname.value == 0)
	{
		alert("Please Select Company Name");
		companyname.focus();
		return false;
	}
	if(companycode.value == 0)
	{
		alert("Please Select Company Code");
		companycode.focus();
		return false;
	}
	if(empid.value == "")
	{
		alert("Please Enter Employee code");
		empid.focus();
		return false;
	}
	if(dob.value == "")
	{
		alert("Please Enter Date Of Birth");
		dob.focus();
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
                        <div class="title"><strong>Add User</strong></div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="step">
                        <ul class="nav nav-tabs nav-justified" role="tablist">
                            <li role="step" class="active">
                                <a href="#step1" id="step1-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">
                                    <div class="icon fa fa-users"></div>
                                    <div class="step-title">
                                        <div class="title">Multiple User(Upload CSV)</div>
                                        <!--<div class="description">Multiple User</div>-->
                                    </div>
                                </a>
                            </li>
                            <li role="step">
                                <a href="#step2" role="tab" id="step2-tab" data-toggle="tab" aria-controls="profile">
                                    <div class="icon fa fa-user"></div>
                                    <div class="step-title">
                                        <div class="title">Single User(Fill Form)</div>
                                        <!--<div class="description">If Single User Then Fill Form</div>-->
                                    </div>
                                </a>
                            </li>

                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade in active" id="step1" aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-sm-12" style="margin-left:-15px;">
                                        <div class="col-sm-6">
                                            <div class="panel panel-success">
                                                <div class="panel-heading">Upload CSV File</div>
                                                <div class="panel-body">
                                                    <div class="text-center" style="padding:10px;">
                                                        <form role="form" name="csvform" method="post" enctype="multipart/form-data" action="Link_Library/link_client_user.php" onsubmit="return check()">
                                                            <div class="form-group text-center">
                                                                <label for="exampleInputFile"></label>
                                                                <center>  <input style="color:#2d2a3b;" class="text-center" accept=".csv" name="user_csv_file" type="file" id="exampleInputFile"></center>

                                                            </div>
                                                            <input style="color:#2d2a3b;" onclick="return uploadcsv();" type="submit" name="user_csv"class=" btn btn-success btn-sm commonColorSubmitBtn" value="Submit"/>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
								<div class="row">
								<div class="col-sm-12 col-md-12 col-lg-12 col-xs-12">
								<br/>
								<span style="position: absolute;font-size: 16px;bottom: 15%;text-decoration: underline;"><a href="demoCSVfile/demoCSVformat.csv"> Download CSV file format</a></span>
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
									 <div class="form-group col-sm-4">
                                       <label for="exampleInputPassword1">Company Name<span style="color:red">*</span></label>
                                       <!--<input  style="color:#2d2a3b;" type="text" name="companyname" class="form-control" id="exampleInputPassword1" placeholder="Enter Employee Id">
									   -->
									   <select name="companyname" id="exampleInputPassword1" style="width:100%;" class="form-control">
									   <option value="0">Select Company Name</option>
									   <option value="Sanden Vikas India Pvt Ltd">Sanden Vikas India Pvt Ltd</option>
									    <option value="Pranav Vikas India Pvt Ltd">Pranav Vikas India Pvt Ltd</option>
									    <option value="Ecocat India Pvt Ltd">Ecocat India Pvt Ltd</option>
									    <option value="Sata Vikas India Pvt Ltd">Sata Vikas India Pvt Ltd</option>
									    <option value="Kenmore Vikas India Pvt Ltd">Kenmore Vikas India Pvt Ltd</option>
									    <option value="Sanden Vikas Precision Parts Pvt Ltd">Sanden Vikas Precision Parts Pvt Ltd</option>
									    <option value="Vikas Altech Pvt Ltd">Vikas Altech Pvt Ltd</option>
										<option value="Vikas Group/Corporate">Vikas Group/Corporate</option>
									   </select>
                                    </div>
										
										 <div class="form-group col-sm-4">
                                       <label for="exampleInputPassword1">Company Code<span style="color:red">*</span></label>
                                       <!--<input  style="color:#2d2a3b;" type="text" name="companyname" class="form-control" id="exampleInputPassword1" placeholder="Enter Employee Id">-->
									   
									   <select name="companycode" id="exampleInputPassword1" style="width:100%;" class="form-control">
									   <option value="0">Select Company Code</option>
									   <option value="SVL">SVL</option>
									    <option value="PVL">PVL</option>
										<option value="ECOCAT">ECOCAT</option>
										<option value="SATA">SATA</option>
									    <option value="KVL">KVL</option>
									    <option value="SVP">SVP</option>
									    <option value="VAPL">VAPL</option>
										<option value="CORP">CORP</option>
									   </select>
                                        </div>
										
                                        <div class="form-group col-sm-4">
                                       <label for="exampleInputPassword1">Employee code<span style="color:red">*</span></label>
                                       <input  style="color:#2d2a3b;" type="text" name="emp_code" class="form-control" id="exampleInputPassword1" placeholder="Enter Employee Id">
                                        </div>
                                       </div>
                                    <div class="row">
									     <div class="form-group col-sm-4">
                                            <label for="exampleInputEmail1">Date of Birth<span style="color:red">*</span></label>
                                         
                                            <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.js"></script>


                                            <input  style="color:#2d2a3b;" type="date" name="dob" class="form-control"  id="exampleInputEmail1" placeholder="YYYY-MM-DD"  />

                                        </div>
										
                                        <div class="form-group col-sm-4">
                                            <label for="exampleInputEmail1">Date of Joining</label>
                                         
                                            <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.js"></script>


                                            <input  style="color:#2d2a3b;" type="date" name="doj" class="form-control"  id="exampleInputEmail1" placeholder="YYYY-MM-DD"  />

                                        </div>
										
                                        <div class="form-group col-sm-4">
                                            <label for="exampleInputEmail1">Email Id</label>
                                            <input style="color:#2d2a3b;" type="email" name="email_id" class="form-control" id="exampleInputEmail1" placeholder="Enter Email id">
                                        </div>
                                    </div>
									<div class="row">
                                        <div class="form-group col-sm-4">
                                            <label for="exampleInputPassword1">Designation</label>
                                            <input style="color:#2d2a3b;" type="text" name="designation" class="form-control" id="designation" placeholder="Enter Designation">
                                        </div>
                                        <div class="form-group col-sm-4">
                                       <label for="exampleInputPassword1">Department</label>
                                            <input  style="color:#2d2a3b;" type="text" name="department" class="form-control" id="department" placeholder="Enter Department">
                                        </div>
										<div class="form-group col-sm-4">
                                            <label for="exampleInputPassword1">Mobile number</label>
                                            <input style="color:#2d2a3b;" type="text" class="form-control" name="contact" placeholder="Enter Contact number"></textarea>

                                        </div>
                                    </div> 
									<div class="row">                
                                        
                                        <div class="form-group col-sm-4">
                                            <label for="exampleInputPassword1">Location</label>
                                            <input style="color:#2d2a3b;"type="text" class="form-control" name="location" placeholder="Enter Location"></textarea>

                                        </div>
										<div class="form-group col-sm-4">
                                            <label for="exampleInputPassword1">Branch</label>
                                            <input style="color:#2d2a3b;" type="text" class="form-control" name="branch" placeholder="Enter Branch"></textarea>

                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="exampleInputPassword1">Grade</label>
                                            <input style="color:#2d2a3b;" type="text" class="form-control" name="grade" placeholder="Enter Grade"></textarea>

                                        </div>

                                    </div> 
									<div class="row">              
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