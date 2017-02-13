<?php
session_start();
require_once('../Class_Library/class_user_update.php');

$obj = new User();     //class object
$clientid = $_SESSION['client_id'];
$user_unique_id = $_SESSION['user_unique_id'];
if(!empty($_POST))
{ 
if(isset($_POST['user_csv']))
{
         $filename = $_FILES['user_csv_file']['name'];
         $upload_file_name = $clientid."-".$filename;

	$filtempname = $_FILES['user_csv_file']['tmp_name'];
	$target = "../usersCSVupdatedFiles/"; 
        $target1 = "/usersCSVupdatedFiles/"; 

$fullcsvpath = $target1.$upload_file_name;
	
$result1 = $obj->uploadUserCsv($filename,$filtempname,$fullcsvpath);
$result = json_decode($result1, true);
print_r($result);
$message = $result['msg'];
$suc = $result['success'];
echo $suc;
  if($suc == 1)
  {
  move_uploaded_file($filtempname, $target.$upload_file_name);
  echo "<script>alert('data successfully uploaded')</script>";
  echo "<script>window.location='".SITE_URL."update_user.php'</script>";
  }
  else
  {
  echo $message;
  }
}


if(isset($_POST['updateData']))
{
extract($_POST);

$result = $obj->userFormUpdate($emp_id,$emp_name,$emp_last,$temp_depar,$emp_desig,$emp_loc,$emp_bra,$emp_gra,$idclient,$user_unique_id);
$result1 = json_decode($result, true);

$message = $result1['message'];
$suc = $result1['success'];

  if($suc == 1)
  {
  echo "<script>alert('$message')</script>";
  echo "<script>window.location='".SITE_URL."update_user.php'</script>";  }
  else
  {
  echo "<script>alert('Data no updated')</script>";
  }
}


if(isset($_POST['user_form']))
{
extract($_POST);
$result = $obj->userForm($first_name);
print_r($result);
}

}
else
{
?>
<form method="post" action="" enctype="multipart/form-data">
<p>Channel Id:
    <label for="textfield">upload csv</label>
  <input type="file" name="user_csv_file" id="textfield">
  </p>
   <p>
  <input type="submit" name="user_csv" id="button" value="upload">
  </p>
  </form>
  <br/><br/><br/><br/><br/>
<hr/>
single user
<hr/>
<!----------------------------------------------------single user updation--------------------------------------------->

<form name="form1" method="post" action="">
 
<p>First Name:
    <label for="textfield"></label>
  <input type="text" name="first_name" id="textfield">
  </p>
  
  <p>
  <input type="submit" name="user_form" id="button" value="submit">
  </p>
</form>
<?php
}
?>