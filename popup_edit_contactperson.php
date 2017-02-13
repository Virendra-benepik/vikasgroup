<style>
#edit_popup_container{
    width: 600px;
    height: 350px;
    border: 1px solid;
    position: fixed;
    z-index: 1;
    background: white;
    top: 20%;
    left: 30%;
display:none;
}
</style>
<?php 

session_start();
$client_id = $_SESSION['client_id'];

$string = "clientid=$client_id";

$sub_req_url ="http://admin.benepik.com/employee/virendra/benepik_admin/lib/link_view_locations.php";
$ch = curl_init($sub_req_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($ch, CURLOPT_POSTFIELDS,  "$string");
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);

$resp = curl_exec($ch);
curl_close($ch);
$val = json_decode($resp,true);
$count  = count($val);

?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script>
function editpopup(a,b,c,d,e){
$("#edit_popup_container").css({"display":"block"});
//alert(b);

document.getElementById("name").value = e;
document.getElementById("email").value = c;
document.getElementById("contact").value = d;
}
</script>

<script>
$(document).ready(function(){

$("#location").change(function(){

var myvalue = $("#location").val();
var idclient = "<?php echo $client_id; ?>";

alert(myvalue);
alert(idclient);

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
});
</script>

<div id="edit_popup_container">
<form name="form1" method="post">
Name:<br>
<input type="text" name="name" id="name"/><br>
location:<br>
<select name="location" id="location" style="width:200px">
                                           <?php
                                           for($r=0;$r<$count;$r++)
                                            {
                                          echo " <option value=" .$val['posts'][$r]['locationName'].">".$val['posts'][$r]['locationName']."</option>";
                                            }
                                            ?>
</select>
<br>
Department:<br>
<select name="departmentid" id="departmentid" style="width:200px">
</select><br>
Email Id:<br>
<input type="text" name="email" id="email"/><br>
Contact No:<br>
<input type="text" name="contact" id="contact"/><br>
<input type="submit" value="Updated"/>
</form>
</div>