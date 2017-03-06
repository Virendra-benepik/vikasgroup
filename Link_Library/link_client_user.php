<?php
session_start();
require_once('../Class_Library/class_user.php');

$obj = new User();     //class object
$clientid = $_SESSION['client_id'];
$user = $_SESSION['user_unique_id'];

//echo "user id-: ".$user;

if (!empty($_POST)) {
    if (isset($_POST['user_csv'])) {
        $filename = trim(str_replace(" ", "_", $_FILES['user_csv_file']['name']));
        //echo  "user csv file name:-".$filename;
        $upload_file_name = $clientid . "-" . $filename;

        $filtempname = $_FILES['user_csv_file']['tmp_name'];
        $target = "../usersCSVfiles/";
        $target1 = "/usersCSVfiles/";

        $fullcsvpath = $target1 . $upload_file_name;
//echo $fullcsvpath;
        $result1 = $obj->uploadUserCsv($clientid, $user, $filename, $filtempname, $fullcsvpath);
        $result = json_decode($result1, true);
//print_r($result);
        $message = $result['msg'];
        $suc = $result['success'];
//echo $suc;
        if ($suc == 1) {
            move_uploaded_file($filtempname, $target . $upload_file_name);
            echo "<script>alert('data successfully uploaded')</script>";
           echo "<script>window.location='../add_user.php'</script>";
            //print_r($result);
            die;
        } else {
            echo $message;
        }
    }


    if (isset($_POST['user_form'])) {
//        echo '<pre>';print_r($_POST);die;
        extract($_POST);

        $result = $obj->userForm($clientid, $user, $first_name, $middle_name, $last_name, $emp_code, $dob, $fathername, $email_id, $designation, $department, $contact, $location, $branch, $grade, $gender,$companyname);
        print_r($result);
    }
} else {
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
    <!----------------------------------------------------single user--------------------------------------------->

    <form name="form1" method="post" action="">

        <p>First Name:
            <label for="textfield"></label>
            <input type="text" name="first_name" id="textfield">
        </p>

        <p>Middle Name:
            <label for="textfield"></label>
            <input type="text" name="middle_name" id="textfield">
        </p>

        <p>Last Name:
            <label for="textfield"></label>
            <input type="text" name="last_name" id="textfield">

        </p>
        <p>Employee code:
            <label for="textfield"></label>
            <input type="text" name="emp_code" id="textfield">
        </p>
    </p>
    <p>Date of Birth:
        <label for="textfield"></label>
        <input type="date" name="dob" id="textfield">
    </p>

    </p>
    <p>Date of Joining:
        <label for="textfield"></label>
        <input type="date" name="doj" id="textfield">
    </p>

    <p>Email id:
        <label for="textfield"></label>
        <input type="text" name="email_id" id="textfield">
    </p>

    <p>designation:
        <label for="textfield"></label>
        <input type="text" name="designation" id="textfield">
    </p>

    <p>department:
        <label for="textfield"></label>
        <input type="text" name="department" id="textfield">
    </p>
    <p>Mobile number:
        <label for="textfield"></label>
        <input type="text" name="contact" id="textfield">
    </p>

    <p>location:
        <label for="textfield"></label>
        <input type="text" name="location" id="textfield">
    </p>

    <p>branch:
        <label for="textfield"></label>
        <input type="text" name="branch" id="textfield">
    </p>
    <p>Grade:
        <label for="textfield"></label>
        <input type="text" name="grade" id="textfield">
    </p>
    <p>Gender:
        <label for="textfield"></label>
        <input type="text" name="gender" id="textfield">
    </p>

    <p>
        <input type="submit" name="user_form" id="button" value="submit">
    </p>
    </form>
    <?php
}
?>