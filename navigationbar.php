<?php
define('SITE', 'http://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']) . '/');

session_start();
if (!isset($_SESSION['user_session']) && $_SESSION['user_session'] == "") {
    echo "<script>window.location='index.php'</script>";
}
?>
<!DOCTYPE html>
<html data-ng-app>

    <!-- Mirrored from tui2tone.github.io/flat-admin-bootstrap-templates/html/ by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 24 Feb 2016 09:29:13 GMT -->
    <!-- Added by HTTrack -->
    <meta http-equiv="content-type" content="text/html;charset=utf-8" /><!-- /Added by HTTrack -->
    <head>
        <link rel="shortcut icon" href="<?php echo SITE; ?>img/launchicon.png" />
        <title>Vikas Group: Welcome </title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:300,400' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900' rel='stylesheet' type='text/css'>
        <!-- CSS Libs -->
        <link rel="stylesheet" type="text/css" href="css/mycss.css">
        <!--this css file is only for testing purpose-->
        <link rel="stylesheet" type="text/css" href="css/NewClient.css">
        <!-- css file of testing purpose is end here-->

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="css/appPreview.css">
        <link rel="stylesheet" type="text/css" href="lib/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="lib/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="lib/css/animate.min.css">
        <link rel="stylesheet" type="text/css" href="lib/css/bootstrap-switch.min.css">
        <link rel="stylesheet" type="text/css" href="lib/css/checkbox3.min.css">
        <link rel="stylesheet" type="text/css" href="lib/css/jquery.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="lib/css/dataTables.bootstrap.css">
        <link rel="stylesheet" type="text/css" href="lib/css/select2.min.css">
        <!-- CSS App -->
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/themes/flat-blue.css">

        <!--Angular plugin-->

        <script data-require="angular.js@1.1.5" data-semver="1.1.5" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.1.5/angular.js">
        </script>

        <!--external link for date picker that will be acceptable for all browser-->

        <!--external link for date picker that will be acceptable for all browser-->
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.js"></script>
        <script type="text/javascript" src="http://afarkas.github.io/webshim/js-webshim/minified/polyfiller.js"></script>
        <script type="text/javascript" src="js/datepicker.js"></script>

        <!--for making toggle button-->

        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    </head>

    <body data-ng-app="" class="flat-blue">
        <div class="app-container">
            <div class="row content-container">

                <nav class="navbar navbar-default navbar-fixed-top navbar-top">
                    <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-expand-toggle">
                                <i class="fa fa-bars icon"></i>
                            </button>
                            <ol class="breadcrumb navbar-breadcrumb">
                                <li class="active"> <?php echo $_SESSION['client_name']; ?></li>
                                <li><span class="text-warning"> <?php
                                        date_default_timezone_set('Asia/Kolkata');
                                        echo date('d M Y, h:i A');
                                        ?><span></li>
                                            </ol>
                                            <button type="button" class="navbar-right-expand-toggle pull-right visible-xs">
                                                <i class="fa fa-th icon"></i>
                                            </button>


                                            </div>

                                            <ul class="nav navbar-nav navbar-right">
                                                <button type="button" class="navbar-right-expand-toggle pull-right visible-xs">
                                                    <i class="fa fa-times icon"></i>
                                                </button>
                                                <!----   <li class="dropdown">
                                                       <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-comments-o"></i></a>
                                                       <ul class="dropdown-menu animated fadeInDown">
                                                           <li class="title">
                                                               Notification <span class="badge pull-right">0</span>
                                                           </li>
                                                           <li class="message">
                                                               No new notification
                                                           </li>
                                                       </ul>
                                                   </li>
                                                   <li class="dropdown danger">
                                                       <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-star-half-o"></i> 4</a>
                                                       <ul class="dropdown-menu danger  animated fadeInDown">
                                                           <li class="title">
                                                               Notification <span class="badge pull-right">4</span>
                                                           </li>
                                                           <li>
                                                               <ul class="list-group notifications">
                                                                   <a href="#">
                                                                       <li class="list-group-item">
                                                                           <span class="badge">1</span> <i class="fa fa-exclamation-circle icon"></i> new registration
                                                                       </li>
                                                                   </a>
                                                                   <a href="#">
                                                                       <li class="list-group-item">
                                                                           <span class="badge success">1</span> <i class="fa fa-check icon"></i> new orders
                                                                       </li>
                                                                   </a>
                                                                   <a href="#">
                                                                       <li class="list-group-item">
                                                                           <span class="badge danger">2</span> <i class="fa fa-comments icon"></i> customers messages
                                                                       </li>
                                                                   </a>
                                                                   <a href="#">
                                                                       <li class="list-group-item message">
                                                                           view all
                                                                       </li>
                                                                   </a>
                                                               </ul>
                                                           </li>
                                                       </ul>
                                                   </li> --->
                                                <li class="dropdown profile">
                                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><?php echo $_SESSION['user_name'] ?> <span class="caret"></span></a>
                                                    <ul class="dropdown-menu animated fadeInDown">
                                                        <li class="profile-img">
                                                            <?php
//                                $path = "http://admin.benepik.com/employee/virendra/benepik_admin/";
                                                            $path = SITE;
                                                            $name = $_SESSION['image_name'];
                                                            if ($name == "") {
                                                                $fullpath = $path . "images/usericon.png";
                                                            } else {
                                                                $fullpath = $path . $name;
                                                            }
                                                            ?>
                                                            <img src="<?php echo $fullpath; ?>" class="profile-img" onerror='this.src="images/usericon.png"'>
                                                        </li>
                                                        <li>
                                                            <div class="profile-info">
                                                                <h4 class="username"><?php echo $_SESSION['user_name'] ?></h4>
                                                                <p><?php echo $_SESSION['user_email']; ?></p>
                                                                <div class="btn-group margin-bottom-2x" role="group">
                                                                <!--<a href="profile.php">    <button type="button" class="btn btn-default"><i class="fa fa-user"></i> Profile</button></a>--->
                                                                    <a href="logout.php">  <button type="button" class="btn btn-default"><i class="fa fa-sign-out"></i> Logout</button></a>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                            </div>
                                            </nav>

