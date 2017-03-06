<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';?>
<?php require_once('Class_Library/class_user_update.php');

$obj = new User();
$clientid=$_SESSION['client_id'];
?>
<style>
#dataforupdate{

   
display:none;

}
#display_data{
  
  
display:none;
}
#display_data td{
padding: 5px 4px;
}
#display_data th{
padding: 5px 4px;
}
#display_data span{
    color: white;
    background: #1ABC9C;
    padding: 3px;
    border-radius: 4px;
    cursor: pointer;
}
</style>
<script>
function check() {
        if (confirm('Are You Sure, You want to Update this?')) {
            return true;
        } else {
            return false;
        }
    } 
function updateformvalidation()
{
	var userfirstname = document.getElementById("emp_name");
	var userlastname = document.getElementById("emp_last");
	//var temp_depar = document.getElementById("temp_depar");
	
	if(userfirstname.value == "")
	{
		alert("Please Enter User First Name");
		userfirstname.focus();
		return false;
	}
	if(userlastname.value == "")
	{
		alert("Please Enter User Last Name");
		userlastname.focus();
		return false;
	}
	/*if(temp_depar.value == "")
	{
		alert("Please Enter Course");
		temp_depar.focus();
		return false;
	}*/
}
</script>
<script>

$("body").delegate('.edit_data','click',function(){

$("#dataforupdate").css({"display":"block"});

var firstName = $(this).attr("emp_name");
var lastName = $(this).attr("emp_name2");
var empid = $(this).attr("emp_uui");
var mobile = $(this).attr("emp_mob");
var department = $(this).attr("emp_depart");
var designation = $(this).attr("emp_desig");
var location = $(this).attr("emp_loc");
var branch = $(this).attr("emp_bra");
var grade = $(this).attr("emp_gra");


document.getElementById("emp_id").value = empid;
document.getElementById("emp_name").value = firstName;
document.getElementById("emp_last").value = lastName;

/*document.getElementById("emp_mail").value = mailid;
document.getElementById("emp_mob").value = mobile;*/

document.getElementById("temp_depar").value = department;
document.getElementById("emp_desig").value = designation;
document.getElementById("emp_loc").value = location;
document.getElementById("emp_bra").value = branch;
document.getElementById("emp_gra").value = grade;

});

</script>
<script>
$(document).ready(function(){
    $(".userupdateClose").click(function(){
        $(#dataforupdate).hide();
alert("hello ");
    });
});
</script>





<button type="button" >Open Modal</button>


<!-- Modal -->
<div id="myModalee" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
       <h4 class="modal-title">Update User Information</h4>
      </div>
      <div class="modal-body">
        
<div id="dataforupdate">
<form method="post"class="form dddd" enctype="multipart/form-data" action="Link_Library/link_client_update_user.php" onsubmit="return check()">

<div class="row">
<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

<input style="color:#2d2a3b;" type="hidden" name="idclient" id="idclient" value="<?php echo $clientid; ?>"/>
<input style="color:#2d2a3b;" type="hidden" name="emp_id" id="emp_id"/>

<label for="First_Name">First Name :<span style="color:red">*</span></label><input style="color:#2d2a3b;"type="text"class="form-control" name="emp_name" id="emp_name"/></div>

<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
<label for="Last_Name">Last Name :<span style="color:red">*</span></label><input style="color:#2d2a3b;" type="text" class="form-control" name="emp_last" id="emp_last"/></div>
</div>
<div class="row">
<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
<label for="Department_Name">Department:</label><input style="color:#2d2a3b;" type="text"  class="form-control"  name="temp_depar" id="temp_depar"/></div>
<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><label for="Designation">Designation :</label><input  style="color:#2d2a3b;"type="text"class="form-control"  name="emp_desig" id="emp_desig"/></div>
</div>


<div class="row">
<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><label for="Location">Location :</label> <input style="color:#2d2a3b;" type="text"class="form-control"  name="emp_loc" id="emp_loc"/></div>
<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><label for="Branch">Branch :</label> <input  style="color:#2d2a3b;"type="text"class="form-control"  name="emp_bra" id="emp_bra"/></div>
</div>

<div class="row">
<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"><label for="Grade"> Grade :</label><input style="color:#2d2a3b;" type="text"class="form-control"  name="emp_gra" id="emp_gra"/></div>
</div>

<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><center><input style="color:#2d2a3b;" type="submit"class="btn btn-info commonColorSubmitBtn"  name="updateData" value="Update Data" onclick="return updateformvalidation();"></center></div></div>
</form>


</div>

      </div>
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
      </div>
    </div>

  </div>
</div>
<br>
<br><br>
<br>

<br>


          <div class="container-fluid">
            <div class="side-body padding-top">
              <?php
                if(isset($_SESSION['msg']))
                {
                
                echo  "<div class='alert alert-success' role='alert'>"." <strong>Well !</strong>".$_SESSION['msg']
                                               ."</div>";
                 }
                ?>                               
                </div>
                
                <div class="row">
                    <div class="col-xs-10 col-sm-offset-1"style="border:2px solid #dcdcdc;padding:5px;margin-top:-100px;" >
                         <div class="card">
                                <div class="card-header">
                                    <div class="card-title">
                                        <div class="title"><strong>Update User Details</strong></div>
                                    </div>
                                </div>









                                <div class="card-body">
                                    <div class="step">
                                        <ul class="nav nav-tabs nav-justified" role="tablist">
                                            <li role="step">
                                                <a href="#step2" role="tab" id="step2-tab" data-toggle="tab" aria-controls="profile">
                                                    <div class="icon fa fa-user"></div>
                                                    <div class="step-title">
                                                        <div class="title">Search User For Updation</div>
                                                        <div class="description"></div>
                                                    </div>
                                                </a>
                                            </li>
											<!--
											<li role="step">
                                                
											   <a href="#step1" id="step1-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">
                                                    <div class="icon fa fa-users"></div>
                                                    <div class="step-title">
                                                        <div class="title">Upload Csv</div>
                                                        <div class="description">If Multiple User then Upload CSV File. </div>
                                                    </div>
                                                </a>
												
                                            </li>
                                            -->
                                        </ul>
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade" id="step1" aria-labelledby="home-tab">
                                               <div class="row">
                                                 <div class="col-sm-12">
                                                   <div class="col-sm-6 col-sm-offset-2">
                                                    <div class="panel panel-success">
                                                     <div class="panel-heading">Upload User Details</div>
                                                        <div class="panel-body">
                                                         <div class="text-center" style="border:1px solid #e6e6e6; box-shadow:0 1px 5px rgba(0, 0, 0, 0.1); padding:10px;">
                                                <form role="form" method="post" enctype="multipart/form-data" action="Link_Library/link_client_update_user.php">
                                                 <div class="form-group text-center">
                                                  <label for="exampleInputFile">Upload CSV File</label>
                                                     <center>  <input style="color:#2d2a3b;" class="text-center" name="user_csv_file" type="file" id="exampleInputFile" accept=".csv" required></center>
                         
                                                 </div>
                                                    <input style="color:#2d2a3b;" type="submit" name="user_csv"class=" btn btn-success btn-sm commonColorSubmitBtn" value="Submit" />
                                                 </form>
                                                          </div>
                                                </div>
                                            </div>
                                        </div>
										<span style="    position: absolute;
    font-size: 16px;
    right: 9%;
    bottom: 15%;
    text-decoration: underline;"><a href="demoCSVfile/demoCSVformat.csv"> CSV file format</a></span>
                                        </div>
                                        </div>
                                            </div>
                            
            <div role="tabpanel" class="tab-pane fade in active" id="step2" aria-labelledby="profile-tab">
                                  <div class="row">


                                    <form method="post" action="update_user.php">
                                        <div class="form-group col-sm-4">
                                            <label for="exampleInputEmail1">Enter Name or Email Id or Employee Id<span style="color:red">*</span></label>
                                            <input style="color:#2d2a3b;"type="text" name="first_name" required class="form-control" id="exampleInputEmail1" placeholder="First Name | Email id | Employee Id" required>
                                        </div>                                      
                                        <div class="form-group col-sm-12">
                                        <button type="submit" name="user_form" class="btn btn-success commonColorSubmitBtn">Submit</button>
										</div>
                                    </form>
                                    </div>
									<div id="display_data">
<?php 
if(isset($_POST['user_form']))
{
echo "<script>$('#display_data').css({'display':'block'});</script>";

extract($_POST);
$result = $obj->userForm($first_name);
$getcat = json_decode($result,true);
$value = $getcat['posts'];
$count = count($value);

if($count>0)
{
echo "<table border='1' style='width: 100%;border: 1px solid #ADA4A4;font-size: 14px;'><tr><th>First Name</th><th>Last Name</th><th>Email Id</th><th>Employee Id</th><th>Department</th><th>Designation</th><th>Location</th><th>Branch</th><th>Grade</th><th>Action</th></tr>";
for($i=0;$i<$count;$i++)
{
$name = $value[$i]['firstName'];
$name2 = $value[$i]['lastName'];
$mail = $value[$i]['emailId'];
$uui=$value[$i]['employeeId'];
$depart = $value[$i]['department'];
$desig = $value[$i]['designation'];
$loc = $value[$i]['location'];
$bra = $value[$i]['branch'];
$gra = $value[$i]['grade'];
$emp_code =$value[$i]['employeeCode'];

echo "<tr><td>".$name."</td><td>".$name2."</td><td>".$mail."</td><td>".$emp_code."</td><td>".$depart."</td><td>".$desig."</td><td>".$loc."</td><td>".$bra."</td><td>".$gra."</td><td  data-toggle='modal' data-target='#myModalee'><span class='edit_data commonColorSubmitBtn' emp_name='".$name."' emp_name2='".$name2."' emp_uui='".$uui."' emp_mob='".$name2."' emp_depart='".$depart."' emp_desig='".$desig."' emp_loc='".$loc."' emp_bra='".$bra."' emp_gra='".$gra."' >Update</span></td></tr>";
}
echo "</table>";
}
else
{
echo "No data found";
}

}
?>

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
<?php include 'footer.php';?>