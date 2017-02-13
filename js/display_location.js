$(document).ready(function(){ 
  n = 0;


$("#giveValues").click(function(){

// alert(n);
 var j=0;
   var allTheGroupIds = "";
 for(j=0;j<n;j++)
 { 
   //alert(j);
 //  alert(document.getElementById("mycheck"+j).value);

if(document.getElementById("mycheck"+j).checked)
{
 //  alert(document.getElementById("mycheck"+j).value);
   allTheGroupIds = allTheGroupIds + document.getElementById("mycheck"+j).value + ",";
}

 }

$("textarea#selectedids").val (allTheGroupIds);

});




               var cat= "sparshgr8@yahoo.com";                  
               $.ajax({
                      type:'POST',
                      url: 'http://thomasinternational.benepik.com/webservices/applicationv2/groupsPortal.php',
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
          
        
                   var mesg= JSON.stringify(data);
                   var jsonData= JSON.parse(mesg);
                
                    for(i=0;i<jsonData.posts[0].offers.length;i++)
                   {
                     
                     $("#everything").append('<div class="row"><div id="headings" class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><b> ' + jsonData.posts[0].offers[i].heading + ':-</b><hr style="margin:0px; border:1px solid #333333  ;"></div></div>');
               for(j=0;j<jsonData.posts[0].offers[i].groups.length;j++)
                   {
                     
                 $("#everything").append('<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><div class="form-group"><label ><input id=mycheck'+n+' type="checkbox" value='+jsonData.posts[0].offers[i].groups[j].channelId+'>'+  jsonData.posts[0].offers[i].groups[j].channelName +'</label></div></div>');
          n++;

                   }
                               
           
             
         
       }
                   
               }
