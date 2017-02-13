 var count = 1;
   var allCities = [];
   var selectedItems = [];
   var allTextIds = [];
   var selectedTextIds = []
function  removeItemAndRePopulateDiv(value,theIdValue,theDiv)
{


    var primaryArray = [];
    var secondryArray = [];

    var primaryTextIds = [] ;
    var secondryTextIds = [];
   
    var primaryDiv;
    var secondryDiv;

    var primaryid;
    var secondryid;

    if(theDiv == "#allitems")

    { 
      primaryTextIds  = "allids";
      secondryTextIds = "selectedids";	 

      primaryTextArray  = allTextIds;
      secondryTextArray = selectedTextIds;

      primaryDiv = "#allitems";
      secondryDiv = "#selecteditems";

      primaryArray  = allCities;
      secondryArray = selectedItems;
    }
       

       else
    
       {
	       
      primaryTextIds = "selectedids";
      secondryTextIds = "allids";
      primaryTextArray = selectedTextIds;
      secondryTextArray = allTextIds;

      primaryDiv =  "#selecteditems";
      secondryDiv = "#allitems";
      primaryArray  = selectedItems;
      secondryArray = allCities;
    }
    secondryArray.push(value);
    secondryTextArray.push(theIdValue);

	var index = primaryArray.indexOf(value);
        var index2 = primaryTextArray.indexOf(theIdValue);

       if (index > -1) {    

	       primaryArray.splice(index, 1);
	       

        
       }
	
       if (index2 > -1) {    

	       primaryTextArray.splice(index, 1);
	       

        
    }

    addArrayToDiv(primaryTextArray,primaryTextIds,primaryArray,primaryDiv);
    
    addArrayToDiv(secondryTextArray,secondryTextIds,secondryArray,secondryDiv);



}


function addArrayToDiv(theIdsArray,theId,theArray,theDiv)
{
	$(theDiv).html("");
        $("textarea#" + theId).val ("");

    
var ids = "";
   for(i=0;i<theArray.length;i++)
 { 
       if(theDiv == "#allitems")
{
	$(theDiv).append('<div class="col-xs-12 col-md-12"style="margin-left:10px;">'+' <a href="#selecteditems1" style="text-decoration:none;" onclick="return removeItemAndRePopulateDiv(\'' + theArray[i]  + '\',\'' + theIdsArray[i] + '\',\''  + theDiv + '\')"> <p style="margin:12px 8px 7px;border-bottom:1px dotted gray;"> ' + theArray[i] + ' </p></a> </div><br>');
ids = ids + theIdsArray[i] + ",";
       
 }
else
{     
  $(theDiv).append('<div class="col-xs-12 col-md-12"style="margin-left:10px;">'+'<p id="group" style="margin:0px 8px 7px;border-bottom:1px dotted gray;"> '+theArray[i]+' <a href="#allitems" style="text-decoration:none;" onclick="return removeItemAndRePopulateDiv(\'' + theArray[i]  + '\',\'' + theIdsArray[i] + '\',\''  + theDiv + '\')"> <span class="glyphicon glyphicon-remove-sign"style="font-size:16px;float:right;"></span> </a> '+'</p>'+'</div>' );

ids = ids + theIdsArray[i] + ",";
}
    $("textarea#" + theId).val (ids);





 }
  return theArray;
}


$(document).ready(function(){


               var cat= "sparshgr8@yahoo.com";                  
                $.ajax({
                       type:'POST',
                       url: 'http://admin.benepik.com/employee/virendra/benepik_client/Class_Library/api_get_location.php',
                       data: {
                       username: cat,
                       },
                       dataType: 'jsonp',
                       jsonp: 'mm',
                       jsonpCallback: 'locationCall',
                       success: function(){
                       }
                       });
                });
                
                function locationCall(data){
           
        if(count ==1)
        {    
                    var mesg= JSON.stringify(data);
		    var jsonData= JSON.parse(mesg);
		    var alltext = "";
                     for(i=0;i<jsonData.posts.length;i++)
                    {
			    allCities.push(jsonData.posts[i].location);
			    allTextIds.push(jsonData.posts[i].location);
		            			
		    }
		      

            addArrayToDiv(allTextIds,"allids",allCities,"#allitems");

        count++;    
        }
                    
                }