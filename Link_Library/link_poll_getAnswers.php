<?php
require_once('../Class_Library/class_poll.php');

if(!empty($_POST))
{
$poll_obj = new Poll();

$pollid = $_POST["pollid"];
$clientid = $_POST["clientid"];

$result = $poll_obj->getAnswerOptions($pollid,$clientid);
print_r($result);
}
else
{
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
    <p>Poll id : 
    <input type="text" name="pollid" id="pollid" />
    </p>

<p>Client id : 
    <input type="text" name="clientid" id="clientid" />
    </p>

<input type="submit" name="button" id="button" value="Submit" />

  </p>
</form>
</body>
</html>
<?php
}
?>