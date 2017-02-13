  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 <!-- <script src="js/get_department.js" type="text/javascript"></script> -->

<?php include 'navigationbar.php';
session_start();
$client_id = $_SESSION['client_id'];

if(isset($_GET['contactid'])) {
$value = $_GET['contactid'];

$string = "cpid=$value&clientid=$client_id";
$sub_req_url =SITE."link_get_contact_personDetails.php";
$ch = curl_init($sub_req_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($ch, CURLOPT_POSTFIELDS,  "$string");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);

$resp = curl_exec($ch);
curl_close($ch);
$output = json_decode($resp,true);
$output1 = $output['posts'];
}

?>
<?php include 'leftSideSlide.php';?>
<script>
function editcontact()
{
	var location = document.editcontactperson.location;
	var department = document.editcontactperson.department;
	var designation = document.editcontactperson.designation;
	var contact_personal = document.editcontactperson.personalMobNo;
	var contact_office = document.editcontactperson.officeMobNo;
	var x = document.editcontactperson.emailId.value;
    var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");
	
	if(location.value == 0)
	{
	alert("Please Select Location");
	location.focus();
	return false;
	}
	if(department.value == 0)
	{
	alert("Please Select Department");
	department.focus();
	return false;
	}
	if(designation.value == "")
	{
	alert("Please Enter Designation");
	designation.focus();
	return false;
	}
	if(contact_personal.value == "")
	{
	alert("Please Enter Personal Contact Number");
	contact_personal.focus();
	return false;
	}
	if(isNaN(contact_personal.value))
	{
	alert("Please Enter valid personal Number");
	contact_personal.focus();
	return false;
	}
	if((contact_personal.value.length < 10) || (contact_personal.value.length > 15))
	{
	alert("Please Enter valid Personal Number");
	contact_personal.focus();
	return false;
	}
		
	if(contact_office.value == "")
	{
	alert("Please Enter Office Contact Number");
	contact_office.focus();
	return false;
	}
	if(isNaN(contact_office.value))
	{
	alert("Please Enter valid Office Number");
	contact_office.focus();
	return false;
	}
	if((contact_office.value.length < 10) || (contact_office.value.length > 15))
	{
	alert("Please Enter valid Office Number");
	contact_office.focus();
	return false;
	}
	
	if(x == "")
	{
	alert("Please Enter Email Address");
	document.editcontactperson.emailId.focus();
	return false;
	}
	if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) 
	{
        alert("Please Enter Valid Email Address");
		document.editcontactperson.emailId.focus();
        return false;
    }
	
}

function check() {
        if (confirm('Are You Sure, You want to Add this Contact?')) {
            return true;
        } else {
            return false;
        }
    }
</script>
<script>
$(document).ready(function(){

$("#location").change(function(){
var myvalue = $("#location").val();
var idclient = "<?php echo $client_id?>";

        $.ajax({
            url: "<?php echo SITE; ?>Link_Library/link_view_departments.php",
            type:'POST',
            data: {
                   clientid : idclient,
                   locationid : myvalue
                  },
           
                  success: function(data){

			var json = jQuery.parseJSON(data);

			  var count = json.posts.length;
			  var i=0;
			  while(i<=count){
			  	$("#departmentid").append($("<option></option>").attr("value", json.posts[i].deptId).text(json.posts[i].departmentName));
                          	i++;
                          }
                  }
              });

});
});
</script>
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
                
<?php 

//echo $client_id;
$string = "clientid=$client_id";

$sub_req_url = SITE."Link_Library/link_view_location.php";
$ch = curl_init($sub_req_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($ch, CURLOPT_POSTFIELDS,  "$string");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);

$resp = curl_exec($ch);
curl_close($ch);
$val = json_decode($resp,true);

$count  = count($val['posts']);

?>


      <div class="row" style="width: 1000px;
    border: 1px solid #ccc;
    padding: 30px 6px;
    margin: auto;"><h3><strong>Edit Contact Directory</strong></h3><hr>
    
      <form method="post" name="editcontactperson" action="Link_Library/link_update_contact_directory.php" onsubmit="return check()">
                                        <div class="form-group col-sm-4">
                                            <label for="exampleInputEmail1">Employee Username</label>
                                            <input style="color:#2d2a3b;" type="hidden" name="idcontact" value="<?php echo $_GET['contactid'];?>" />
                                            <input style="color:#2d2a3b;"type="hidden" name="idclient" value="<?php echo $client_id; ?>" />
                                            <input style="color:#2d2a3b;" type="text" name="employeeCode" class="form-control" id="exampleInputEmail1" value="<?php echo $output1['userName']; ?>" readonly/>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="exampleInputPassword1">Select Location<span style="color:red">*</span></label>
                                            <select name='location' id='location' style="width:300px;" id="sel_location">
                                            <option value="<?php echo $output1['locationID']; ?>"><?php echo $output1['locationName']; ?></option>
                                           <?php
                                           for($r=0;$r<$count;$r++)
                                            {
if($val['posts'][$r]['locationName']!=$output1['locationName'])
{
        echo " <option value=" .$val['posts'][$r]['locationId'].">".$val['posts'][$r]['locationName']."</option>";
}
                                            }
                                            ?>
                                            </select>
                                            
                                        </div>

                                         <div class="form-group col-sm-4">
                                            <label for="exampleInputEmail1">Select Department<span style="color:red">*</span></label>
                                           <select name='department' id='departmentid' style="width:300px;">
                          <option value="<?php echo $output1['deptId']; ?>"><?php echo $output1['departmentName']; ?></option>
                                            
                                            </select>
<div id="departmentsdisplay"></div>
                                        </div>
				    <div class="form-group col-sm-12">
                                            <label for="exampleInputdesignation">Designation<span style="color:red">*</span></label>
                                            <input style="color:#2d2a3b;"type="text" name="designation" class="form-control" id="exampleInputdesignation" placeholder="Designation" value="<?php echo $output1['designation'];?>">
                                        </div>
				<div class="form-group col-sm-12">
                                            <label for="exampleInputEmail1">Personal Contact No.<span style="color:red">*</span></label>
<input style="color:#2d2a3b;"type="text" name="personalMobNo" class="form-control" id="exampleInputEmail1" placeholder="Add Contact No." value="<?php echo $output1['contactNoPersonal']; ?>" >
                                        </div>
				<div class="form-group col-sm-12">
                                            <label for="exampleInputEmail1">Office Contact No.<span style="color:red">*</span></label>
<input style="color:#2d2a3b;" type="text" name="officeMobNo" class="form-control" id="exampleInputEmail1" placeholder="Add Contact No." value="<?php echo $output1['contactNoOffice']; ?>" >
                                        </div>
					<div class="form-group col-sm-12">
                                            <label for="exampleInputEmail1">Email Id<span style="color:red">*</span></label>
                                            <input style="color:#2d2a3b;" type="text" name="emailId" class="form-control" id="exampleInputEmail1" placeholder="Add Email Id" value="<?php echo $output1['emailId']; ?>">
                                        </div>  
                                        
                                        <div class="form-group col-sm-12">
                                       <center> <button type="submit" name="user_form" class="btn btn-success" onclick="return editcontact();"/>Submit</button></center>
										</div>
                                    </form>
                </div>
                
                
      <?php
      unset($_SESSION['msg']);
      ?>          
                
                
            </div>
<?php include 'footer.php';?>