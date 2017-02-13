<?php 
error_reporting(E_ALL);
ini_set("display_errors",1);
include 'navigationbar.php';
include 'leftSideSlide.php'; 
include('Class_Library/class_welcome_analytic.php');

@session_start();
$cid = $_SESSION['client_id'];
$user_uniqueid = $_SESSION['user_unique_id'];
$user_type = $_SESSION['user_type'];
?>

<div class="container-fluid">

    <div class="side-body padding-top">

        <!----------------------------------------------------->

        <div class="row">
            <!----     <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                     <a href="#">
                         <div class="card red summary-inline divshape2">
                             <div class="card-body">
                                 <i class="icon fa fa-smile-o fa-4x"></i>
                                 <div class="content">
                                     <div class="title">
            <?php
            $obj = new WelcomeAnalytic();
            $result = $obj->happinessScore($cid);
            $res = json_decode($result, true);
            $abs = $res[0]['count'];
//echo $abs;
            echo ceil($abs) . "<br/>";
            ?>
</div>
                                     <div class="sub-title">Happiness Score ( <?php echo date('F-Y'); ?> )</div>
                                 </div>
                                 <div class="clear-both"></div>
                             </div>
                         </div>
                     </a>
                 </div>  ---->
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <a href="#">
                    <div class="card yellow summary-inline divshape2">
                        <div class="card-body">
                            <i class="icon fa fa-comments fa-4x"></i>
                            <div class="content">
                                <div class="title">
                                    <?php
                                    $obj = new WelcomeAnalytic();
                                    $result = $obj->commentScore($cid, $user_uniqueid, $user_type);
                                    $res = json_decode($result, true);
                                    echo $res[0]['count'];
                                    ?>

                                </div>
                                <div class="sub-title">Comments</div>
                            </div>
                            <div class="clear-both"></div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <a href="#">
                    <div class="card blue summary-inline divshape2">
                        <div class="card-body">
                            <i class="icon fa fa-thumbs-up fa-4x"></i>
                            <div class="content">
                                <div class="title">
                                    <?php
                                    $obj = new WelcomeAnalytic();
                                    $result = $obj->likeScore($cid, $user_uniqueid, $user_type);
                                    $res = json_decode($result, true);
                                    echo $res[0]['count'];
                                    ?>
                                </div>
                                <div class="sub-title">Like</div>
                            </div>
                            <div class="clear-both"></div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <a href="#">
                    <div class="card green summary-inline divshape2">
                        <div class="card-body">
                            <i class="icon fa fa-newspaper-o fa-4x"></i>
                            <div class="content">
                                <div class="title">
                                    <?php
                                    $obj = new WelcomeAnalytic();
                                    $result = $obj->totalviewpost($cid, $user_uniqueid, $user_type);
                                    $res = json_decode($result, true);
                                    echo $res[0]['count'];
                                    ?>
                                </div>
                                <div class="sub-title">Post views</div>
                            </div>
                            <div class="clear-both"></div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!----------------------------------------------------->

        <div class="row" >
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="row"  style="border:1px solid #dcdcdc;padding:5px;">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                        <div id="latest_activity">
                            <h5 class="LatestActivitiesHeading"><b>LATEST GROUPS</b></h5>
                            <hr>
                            <?php
                            $obj = new WelcomeAnalytic();
                            $result = $obj->latestChannel($cid);
                            $res = json_decode($result, true);
                            for ($i = 0; $i < count($res); $i++)
                            /* {
                              echo "<div style='border:1px solid #ccc;border-radius:4px;padding:10px;margin-bottom:5px;background:#f5f5f5;'>
                              <button type='button' class='btn btn-success btn-circle btn-lg' style='margin-right:5px'>
                              <i class='fa fa-user'></i></button><p style='font-weight:600'> ".$res[$i]['groupName']."</p><p>".$res[$i]['createdDate']."</p></div>";
                              } */ {
                                echo "<div class='row' style='border:1px solid #ccc;background:#f5f5f0;border-radius:4px;padding:10px 10px 0px 10px;margin-bottom:5px'><div class='col-xs-12 col-sm-3 col-md-2 col-lg-2 MB2'><button type='button' class='btn btn-success btn-circle btn-lg'>
<i class='fa fa-user'></i></button>  </div> <div class='col-xs-12 col-sm-9 col-md-10 col-lg-10 MB2'> <strong><h6  style='font-weight:600;text-transform:uppercase;'> " . $res[$i]['groupName'] . "</h6></strong><p class='mydate'>" . $res[$i]['createdDate'] . "</p>   </div>  </div>";
                            }
                            ?>




                        </div>
                    </div>
                </div>
                <div class="row" style="border:1px solid #dcdcdc;padding:5px;margin-top:20px;">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                        <div id="RecentComment">
                                <!--<p class="LatestActivitiesHeading">Recent Comment</p>-->
                            <h5 class="LatestActivitiesHeading"><b>RECENT COMMENT</b></h5>
                            <hr>
                            <?php
                            $obj = new WelcomeAnalytic();
                            $result = $obj->latestComment($cid, $user_uniqueid, $user_type);
                            $res = json_decode($result, true);

                            for ($i = 0; $i < count($res); $i++) {
                                $value = $res[$i]['comment'];
                                $count = strlen($value);

                                if ($count > 25) {
                                    $string = substr($res[$i]['comment'], 0, 25) . "<b>...</b>";
                                } else {
                                    $string = $res[$i]['comment'];
                                }

                                echo "<div class='row' style='border:1px solid #ccc;background:#f5f5f0;border-radius:4px;padding:10px 10px 0px 10px;margin-bottom:5px'><div class='col-xs-12 col-sm-3 col-md-2 col-lg-2 MB2'><img src='" . $res[$i]['userimage'] . "' class='img' id='user_image' style='margin-right:5px' onerror='this.src = &quot;images/u.png&quot;'> </div> <div class='col-xs-12 col-sm-9 col-md-10 col-lg-10 MB2'><strong><p style='text-transform:capitalize;'>" . $res[$i]['firstName'] . " " . $res[$i]['lastname'] . "</p></strong><p class='mydate'>" . $res[$i]['commentDate'] . "</p> <p style='font-family: sans-serif;'>" . $string . "</p>  </div>  </div>";
                            }
                            ?>



                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                        <div id="RecentComment">
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="row" style="border:1px solid #dcdcdc;padding:5px;margin-left:5px;">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                        <div id="RecentComment">

                            <h5 class="LatestActivitiesHeading"><b>LATEST ADMIN</b></h5>
                            <hr>
                            <?php
                            $obj = new WelcomeAnalytic();
                            $result = $obj->latestUser($cid);
                            $res = json_decode($result);
//                            echo '<pre>';print_r($res);
                            for ($i = 0; $i < count($res); $i++) {
                                echo "<div style='border:1px solid #ccc;background-color:#f5f5f0;border-radius:4px;padding:10px;margin-bottom:5px'><img src=" . $res[$i]->{'userimage'} . " class='img' id='user_image' style='margin-right:5px'  onerror='this.src = &quot;images/u.png&quot;' >" . $res[$i]->{'firstName'} . "  " . $res[$i]->{'lastName'} . "</div>";
                            }
                            ?>


                        </div>
                    </div>
                </div>




            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"><br><br><br>
                <iframe src="MobileView/welcome.html" 
                        style="width:320px; height:568px ;border:1 px solid #000000;position:absolute;">

                </iframe>
                <img src="img/iphone.png"style="width:355px;height:680px;margin-top:-64px;margin-left:-14px;"/>

            </div>

        </div>


    </div>
</div>
<?php include 'footer.php'; ?>