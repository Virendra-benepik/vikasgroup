<?php
session_start();
require_once('../Class_Library/class_contact_directory_csv.php');

$obj = new ContactDirectory();     //class object
$clientid = $_SESSION['client_id'];
$user = $_SESSION['user_unique_id'];

//echo "user id-: ".$user;
 
if(isset($_POST['user_csv']))
{
         $filename = trim(str_replace(" ","_", $_FILES['contact_csv_file']['name']));
         //echo  "user csv file name:-".$filename;
         $upload_file_name = $clientid."-".$filename;

	$filtempname = $_FILES['contact_csv_file']['tmp_name'];
	$target = "../contactDirectoryCSVfile/"; 
        $target1 = "/contactDirectoryCSVfile/"; 

$fullcsvpath = $target1.$upload_file_name;
//echo $fullcsvpath;
$result1 = $obj->uploadUserCsv($clientid,$user,$filename,$filtempname,$fullcsvpath);
$result = json_decode($result1, true);
//print_r($result);
$message = $result['msg'];
$suc = $result['success'];
//echo $suc;
  if($suc == 1)
  {
  move_uploaded_file($filtempname, $target.$upload_file_name);
  echo "<script>alert('".$message."')</script>";
  echo "<script>window.location='../create_contact_directory.php'</script>";
  }
  else
  {
  echo $message;
  }
}

else
{
?>
<form method="post" action="" enctype="multipart/form-data">
<p>Channel Id:
    <label for="textfield">upload csv</label>
  <input type="file" name="contact_csv_file" id="textfield">
  </p>
   <p>
  <input type="submit" name="user_csv" id="button" value="upload">
  </p>
  </form>
  

<?php
}
?>