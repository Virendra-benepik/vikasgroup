<?php
@session_start();
require_once('../Class_Library/class_contact_directory.php');

if (!empty($_POST)) {
	$user = $_SESSION['user_unique_id'];
    $obj = new ContactPerson();
    extract($_POST);
//    echo'<pre>';print_r($_POST);die;
    $output = $obj->editContactPerson($idclient, $idcontact, $employeeCode, $location, $department, $designation, $personalMobNo, $officeMobNo, $designation,$emailId,$user);
    $getcat = json_decode($output, true);

    $mesg = $getcat['msg'];
    if ($getcat['success'] == 1) {
        echo "<script>alert('$mesg')</script>";
        echo "<script>window.location='../view_contact_directory.php'</script>";
    }
} else {
    ?>
    <form name="form1" method="post" action="">
        <p>client id:
            <label for="textfield"></label>
            <input type="text" name="clientid" id="textfield">
        </p>
        <p>contact id: 
            <label for="textfield2"></label>
            <input type="text" name="contactid" id="textfield2">
        </p>
        <p>department: 
            <label for="textfield2"></label>
            <input type="text" name="department_choose" id="textfield2">
        </p>
        <p>location: 
            <label for="textfield2"></label>
            <input type="text" name="location_choose" id="textfield2">
        </p>
        <p>Person email: 
            <label for="textfield2"></label>
            <input type="text" name="person_email" id="textfield2">
        </p>
        <p>client name: 
            <label for="textfield2"></label>
            <input type="text" name="client_name" id="textfield2">
        </p>
        <p>contact: 
            <label for="textfield2"></label>
            <input type="text" name="mobile_number" id="textfield2">
        </p>
        <p>
            <input type="submit" name="submit" id="button" value="Submit">
        </p>
    </form>
    <?php
}
?>