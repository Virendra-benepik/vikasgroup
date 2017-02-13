  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
 <!-- <script src="js/get_department.js" type="text/javascript"></script> -->


<?php include 'navigationbar.php';

session_start();
$client_id = $_SESSION['client_id'];

?>
<?php include 'leftSideSlide.php';?>
<script>
$(document).ready(function(){

$("#add_location").click(function(){
alert("You clicked me");
});

$("#location").change(function(){

var myvalue = $("#location").val();
var idclient = "<?php echo $client_id?>";


        $.ajax({
            type:'POST',
            url: 'http://admin.benepik.com/employee/virendra/benepik_admin/lib/link_view_departments.php',
            data: {
                   clientid : idclient,
                   locationName : myvalue
                  },
           
            success: function(data){
            $("#departmentid").html(data);
                               }
              });

});

$("body").delegate('.delete_location','click',function(){
var locationDelete = $(this).attr("location_delete");
alert(locationDelete);
        $.ajax({
            type:'POST',
            url: 'http://admin.benepik.com/employee/virendra/benepik_admin/lib/link_delete_location.php',
            data: {
                   locationid : locationDelete,
                  },
           
            success: function(data){
            alert('You successfully delete location');
            viewAllLocations();
                               }
              });

});

$("body").delegate('.edit_location','click',function(){

$("#EditLocation").css({"display":"block"});

var locationEdit = $(this).attr("location_edit");
var locationName = $(this).attr("location_name");
var locationClientid = $(this).attr("location_clientid");

document.getElementById("idlocation").value = locationEdit;
document.getElementById("idclient").value = locationClientid;
document.getElementById("locname").value = locationName;

});

$("#updatelocation").click(function(){

var clientids = $("#idclient").val();
var nameloc = $("#locname").val();
var idloc = $("#idlocation").val();

$.ajax({
            type:'POST',
            url: 'http://admin.benepik.com/employee/virendra/benepik_admin/lib/link_update_location.php',
            data: {
                   clientid: clientids,
                   locationid : idloc,
                   locationname: nameloc,
                  },
           
            success: function(data){
            alert('Edit location successfully');
            $("#EditLocation").css({"display":"none"});
            viewAllLocations();
                               }
        });

});

});

function viewAllLocations()
{
var idclient = "CO-9";

        $.ajax({
            type:'POST',
            url: 'http://admin.benepik.com/employee/virendra/benepik_admin/lib/link_view_locations.php',
            data: {
                   clientid : idclient,
                  },
           
            success: function(data)
                    {
                     afterDeleteLocation(data);
                    }
              });
}

function afterDeleteLocation(data)
{

var jsonData= JSON.parse(data);
$('#displaylocations').empty();
for(i=0;i<jsonData.posts.length;i++)
{
var locname = jsonData.posts[i].locationName;
var locid = jsonData.posts[i].locationId;
$('#displaylocations').append($('<div>'+ locname + "&nbsp;&nbsp;&nbsp;<span class='delete_location' location_delete='" + locid +"'>Delete</span>"+"&nbsp;&nbsp;&nbsp;<span class='edit_location' location_edit='"+locid+"' location_clientid='CO-9' location_name='"+locname+"'>Edit</span>" +'</div>'));
}

}

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
$cid = $_SESSION['client_id'];
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
$count = count($value);
?>
<script>



$(document).ready(function(){
  $("#CloseLocationButton123").click(function(){
    $("#EditLocation").hide();
});
   
});


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
<input type="hidden" name="idclient" id="idclient"><br>
Location Name : <input type="text" name="locname" id="locname"><br><br>

<input type="button" id="updatelocation" value="Edit location"/></center>
</div>

                <div class="row">
                    <div class="col-xs-10 col-sm-offset-1">
                         <div class="card">
                                <div class="card-header">
                                    <div class="card-title">
                                        <div class="title">Create Contact Directory</div>
                                        
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="step">
                                        <ul class="nav nav-tabs nav-justified" role="tablist">
                                            <li role="step" class="active">
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
                                                        <div class="description">Add Person in perticular deparment</div>
                                                    </div>
                                                </a>
                                            </li>
                                            
                                        </ul>
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade in active" id="step1" aria-labelledby="home-tab">
                                               <div class="row">
                                                 <div class="col-sm-12">
                                                  
                                                  <div class="text-center" style="border:1px solid #e6e6e6; box-shadow:0 1px 5px rgba(0, 0, 0, 0.1); padding:10px;height:380px !important">
                                                <!--<form role="form" method="post" enctype="multipart/form-data" action="Link_Library/link_create_location.php">-->
                                                 <div class="form-group col-sm-6">
                                                 <input type="hidden" name="clientid" value="<?php echo $_SESSION['client_id']; ?>">
                                                  <label for="exampleInputEmail1">All Locations</label>
                                                  <div id="displaylocations" style="width:89%;height:300px;border:1px solid #ccc; text-align: left;padding: 15px 20px;font-size: 14px;overflow:scroll;">
                                                  <?php                                         
                                                  for($r=0;$r<$count;$r++)
                                                  {
                                                  echo '<div class="row"><div class="col-xs-6 col-sm-8 col-md-8 col-lg-8">'. $value[$r]['locationName']."</div><div class='col-xs-3 col-sm-2 col-md-2 col-lg-2'><span class='delete_location' location_delete='".$value[$r]['locationId']."' ><button type='button'class='btn btn-danger btn-xs'><span class='glyphicon glyphicon-trash'></span> Delete</button></span></div><div class='col-xs-3 col-sm-2 col-md-2 col-lg-2'><span class='edit_location' location_edit='".$value[$r]['locationId']."' location_name='".$value[$r]['locationName']."' location_clientid='CO-9'><button type='button'class='btn btn-info btn-xs'><span class='glyphicon glyphicon-edit'></span> Edit</button></span></div></div>";
                                                  }
                                                  ?>
                                                 </div>
                                                 </div>
                                                 <div class="form-group col-sm-6">
                                            	<label for="exampleInputPassword1">Location</label>
                                            	<input type="text" name="contact_location" id="contact_location" class="form-control" id="exampleInputPassword1" placeholder="Add New Location">
                                        	</div>
                         
                                                 
                                                    <input type="button" name="add_location" id="add_location" class="btn btn-success btn-sm" value="Adds" />
                                                 <!--</form>-->
                                                          </div>
                                               
                                           
                                        </div>
                                        </div>
                                            </div>
											
                                            <div role="tabpanel" class="tab-pane fade" id="step2" aria-labelledby="profile-tab">
                                                <div class="row">
                                                <form method="post" action="Link_Library/link_create_department.php">
                                        <div class="form-group col-sm-4">
                                            <label for="exampleInputEmail1">Company Name</label>
                                             <input type="hidden" name="cid" value="<?php echo $_SESSION['client_id'];?>" />
                                            <input type="text" name="client_name" class="form-control" id="exampleInputEmail1" value="<?php echo $_SESSION['client_name']; ?>" readonly>
                                        </div>
                                        <div class="form-group col-sm-4">
                                           <label for="exampleInputPassword1">Select Location</label>
                                            <select name="location" style="width:300px;">
                                            <option selected> ------- Select Location -------- </option>
                                            <?php
                                         
                                           for($r=0;$r<$count;$r++)
                                            {
                                          echo " <option value=" .$val['posts'][$r]['locationId'].">".$val['posts'][$r]['locationName']."</option>";
                                            }
                                            ?>
                                            </select>
                                        </div>
                                         <div class="form-group col-sm-4">
                                            <label for="exampleInputEmail1">Department</label>
                                            <input type="text" name="department" class="form-control" id="exampleInputEmail1" placeholder="Add New deparment">
                                        </div>

                                        
                                        <div class="form-group col-sm-12">
                                        <button type="submit" name="user_form" class="btn btn-success">Submit</button>
										</div>
                                    </form>
                                                </div>
                                            </div>
                                            
											
			  <div role="tabpanel" class="tab-pane fade" id="step3" aria-labelledby="profile-tab">
                                                <div class="row">
                                                <form method="post" action="Link_Library/link_create_contact.php">
                                        <div class="form-group col-sm-4">
                                            <label for="exampleInputEmail1">Company Name</label>
<input type="hidden" name="cid" value="<?php echo $client_id?>"/>
                                            <input type="text" name="first_name" class="form-control" id="exampleInputEmail1" value="<?php echo $_SESSION['client_name']; ?>" readonly>
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <label for="exampleInputPassword1">Select Location</label>
                                            <select name='location' id='location' style="width:300px;" id="sel_location">
                                            <option selected>--- Select Location----</option>
                                           <?php
                                           for($r=0;$r<$count;$r++)
                                            {
                                          echo " <option value=" .$val['posts'][$r]['locationName'].">".$val['posts'][$r]['locationName']."</option>";
                                            }
                                            ?>
                                            </select>
                                            
                                        </div>
                                         <div class="form-group col-sm-4">
                                            <label for="exampleInputEmail1">Department</label>
                                           <select name='department' id='departmentid' style="width:300px;">
                                            
                                            
                                            </select>
                                        </div>
				    <div class="form-group col-sm-12">
                                            <label for="exampleInputEmail1">Email Id</label>
                                            <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Add Email Id">
                                        </div>
				<div class="form-group col-sm-12">
                                            <label for="exampleInputEmail1">Designation</label>
                                            <input type="text" name="designation" class="form-control" id="exampleInputEmail1" placeholder="Your Designation">
                                        </div>
				<div class="form-group col-sm-12">
                                            <label for="exampleInputEmail1">Contact No.</label>
                                            <input type="text" name="contact" class="form-control" id="exampleInputEmail1" placeholder="Add Contact No.">
                                        </div>

                                        
                                        <div class="form-group col-sm-12">
                                        <button type="submit" name="user_form" class="btn btn-success">Submit</button>
										</div>
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
<?php include 'footer.php';?>