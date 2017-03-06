	  <?php include 'navigationbar.php';?>
		<?php include 'leftSideSlide.php';?>
	
	<!-------------------------------SCRIPT START FROM HERE   --------->	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="angularjs/updateGroup.js"></script>


	<!-------------------------------SCRIPT END FROM HERE   --------->	
	<div ng-controller="MainCtrl">
              
			   <div  class="side-body padding-top">
				  <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;">
			<div class="bs-example">
   
	
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h3>Create Group</h3><hr>
				</div>

			</div>
	
<!------------------------------------------message portal start from here------------------------------------------------>	
 <div class="row">
		<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-md-offset-1">
	<!----------------------------------------message  start from here---------------------------------------->	
            <div class="row">
			<form role="form" method="post" action="Link_Library/link_group.php" >

	      <input type="hidden" name = "idgroup" value="<?php echo $_GET['groupid']; ?>">
	      <input type="hidden" name = "channel_author" value="<?php echo $_SESSION['user_unique_id']; ?>">
	      <input type="hidden"  name = "id_author" value="<?php echo $_SESSION['client_id']; ?>">
			<input type="hidden"  name = "id_author" ng-model="clientid" ng-init="clientid='<?php echo $_SESSION['client_id']; ?>'" value="<?php echo $_SESSION['client_id']; ?>">
			 <input type="hidden" name = "device" value="d2">	
				
				<!---	<div class="col-md-12">
                     <label for="exampleInputPassword1"> Group Admin Id</label>

                       <div >
                       <input type="text" style="display:none;"  name="countadmin" ng-model = choices.length />
				   <div data-ng-repeat="choice in choices">
				 <div class="form-group col-sm-10">  
          <input type="text" required class="form-control" name="admin{{$index}}" ng-model = "choice.name"  placeholder="Enter Group Admin Employee Id">
 </div>
  <div class="form-group col-sm-2">
              <button type="button" class="btn btn-danger btn-small" ng-show="$last" ng-click="removeChoice()"> - </button>
                            {{$length}}
                     </div>       
                   
				   </div>
				   
				   <button type="button" class="btn btn-success btn-midium" ng-click="addNewChoice()">Create Group Admin</button>
				       
				</div>
                 </div> ---->
                                       
					         <div class="form-group col-sm-6">
                               <label for="exampleInputPassword1">Group Name</label>
                              <input ng-model = "groupName" type="text" name="group_title" class="form-control" id="exampleInputPassword1" placeholder="Group Name" required>
                            </div>
                                         <div class="form-group col-sm-6">
                                            <label for="exampleInputEmail1">About Group</label>
                                           <textarea ng-model = "groupDescription" cols="10" id="message" name="groupdesc" class="form-control"  rows="2" required>	
	                                        </textarea>
                                        </div>

                                         <div class="form-group col-sm-12">
                                          <label for="exampleInputEmail1">Select Demography Parameter</label>
                                          <br/>
                                     
					      <div >
					
                             <div ng-repeat = "singleColumnValues in posts">
		                       <div class="col-md-6" >
<div style="border:1px solid #dcdcdc;padding:8px;">
			           <p style="font-size:12px;font-weigtht:bold;text-transform:capitalize;">{{singleColumnValues.columnName}}</p>
					<hr />
                                           <input type="text" style="display:none;" name="countvalue" ng-model=posts.length />
                                          
                   <input type="checkbox" ng-model="all" name="group{{$index}}[]" value="{{singleColumnValues.columnName}}|All">  All<br>
                          <div ng-repeat = "distinctValuesWithinColumn in singleColumnValues.distinctValuesWithinColumn  ">
                                                 
                           <input type="checkbox" ng-checked="isCheckedDemographic('{{singleColumnValues.columnName}}', '{{distinctValuesWithinColumn}}') || all" name="group{{$parent.$index}}[]" class="form-group" value="{{singleColumnValues.columnName}}| {{distinctValuesWithinColumn}}">  {{distinctValuesWithinColumn}}
                                                 
                                           </div></div>
                                           </div>
     
                               </div>
                            </div>
                                        </div>
      <!---------------------this script for show text box on select radio button---------------------->                        
			<div class="col-md-12">
                     <label for="exampleInputPassword1"> Group Admin Id (Company Admin Employee Id)</label>

                       <div >
                       <input type="text" style="display:none;"  name="countadmin" ng-model = choices.length />
				   <div data-ng-repeat="choice in choices">
				 <div class="form-group col-sm-10">  
          <input type="text" required class="form-control" name="admin{{$index}}" ng-model = "choice.name"  placeholder="Enter Group Admin Employee Id">
 </div>
  <div class="form-group col-sm-2">
              <button type="button" class="btn btn-danger btn-small" ng-show="$last" ng-click="removeChoice()"> - </button>
                            {{$length}}
                     </div>       
                   
				   </div>
				   
				   <button type="button" class="btn btn-success btn-xs" ng-click="addNewChoice()">Create Group Admin</button>
				       
				</div>
                 </div>
	  <!------------Adobe script for show text box on select radio button---------------------->
	                              
					<div class="form-group col-sm-12">
                                            <center><input type="submit" name ="news_post" class="btn btn-md btn-info" style="text-shadow:none;font-weight:normal;" value="Create Group" id="getData" /></center>
					</div>
					
				
            </form>
            </div>
				
			</div>
		<!-----------------------------------message form end from here---------------------------------->		
			
					
		</div>
		
		</div>
					
		
</div>
                   
            </div> </div>
<?php include 'footer.php';?>