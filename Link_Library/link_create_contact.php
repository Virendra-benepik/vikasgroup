<?php
@session_start();
require_once('../Class_Library/class_contact_directory.php');
//require_once('../Class_Library/class_get_useruniqueid.php');   // this class for getting user unique id

if (!empty($_POST)) {

	$user = $_SESSION['user_unique_id'];
    $cid = $_POST['cid'];
    $location = $_POST['locationDepart2'];
    $dept = $_POST['departments2'];
    $employeeid = $_POST['empid'];

    $mob_p = $_POST['contact_personal'];
    $mob_o = $_POST['contact_office'];
    $desig = $_POST['designation'];
    $emailid = $_POST['emailId'];
	$empname = $_POST['empname'];

    $obj = new ContactPerson();  // create object of class cl_module.php
   /* $object = new UserUniqueId();

    $uid = $object->getUserUniqueId($cid, $employeeid);

    $uid1 = json_decode($uid, true);
    $uniqueuserid = $uid1[0]['employeeId'];*/

    $result = $obj->createPerson($cid, $location, $dept, $employeeid, $empname, $mob_p, $mob_o, $desig, $emailid,$user);

    $res = json_decode($result, true);

    if ($res['success'] == 1) {
        echo "<script>alert('" . $res['msg'] . "')</script>";
        echo "<script>window.location='../create_contact_directory.php#step2'</script>";
    }
} else {
    ?>
    <form name="form1" method="post" action="">
        <p>client id:
            <label for="textfield"></label>
            <input type="text" name="cid" id="textfield">
        </p>
        <p>location id: 
            <label for="textfield2"></label>
            <input type="text" name="location" id="textfield2">
        </p>
        <p>department: 
            <label for="textfield2"></label>
            <input type="text" name="department" id="textfield2">
        </p>
        <p>email: 
            <label for="textfield2"></label>
            <input type="text" name="emailid" id="textfield2">
        </p>
        <p>contact: 
            <label for="textfield2"></label>
            <input type="text" name="contact" id="textfield2">
        </p>
        <p>
            <input type="submit" name="submit" id="button" value="Submit">
        </p>
    </form>
    <?php
}
?>