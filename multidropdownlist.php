<html>
<head>
<title>Made By DEEPAK</title>
 <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script>

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="js/cookie.js"></script>
<script>
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

    if(theDiv == ".allitems")

    { 
      primaryTextIds  = "allids";
      secondryTextIds = "selectedids";	 

      primaryTextArray  = allTextIds;
      secondryTextArray = selectedTextIds;

      primaryDiv = ".allitems";
      secondryDiv = ".selecteditems";

      primaryArray  = allCities;
      secondryArray = selectedItems;
    }
       

       else
    
       {
	       
      primaryTextIds = "selectedids";
      secondryTextIds = "allids";
      primaryTextArray = selectedTextIds;
      secondryTextArray = allTextIds;

      primaryDiv =  ".selecteditems";
      secondryDiv = ".allitems";
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
       if(theDiv == ".allitems")
{
	$(theDiv).append(' <a href=# styl e="text-decoration:none;" onclick="return removeItemAndRePopulateDiv(\'' + theArray[i]  + '\',\'' + theIdsArray[i] + '\',\''  + theDiv + '\')"> ' + theArray[i] + ' </a> <br><br>');
ids = ids + theIdsArray[i] + ",";
       
 }
else
{     
  $(theDiv).append('<div class="col-xs-3 col-md-2"style="border:1px solid #000000;margin-left:200px;">'+'<p style="margin:6px 0 10px;"> '+theArray[i]+'<sup>'+' <a href=# style="text-decoration:none;" onclick="return removeItemAndRePopulateDiv(\'' + theArray[i]  + '\',\'' + theIdsArray[i] + '\',\''  + theDiv + '\')"> X </a> '+'</sup>'+'</p>'+'</div>'+'<br><br>' );

ids = ids + theIdsArray[i] + ",";
}
    $("textarea#" + theId).val (ids);





 }
  return theArray;
}


$(document).ready(function(){


$("#location").click(function(){  

                var cat= "sparshgr8@yahoo.com";                  
                $.ajax({
                       type:'POST',
                       url: 'http://admin.benepik.com/employee/virendra/benepik_client/Class_Library/api_getuser.php',
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
});
                
                function locationCall(data){
           
        if(count ==1)
        {    
                    var mesg= JSON.stringify(data);
		    var jsonData= JSON.parse(mesg);
		    var alltext = "";
                     for(i=0;i<jsonData.posts.length;i++)
                    {
			    allCities.push(jsonData.posts[i].firstName+" "+jsonData.posts[i].lastName);
			    allTextIds.push(jsonData.posts[i].userId);
		            			
		    }
		      

            addArrayToDiv(allTextIds,"allids",allCities,".allitems");

        count++;    
        }
                    
                }
</script>

<style>
sup{color:red;margin-left:5px;}
sup a{color:red;font-weight:bold;}
</style>

</head>
<body>
<br>
<div id="result"style="background-color:pink;"></div><br><br>
  <input type="text" name="location" id="location" />
<div class="allitems" style="
height: auto;
  border: 1px solid;
  width: 170px;
  text-align: center;

"></div>
<center>
<p class="selecteditems"></p></center>
<textarea id ="allids" height="660"></textarea>
<textarea id ="selectedids"></textarea>
</body>
</html>
