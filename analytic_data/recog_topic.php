<?php
if(isset($_REQUEST['clientid']))
{
require_once('../Class_Library/class_recognize_analytics.php');
$obj = new RecognizeAnalytic();
//$client_id = 'CO-7';
$client_id = $_REQUEST['clientid'];
$result = $obj->getRecognizeClientTopic($client_id);
echo $result;
/*$dt  = json_decode($result, true);
echo "<pre>";
print_r($dt);
echo "</pre>";*/
}
else
{
?>
<form method = "post" action="">
clientid : <input type="text" name= "clientid">
<input type = "submit" name="submit" value="submit">
</form>

<?php
}

?>