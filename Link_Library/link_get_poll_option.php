<?php
require_once('../Class_Library/class_poll.php');

if(!empty($_POST))
{
$poll_obj = new Poll();

$clientids = $_POST['clientid'];
$pollids = $_POST['pollid'];

$result = $poll_obj->getAnswerOptions($pollids,$clientids);
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
<p>Client id : 
    <input type="text" name="clientid" id="clientid" />
    </p>
<p>poll id : 
    <input type="text" name="pollid" id="clientid" />
    </p>

<input type="submit" name="button" id="button" value="Submit" />

  </p>
</form>
</body>
</html>
<?php
}
?>