<?php
require_once('../Class_Library/class_getpoll.php');

if(!empty($_POST))
{
$poll_obj = new GetPoll();

$pollid = $_POST["pollid"];
$optionid = $_POST["optionid"];

$result = $poll_obj->getAnswerResult($pollid,$optionid);
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
    <p>Option id : 
    <input type="text" name="optionid" id="optionid" />
    </p>
<input type="submit" name="button" id="button" value="Submit" />

  </p>
</form>
</body>
</html>
<?php
}
?>