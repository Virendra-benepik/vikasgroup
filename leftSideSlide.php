<?php
@session_start();
?>
<div class="side-menu sidebar-inverse">
    <nav class="navbar navbar-default" role="navigation">
        <div class="side-menu-container">
            <div class="navbar-header">
                <a class="navbar-brand" href="welcome.php">
                    <div><img src="img/index_vikas.png" width="81px"></div>
                  <!--  <div class="title">Benepik <sub> employee app </sub></div> -->
                </a>
                <button type="button" class="navbar-expand-toggle pull-right visible-xs">
                    <i class="fa fa-times icon"></i>
                </button>
            </div>      
            <?php
            if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == "SubAdmin") {
                //  echo $_SESSION['user_type'];
                ?>
                <ul class="nav navbar-nav">
                    <li>
                        <a href="welcome.php">
                            <span class="icon fa fa-tachometer"></span><span class="title">Dashboard</span>
                        </a>
                    </li>

                    <!--Contact-->
                    <li>
                        <a href="view_contact_directory.php">
                            <span class="icon fa fa-phone"></span><span class="title">Contact List</span>
                        </a>						
                    </li>

                    <!-- add user -->		

                    <li class="panel panel-default dropdown ">
                        <a data-toggle="collapse" href="#user">
                            <span class="icon fa fa-users"></span><span class="title">User</span>
                        </a>

                        <div id="user" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav navbar-nav">

                                    <li><a href="add_user.php"><span class="icon fa fa-user"></span> Add User</a>
                                    </li>
                                    <li><a href="add_guestuser.php"><span class="icon fa fa-user"></span> Add Guest User</a>
                                    </li>
                                    <li><a href="update_user.php"><span class="icon fa fa-envelope-o"></span> Update User</a>
                                    </li>
                                    <li><a href="network.php"><span class="icon fa fa-users"></span> Directory</a>
                                    </li>



                                </ul>
                            </div>
                        </div>
                    </li>

                    <!-- create post -->	

                    <li class="panel panel-default dropdown ">
                        <a data-toggle="collapse" href="#dropdown-element">
                            <span class="icon fa fa-desktop"></span><span class="title">Create Posts</span>
                        </a>
                        <!-- Dropdown level 1 -->
                        <div id="dropdown-element" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav navbar-nav">

                                    <li><a href="postnews.php"><span class="icon fa fa-newspaper-o"></span> What's up</a>
                                    </li>
                                    <li><a href="postmessage.php"><span class="icon fa fa-envelope-o"></span> Message</a>
                                    </li>
                                    <li><a href="postpicture.php"><span class="icon fa fa-picture-o"></span> Picture</a>
                                    </li>
                                    <li><a href="create_ceo_message.php"><span class="icon fa fa-newspaper-o" aria-hidden="true"></span>Leadership Connect</a>
                                    </li>

                                    <li><a href="multipleImageUpload.php"><span class="icon fa fa-cloud-upload" aria-hidden="true"></span>Gallery</a>
                                    </li>

                                    <li><a href="create_onboard.php"><span class="icon fa fa-newspaper-o" aria-hidden="true"></span>Welcome Aboard</a>

                                    <li><a href="create_event.php"><span class="icon fa fa-newspaper-o"></span> Event Calendar</a>
                                    </li>



                                </ul>
                            </div>
                        </div>
                    </li>

                    <!-- view post -->	

                    <li class="panel panel-default dropdown">
                        <a data-toggle="collapse" href="#ViewPost">
                            <span class="icon fa fa-file-text-o"></span><span class="title">View Post </span>
                        </a>
                        <!-- Dropdown level 1 -->
                        <div id="ViewPost" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav navbar-nav">
                                    <li><a href="view_news.php"><span class="icon fa fa-newspaper-o"></span>View What's up</a>
                                    </li>
                                    <li><a href="view_picture.php"><span class="icon fa fa-picture-o"></span> View Picture</a></li>
                                    <li><a href="view_message.php"><span class="icon fa fa-envelope-o"></span> View Message</a></li> 

                                    <li><a href="view_album.php"><span class="icon fa fa-picture-o" aria-hidden="true"></span> View Gallery
                                        </a></li>

                                    <li><a href="view_event.php"><span class="icon fa fa-newspaper-o "></span>View Event</a>
                                    </li>
                                    <li><a href="view_ceo_message.php"><span class="icon fa fa-newspaper-o" aria-hidden="true"></span>View Leadership Connect
                                        </a></li>          
                                    <li><a href="view_welcome_onboard.php"><span class="icon fa fa-newspaper-o" aria-hidden="true"></span> View Welcome Aboard</a></li>          

                                </ul>

                            </div>
                        </div>
                    </li>

                    <!-- hr policy -->	
                    <!--                    <li class="panel panel-default dropdown">
                                            <a data-toggle="collapse" href="#pages">
                                                <span class="icon fa fa-thumb-tack" aria-hidden="true"></span><span class="title">HR Policy</span>
                                            </a>
                    
                                            <div id="pages" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <ul class="nav navbar-nav">
                                                        <li><a href="addpage.php"><span class="glyphicon glyphicon-plus"></span> Add HR Policy</a>
                                                        </li>
                                                        <li><a href="view_page.php"><span class="glyphicon glyphicon-file"></span> View HR Policy</a>
                                                        </li>
                    
                                                    </ul>
                                                </div>
                                            </div>
                                        </li> -->

                    <!-- notice board -->	
                    <li class="panel panel-default dropdown">
                        <a data-toggle="collapse" href="#notice">
                            <span class=" icon fa fa-bullhorn"></span><span class="title"> Notice Board</span>
                        </a>
                        <!-- Dropdown level 1 -->
                        <div id="notice" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav navbar-nav">
                                    <li><a href="create_notice.php"><span class="glyphicon glyphicon-plus"></span> Add Notice</a>
                                    </li>
                                    <li><a href="view_Notice.php"><span class="glyphicon glyphicon-pushpin"></span> View Notice</a>
                                    </li>


                                </ul>
                            </div>
                        </div>
                    </li>	

                    <!-- employee happiness -->	           
                    <li class="panel panel-default dropdown">
                        <a data-toggle="collapse" href="#happiness">
                            <span class="icon fa fa-smile-o" aria-hidden="true"></span><span class="title"> Employee Satisfaction Survey</span>
                        </a>  

                        <div id="happiness" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav navbar-nav">

                                    <li><a href="createHappinessQuestion.php"><span class="glyphicon glyphicon-plus"></span> Create Satisfaction Survey</a>
                                    </li>
                                    <li><a href="view_survey.php"><span class="glyphicon glyphicon-plus"></span> View Survey </a>
                                    </li>
<!--                                    <li>
                                        <a href="backup_emp_happiness.php?clientid=<?php echo $_SESSION['client_id']; ?>">
                                            <span class="glyphicon glyphicon-plus"></span><span class="title"> View Survey Analytic</span>
                                        </a>						
                                    </li>-->

                                </ul>
                            </div>
                        </div>
                    </li>
                    <!-- login analytic -->	             
                    <li class="panel panel-default dropdown">
                        <a data-toggle="collapse" href="#analyticlogin">
                            <span class="icon fa fa-user" aria-hidden="true"></span><span class="title">Analytic</span>
                        </a>

                        <div id="analyticlogin" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav navbar-nav">

                                    <li><a href="analytic_login.php"><span class="glyphicon glyphicon-plus"></span> Add Analytic</a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </li>
                    <li class="panel panel-default dropdown">
                        <a data-toggle="collapse" href="#thought">
                            <span class="icon fa fa-hourglass-half" aria-hidden="true"></span><span class="title"> Thought of the Day</span>
                        </a>  

                        <div id="thought" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav navbar-nav">

                                    <li><a href="todays_thought.php"><span class="glyphicon glyphicon-plus"></span> Create Thought</a>
                                    </li>
                                    <li><a href="view_thought.php"><span class="glyphicon glyphicon-plus"></span> View Previous Thought</a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </li>

                </ul>
                <?php
            } else {
                ?>
                <ul class="nav navbar-nav">
                    <li>
                        <a href="welcome.php">
                            <span class="icon fa fa-tachometer"></span><span class="title">Dashboard</span>
                        </a>
                    </li>

                    <!--Contact-->
                    <li>
                        <a href="view_contact_directory.php">
                            <span class="icon fa fa-phone"></span><span class="title">Contact List</span>
                        </a>						
                    </li>
                    <!-- add user -->		

                    <li class="panel panel-default dropdown ">
                        <a data-toggle="collapse" href="#user">
                            <span class="icon fa fa-users"></span><span class="title">User</span>
                        </a>

                        <div id="user" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav navbar-nav">

                                    <li><a href="add_user.php"><span class="icon fa fa-user"></span> Add User</a>
                                    </li>
                                    <li><a href="add_guestuser.php"><span class="icon fa fa-user"></span> Add Guest User</a>
                                    </li>
                                    <li><a href="update_user.php"><span class="icon fa fa-envelope-o"></span> Update User</a>
                                    </li>
                                    <li><a href="network.php"><span class="icon fa fa-users"></span> Directory</a>
                                    </li>



                                </ul>
                            </div>
                        </div>
                    </li>

                    <!-- create post -->	

                    <li class="panel panel-default dropdown ">
                        <a data-toggle="collapse" href="#dropdown-element">
                            <span class="icon fa fa-desktop"></span><span class="title">Create Posts</span>
                        </a>
                        <!-- Dropdown level 1 -->
                        <div id="dropdown-element" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav navbar-nav">

                                    <li><a href="postnews.php"><span class="icon fa fa-newspaper-o"></span> What's up</a>
                                    </li>
                                    <li><a href="postmessage.php"><span class="icon fa fa-envelope-o"></span> Message</a>
                                    </li>
                                    <li><a href="postpicture.php"><span class="icon fa fa-picture-o"></span> Picture</a>
                                    </li>
                                    <li><a href="create_ceo_message.php"><span class="icon fa fa-newspaper-o" aria-hidden="true"></span>Leadership Connect</a>
                                    </li>

                                    <li><a href="multipleImageUpload.php"><span class="icon fa fa-cloud-upload" aria-hidden="true"></span>Gallery</a>
                                    </li>

                                    <li><a href="create_onboard.php"><span class="icon fa fa-newspaper-o" aria-hidden="true"></span>Welcome Aboard</a>

                                    <li><a href="create_event.php"><span class="icon fa fa-newspaper-o"></span> Event Calendar</a>
                                    </li>



                                </ul>
                            </div>
                        </div>
                    </li>

                    <!-- view post -->	

                    <li class="panel panel-default dropdown">
                        <a data-toggle="collapse" href="#ViewPost">
                            <span class="icon fa fa-file-text-o"></span><span class="title">View Post </span>
                        </a>
                        <!-- Dropdown level 1 -->
                        <div id="ViewPost" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav navbar-nav">
                                    <li><a href="view_news.php"><span class="icon fa fa-newspaper-o"></span>View What's up</a>
                                    </li>
                                    <li><a href="view_picture.php"><span class="icon fa fa-picture-o"></span> View Picture</a></li>
                                    <li><a href="view_message.php"><span class="icon fa fa-envelope-o"></span> View Message</a></li> 

                                    <li><a href="view_album.php"><span class="icon fa fa-picture-o" aria-hidden="true"></span> View Gallery
                                        </a></li>

                                    <li><a href="view_event.php"><span class="icon fa fa-newspaper-o "></span>View Event</a>
                                    </li>
                                    <li><a href="view_ceo_message.php"><span class="icon fa fa-newspaper-o" aria-hidden="true"></span>View Leadership Connect
                                        </a></li>          
                                    <li><a href="view_welcome_onboard.php"><span class="icon fa fa-newspaper-o" aria-hidden="true"></span> View Welcome Aboard</a></li>          

                                </ul>

                            </div>
                        </div>
                    </li>

                    <!-- hr policy -->	
                    <!--                    <li class="panel panel-default dropdown">
                                            <a data-toggle="collapse" href="#pages">
                                                <span class="icon fa fa-thumb-tack" aria-hidden="true"></span><span class="title">HR Policy</span>
                                            </a>
                    
                                            <div id="pages" class="panel-collapse collapse">
                                                <div class="panel-body">
                                                    <ul class="nav navbar-nav">
                                                        <li><a href="addpage.php"><span class="glyphicon glyphicon-plus"></span> Add HR Policy</a>
                                                        </li>
                                                        <li><a href="view_page.php"><span class="glyphicon glyphicon-file"></span> View HR Policy</a>
                                                        </li>
                    
                                                    </ul>
                                                </div>
                                            </div>
                                        </li> -->

                    <!-- notice board -->	
                    <li class="panel panel-default dropdown">
                        <a data-toggle="collapse" href="#notice">
                            <span class=" icon fa fa-bullhorn"></span><span class="title"> Notice Board</span>
                        </a>
                        <!-- Dropdown level 1 -->
                        <div id="notice" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav navbar-nav">
                                    <li><a href="create_notice.php"><span class="glyphicon glyphicon-plus"></span> Add Notice</a>
                                    </li>
                                    <li><a href="view_Notice.php"><span class="glyphicon glyphicon-pushpin"></span> View Notice</a>
                                    </li>


                                </ul>
                            </div>
                        </div>
                    </li>

                    <!-- group creating -->	

                    <li class="panel panel-default dropdown">
                        <a data-toggle="collapse" href="#group1">
                            <span class="icon fa fa-users"></span><span class="title"> Group</span>
                        </a>

                        <div id="group1" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav navbar-nav">

                                    <li><a href="addchannel.php?clientid=<?php echo $_SESSION['client_id']; ?>"><span class="glyphicon glyphicon-plus"></span> Create Group</a>
                                    </li>
                                    <li><a href="viewchannel.php"><span class="glyphicon glyphicon-plus"></span> View Group</a>
                                    </li>
                                    <!-- <li><a href="index.html">Landing Page</a>
                                     </li>-->
                                </ul>
                            </div>
                        </div>
                    </li>

                    <!-- employee happiness -->	           
                    <li class="panel panel-default dropdown">
                        <a data-toggle="collapse" href="#happiness">
                            <span class="icon fa fa-smile-o" aria-hidden="true"></span><span class="title"> Employee Satisfaction Survey</span>
                        </a>  

                        <div id="happiness" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav navbar-nav">

                                    <li><a href="createHappinessQuestion.php"><span class="glyphicon glyphicon-plus"></span> Create Satisfaction Survey</a>
                                    </li>
                                    <li><a href="view_survey.php"><span class="glyphicon glyphicon-plus"></span> View Survey </a>
                                    </li>
<!--                                    <li>
                                        <a href="backup_emp_happiness.php?clientid=<?php echo $_SESSION['client_id']; ?>">
                                            <span class="glyphicon glyphicon-plus"></span><span class="title"> View Survey Analytic</span>
                                        </a>						
                                    </li>-->

                                </ul>
                            </div>
                        </div>
                    </li>
                    <!-- login analytic -->	             
                    <li class="panel panel-default dropdown">
                        <a data-toggle="collapse" href="#analyticlogin">
                            <span class="icon fa fa-user" aria-hidden="true"></span><span class="title">Analytic</span>
                        </a>

                        <div id="analyticlogin" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav navbar-nav">

                                    <li><a href="analytic_login.php"><span class="glyphicon glyphicon-plus"></span> Add Analytic</a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </li>


                    <li class="panel panel-default dropdown">
                        <a data-toggle="collapse" href="#thought">
                            <span class="icon fa fa-hourglass-half" aria-hidden="true"></span><span class="title"> Thought of the Day</span>
                        </a>  

                        <div id="thought" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav navbar-nav">

                                    <li><a href="todays_thought.php"><span class="glyphicon glyphicon-plus"></span> Create Thought</a>
                                    </li>
                                    <li><a href="view_thought.php"><span class="glyphicon glyphicon-plus"></span> View Previous Thought</a>
                                    </li>

                                </ul>
                            </div>
                        </div>
                    </li>  
                    
                    <li class="panel panel-default dropdown">
                        <a data-toggle="collapse" href="#suggest">
                            <span class="icon fa fa-tree" aria-hidden="true"></span><span class="title">Suggestion & Grievance</span>
                        </a>

                        <div id="suggest" class="panel-collapse collapse">
                            <div class="panel-body">
                                <ul class="nav navbar-nav">

                                    <li>
                                        <a href="suggestion_box.php">
                                            <span class="icon fa fa-envelope"></span> Suggestion Box
                                        </a>
                                    </li> 
                                    <li>
                                        <a href="complain_box.php">
                                            <span class="icon fa fa-inbox"></span> Grievance
                                        </a>
                                    </li> 
                                    <!-- <li><a href="index.html">Landing Page</a>
                                     </li>-->
                                </ul>
                            </div>
                        </div>
                    </li>

                </ul>
                <?php
            }
            ?>
        </div>
        <!-- /.navbar-collapse -->
    </nav>
</div>

<!-- *********************************************************Modal for add chanel************************* -->