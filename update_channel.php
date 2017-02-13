	  <?php include 'navigationbar.php';?>
		<?php include 'leftSideSlide.php';?>
	
	<!-------------------------------SCRIPT START FROM HERE   --------->	
	/*<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>*/
<script src="angularjs/updateGroup.js"></script>
/*<script src="angularjs/add_field_dynamically.js"></script>*/

	<!-------------------------------SCRIPT END FROM HERE   --------->	
	<div ng-controller="MainCtrl">
              
			   <div  class="side-body padding-top">
				
			<div class="bs-example">
   
	
			<div class="row" style="background-color:#dddddd;margin:1px !important;">
				<div class="col-xs-8 col-sm-8 col-md-9 col-lg-9"style="margin:1px !important;">
				<center><h3>Update Group</h3></center>
				</div>
<div class="col-xs-4 col-sm-4 col-md-2 col-lg-2" ><center><br>
</center>
</div>
			</div>
	<br>
	
	
	
<!------------------------------------------message portal start from here------------------------------------------------>	
 <div class="row">
		<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 col-md-offset-1">
	<!----------------------------------------message  start from here---------------------------------------->	
            <div class="row">
			<form role="form" method="post" action="Link_Library/link_group_update.php" >

	      <input type="hidden" name = "idgroup" value="<?php echo $_GET['groupid']; ?>">
	      <input type="hidden" name = "channel_author" value="<?php echo $_SESSION['user_email']; ?>">
	      <input type="hidden"  name = "id_author" value="<?php echo $_SESSION['client_id']; ?>">
			<input type="hidden"  name = "id_author" ng-model="clientid" ng-init="clientid='<?php echo $_SESSION['client_id']; ?>'" value="<?php echo $_SESSION['client_id']; ?>">
			 <input type="hidden" name = "device" value="d2">	
				
					<div class="col-md-12">
                     <label for="exampleInputPassword1"> Group Admin Id</label>

                       <div >
				   <div data-ng-repeat="choice in choices track by $index">
				 <div class="form-group col-sm-10">  
          <input type="text"  class="form-control" name="admin{{$index}}" ng-model = "choice"  placeholder="Enter Group Admin Email Id">
 </div>
  <div class="form-group col-sm-2">
              <button type="button" class="btn btn-danger btn-small" ng-show="$last" ng-click="removeChoice()"> - </button>
                            {{$length}}
                     </div>       
                  <input type="text" style="display:none;" name="countadmin" ng-model = choices.length> 
				   </div>
				   
				   <button type="button" class="btn btn-success btn-midium" ng-click="addNewChoice()">Add Group Admin</button>
				       
				</div>
                 </div>
                                       
					         <div class="form-group col-sm-6">
                               <label for="exampleInputPassword1">Group Name</label>
                              <input ng-model = "groupName" type="text" name="group_title" class="form-control" id="exampleInputPassword1" placeholder="Group Name">
                            </div>
                                         <div class="form-group col-sm-6">
                                            <label for="exampleInputEmail1">About Group</label>
                                           <textarea ng-model = "groupDescription" cols="10" id="message" name="groupdesc" class="form-control"  rows="2">	
	                                        </textarea>
                                        </div>

                                         <div class="form-group col-sm-12">
                                          <label for="exampleInputEmail1">Select Demography Parameter</label>
                                          <br/>
                                     
					      <div >
					
                             <div ng-repeat = "singleColumnValues in posts">
		                       <div class="col-md-6" style="border:1px solid; border-radius:5px">
			           <p style="font-size:12px;font-weigtht:600">{{singleColumnValues.columnName}}</p>
					<hr />
                                           <input type="text" style="display:none;" name="countvalue" ng-model=posts.length />
                                          
                   <input type="checkbox" ng-model="all" name="group{{$index}}[]" value="{{singleColumnValues.columnName}}|All">  All<br>
                          <div ng-repeat = "distinctValuesWithinColumn in singleColumnValues.distinctValuesWithinColumn  ">
                                                 
                           <input type="checkbox" ng-checked="isCheckedDemographic('{{singleColumnValues.columnName}}', '{{distinctValuesWithinColumn}}') || all" name="group{{$parent.$index}}[]" class="form-group" value="{{singleColumnValues.columnName}}| {{distinctValuesWithinColumn}}">  {{distinctValuesWithinColumn}}
                                                 
                                           </div>
                                           </div>
     
                               </div>
                            </div>
                                        </div>
      <!---------------------this script for show textbox on select radio button---------------------->                        
			
	  <!------------Abobe script for show textbox on select radio button---------------------->
	                              
					<div class="form-group col-sm-12">
						<input type="submit" name ="news_post" class="btn btn-md btn-info" style="text-shadow:none;font-weight:normal;" value="Update Group" id="getData" />
					</div>
					
				</div>
				</form>
			</div>
		<!-----------------------------------message form end from here---------------------------------->		
			
					
		</div>
		
		</div>
					
		
</div>
                   
            </div> </div>
				<?php include 'footer.php';?>