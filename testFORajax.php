  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!--<script src="js/get_department.js" type="text/javascript"></script>-->


<?php 
//include 'navigationbar.php';

session_start();
$client_id = $_SESSION['client_id'];

?>
<?php
// include 'leftSideSlide.php';
?>
<script>
$(document).ready(function(){
$("#location").change(function(){

var value = $("#location").val();
var idclient = "CO-9";

alert(value);
alert(idclient);
        $.ajax({
            type:'POST',
            url: 'http://admin.benepik.com/employee/virendra/benepik_admin/lib/link_view_departments.php',
            data: {
                   clientid :idclient,
                   locationName:value,
                  },
            dataType: 'jsonp',
            jsonp: 'mm',
            jsonpCallback: 'jsonpCallback',
            success: function(){
                alert("you are success");
                               }
              });

});
});

function jsonpCallback(data){
                                                          
                           var mesg= JSON.stringify(data);
                           var jsonData= JSON.parse(mesg);

                           $("#result").text("Hello i m here");
}
</script>
<div id="result">My name is deepak</div>


<select id="location">
<option value="Delhi">Delhi</option>
<option value="Gurgaon">Gurgaon</option>
</select>