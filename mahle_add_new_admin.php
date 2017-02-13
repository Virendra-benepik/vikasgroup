<?php include 'navigationbar.php';?>
<?php include 'leftSideSlide.php';?>
                    <div class="container-fluid">
                <div class="side-body padding-top">
                <?php
                if(isset($_SESSION['msg']))
                {
                
                echo  "<div class='alert alert-success' role='alert'>"." <strong>Well !</strong>".$_SESSION['msg']
                                               ."</div>";
                 }
                ?>                               
                </div>
                
                <div class="row">
                    <div class="col-xs-10 col-sm-offset-1">
                         <div class="card">
                                <div class="card-header">
                                    <div class="card-title">
                                        <div class="title">Add New Admin Details</div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="step">
                                        <ul class="nav nav-tabs nav-justified" role="tablist">                                            

                                        <div class="">
                                            
                                            <div role="tabpanel" class="tab-pane " id="step2" aria-labelledby="">
                                               
                                    <form method="post" action="Link_Library/link_add_admin_user.php">
 					
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputPassword1">Employee Code<span style="color:red">*</span></label>
                                            <input type="text" name="emp_code"  required class="form-control" id="exampleInputPassword1" placeholder="Enter Employee Code">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputPassword1">User Unique Id<span style="color:red">*</span></label>
                                            <input type="text" name="emp_uniq_Id"  required class="form-control" id="emp_uniq_Id" placeholder="Enter Employee Unique Id">
                                        </div>
                                    </div>
                                    <div class="row">  
                                        <div class="form-group col-sm-6">
                                            <label for="exampleInputEmail1">Accessibility</label>
                                            <select name="accessibility" >
                                            	<option value="">Select Accessibility</option>
                                                <option value="Admin">Admin</option>
                                                <option value="SubAdmin">SubAdmin</option>
                                            </select>
                                        </div>
                                    </div> 
                                    
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                     <center>   <button type="submit" name="user_form" class="btn btn-success commonColorSubmitBtn">Submit</button></center> 
				   </div>
				   </div>
                                    </form>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                
                
      <?php
      unset($_SESSION['msg']);
      ?>          
                
                
            </div>
<?php include 'footer.php';?>