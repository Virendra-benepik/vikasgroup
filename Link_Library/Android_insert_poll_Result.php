<?php
@session_start();
require_once('../Class_Library/class_poll.php');
if(!empty($_POST))
{
$poll_obj = new Poll();


$idpoll = $_POST["pollid"];
$idoption = $_POST["optionid"];
$byanswer = $_POST["answerby"];


$result = $poll_obj->createAnswer($idpoll,$idoption,$byanswer);
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
    <input type="text" name="optionid" id="pollid" />
    </p>
<p>AnswerBy(email id) : 
    <input type="text" name="answerby" id="answerby" />
    </p>

<input type="submit" name="button" id="button" value="Submit" />

  </p>
</form>
</body>
</html>
<?php
}
?>