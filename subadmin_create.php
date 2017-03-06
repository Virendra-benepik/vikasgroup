<?php
    include 'navigationbar.php';
    include 'leftSideSlide.php';
?>

<!-------------------------------SCRIPT START FROM HERE   --------->	
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/display_group.js"></script>

<link rel="stylesheet" type="text/css" href="css/post_news.css">
<script>
    function check() {
        if (confirm('Are You Sure, You want to publish this post?')) {
            return true;
        } else {
            return false;
        }
    }
</script>

<script>
function Validatesubadmin()
{
    var companyname = document.form1.companyname;
    var empcode = document.form1.empcode;
    
    if (companyname.value == "")
    {
        window.alert("Please enter company name.");
        companyname.focus();
        return false;
    }
	if (empcode.value == "")
    {
        window.alert("Please enter employee code.");
        empcode.focus();
        return false;
    }
    return true;
}
</script>

<!-------------------------------SCRIPT END FROM HERE   --------->

<div class="side-body padding-top" >
    <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;">

        <div class="bs-example">

            <div class="row " >
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h3><strong>Create Subadmin </strong></h3><hr>
                </div>
            </div>

            <div class="row">

                <!---------------------------------long news from start here--------------------------------->	

                <form name="form1" role="form" action="Link_Library/link_createSubadmin.php" method="post" enctype="multipart/form-data" onsubmit="return check();">	
                    <input type="hidden" name = "useruniqueid" value="<?php echo $_SESSION['user_unique_id']; ?>">
                    
                    <div ng-app="" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group"  style="margin-left:14px;">
                                    <label for="TITLE">Company Name</label>
                                    <input style="width:98%;" type="text" name="companyname" id="companyname" class="form-control" placeholder="Enter Company name" />
                                </div>
                            </div>
                        </div>

                         <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group"  style="margin-left:14px;">
                                    <label for="TITLE">Employee Code</label>
                                    <input style="width:98%;" type="text" name="empcode" id="empcode" class="form-control" placeholder="Enter Employee Code" />
                                </div>
                            </div>
                        </div>                        
                    </div>

                   
                    <center><div class="form-group col-md-12">	
                            <input type="submit" name="createsubadmin"  class="btn btn-md btn-info news_postBtn" style="text-shadow:none;font-weight:normal;" value="Submit" onclick= "return Validatesubadmin();" required/>
                            </a>
                        </div>
                    </center>

                </form> 
            </div>

        </div>
        <!--this script is use for tooltip genrate-->     
        <script>
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    </div>

    <!--tooltip script end here-->  
</div>
    <?php include 'footer.php'; ?>
	