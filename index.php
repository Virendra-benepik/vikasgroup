<?php
require_once('check_login_status.php');
$obj = new Auth();

//$obj->check_session();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Vikas Group :- Login</title>
        <link rel="shortcut icon" href="img/launchicon.png" />
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <style type="text/css">
            html, body{overflow-x:hidden;}
            body{background-color:#cde7c0 ;}
            .bg {
                width: 100%;

                position: absolute;
                top: 0;
                left: 0;
                z-index: -5000;
            }
            .loginDiv{width:100%;margin-top:250px;margin-left:2%}
            .loginText{font-weight:bold;color:#203f7c;font-size:14px;}
        </style>

    </head>
    <body>

        <?php
        if (isset($_GET['email'])) {
            $val = base64_decode($_GET['email']);
        } else {
            $val = '';
        }
        ?>

        <div align="center"><img src="img/vikasbg.jpg" class="bg img img-responsive"></div>
        <div class="container-fluid">
            <div class="loginDiv">
                <div class="row">
                    <div class="col-xs-4 col-sm-4 col-md-3 col-lg-3">

                        <form role="form"  action="Link_Library/link_client_login.php"  method="post">
                            <div class="form-group">
                                <input type="text"  name="email" class="form-control radiuse" placeholder="E-Mail OR Employee Code" value="<?php echo $val; ?>" required >
                            </div>
                            <div class="form-group">
                                <input type="password"  name="password" class="form-control" placeholder="Password" required>
                            </div><br>
                            <div class="row">
                                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8"><a href="#"data-toggle="modal" data-target="#myModalRegistration"><p class="btn btn-default" style="font-size:11px; color: #203f7c;"><b>FORGOT PASSWORD ?</b></p></a></div>
								<!--style="color:#fff;font-weight:500;"-->
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"><input type="submit" class="btn btn-default loginText" name="client_login" value ="LOGIN"></button></div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-9 col-lg-9s"></div>

            </div>
            <p style="color:#fff;font-weight:500;position:absolute;z-index:10;bottom:0px;">&copy; All Rights Reserved @ Benepik Pvt. Ltd. Gurgaon, India  </p>

        </div>
        <!-- Modal registration -->
        <div id="myModalRegistration" class="modal fade" role="dialog">
            <div class="modal-dialog model-sm">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><center>Forgot password</center></h4>
                    </div>
                    <div class="modal-body">

                        <form role="form" action="Link_Library/link_forget_password.php" method="post">
                            <br>
                            <div class="form-group">
                                <input type="text" class="form-control" required="required" name="emailid" placeholder="Enter Your E-Mail Id">
                            </div>
                            <center><input type="submit" class="btn btn-primary" name="forgetpassword" value="Submit" /></center><br>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </body>
</html>

