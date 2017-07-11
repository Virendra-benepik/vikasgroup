<?php
include 'navigationbar.php';
include 'leftSideSlide.php';
$clientid = $_SESSION['client_id'];
?>
<script type="text/javascript" src="js/analytic/analyticLogingraph.js"></script>
<script type="text/javascript" src="js/analytic/fusioncharts.js"></script>
<script type="text/javascript" src="js/analytic/fusioncharts.charts.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#tablediv").show();
        $("#graphdiv").hide();
        //alert("hello");

        $("button").click(function () {
            var device = $("#device").val(); //"Android";
            var fromdte = $("#formdate").val();//"2016-12-01";
            var enddte = $("#enddate").val();//"2016-12-30"; 
            var clientid = $("#clientid").val();
            //alert("hello1");
            var postData =
                    {
                        "start_date": fromdte,
                        "end_date": enddte,
                        "device": device,
                        "client": clientid
                    }
            var dataString = JSON.stringify(postData);
            //alert(dataString);
            $.ajax({
                type: "POST",
                //dataType: "json",
                //contentType: "application/json; charset=utf-8",
                url: "<?php echo SITE; ?>login_analytic_installapp.php",
                data: {"mydata": dataString},
                success: function (response) {
                    var resdata = response;
                    //alert(response);
                    if (response.length !== 0)
                    {
                        $("#tablediv").show();
                        $("#graphdiv").hide();
                        $('#jsres').val(resdata);

                        var jsonData = JSON.parse(resdata);
                        $('#myTable tbody').remove();
                        for (var i = 0; i < resdata.length; i++) {
/*if(jsonData[i].deviceName == 2)
{
    var device = 'Android';
}
else
{
    var device = 'IOS';
}*/
                            var newRow = '<tbody><tr><td>'+ jsonData[i].sn +'</td><td>'+ jsonData[i].employeeCode +'</td><td>' + jsonData[i].firstName + jsonData[i].lastName + '</td><td>' + jsonData[i].deviceName + '</td><td>' + jsonData[i].date_entry_time + '</td></tr><tbody>';
                            $('#myTable').append(newRow);

                        }
                    }

                    else

                    {
                        $("#tablediv").show();
                        $("#graphdiv").hide();
                        $('#jsres').val(resdata);
                        $('#myTable tbody').remove();
                        var newRow = '<tbody><tr><td>No Record Found</td></tr><tbody>';
                        $('#tBody').html('<tr><td>No Record Found</td></tr>');
                    }



                },
                error: function (e) {
                    alert(e);
                    console.log(e.message);
                }
            });
        });
    });
</script>
<script>
    /********************** graph or export ****************************************************************/
    function graphorexport() {
        //alert("hi graph or export"); 
        var device = $("#device").val(); //"Android";
        var fromdte = $("#formdate").val();//"2016-12-01";
        var enddte = $("#enddate").val();//"2016-12-30"; 
        var clientid = $("#clientid").val();

        //var graphexport = $("#graphexport").val();
        //alert(device + fromdte + enddte +clientid);
        /*********** validate field *******************************/
        /*if(fromdte == "")
         {
         alert('Please Select Date In Date From Field');
         return false;
         }
         if(enddte == "")
         {
         alert('Please Select Date In Date To Field');
         return false;
         }
         */
        var graphexport = document.getElementById("graphexport");
        var graphexportoption = graphexport.options[graphexport.selectedIndex].value;
        //alert(graphexport);
        //alert(graphexportoption);

        if (graphexportoption == "")
        {
            //alert("Please Select Show Graph Or Export In CSV")
            return false;
        }
        else if (graphexportoption == "graph")
        {
            var res = check();
            //alert(res);
            if (res == true)
            {
                $("#tablediv").hide();
                $("#graphdiv").show();
                showGraphFunction();
            }
        }
        else
        {
            var res = check();
            if (res == true)
            {
                //alert("inside export");
                if (confirm('Are You Sure, You want to Export Record?')) {
                    var jsonrestable = $("#jsres").val();
                    //alert(jsonrestable);
                    var jsonData = JSON.parse(jsonrestable);
                    if (jsonData.length > 0)
                    {
                        JSONToCSVConvertor(jsonrestable, "Login_Analytic", true);
                    }
					else
					{
					alert('No Record Found');
					}
                    return true;
                } else {
					
                    return false;
                }

            }
        }

        /********************************* end validate field **********************/
    }
    /**************************** graph or export *************************************************/
</script>
<script>
    function check() {
        var fromdate = document.getElementById("formdate");
        var enddate = document.getElementById("enddate");
        if (fromdate.value == 0)
        {
            alert('Please Select Date In Date From Field')
            fromdate.focus();
            return false;
        }
        if (enddate.value == 0)
        {
            alert('Please Select Date In Date To Field')
            enddate.focus();
            return false;
        }
        return true;
    }
</script>
<div class="side-body">
    <div class="container-fluid" style="margin-top:15px;border:1px solid #cdcdcd;margin-left:0px;">
        <div class="row" >
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h3 style="margin-left:80px;"><strong>Analytics</strong></h3>
                <hr>
            </div>

        </div>

        <div class="row" style="margin-top:10px;">
            <form action="" method="POST">
                  <input type="hidden" name="clientid" id="clientid" value="<?php echo $clientid; ?> ">
                     <input type="hidden" name="device" id="device" value="All">
<!--                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                  
                    <div class="form-group">
                        <label for="sel1" style="margin-left:80px;">Device :</label>
                        <select style="color:#2d2a3b;" name="device" class="form-control" id="device">
                            <option value ="All">All</option>
                            <option value ="2">Android</option>
                            <option value ="3">iphone</option>

                        </select>

                    </div>
                </div>-->
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="form-group">
                        <label for="pwd">Date From :</label>
                        <input type="date" name="formdate" id="formdate" class="form-control" style="color:#2d2a3b;">
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="form-group">
                        <label for="pwd">Date To :</label>
                        <input type="date" name="enddate" id="enddate" class="form-control" style="color:#2d2a3b;">
                    </div>
                </div>
                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                    <div class="form-group">
                        <label for="pwd"></label>
                        <button type="button" class="form-control" onclick="return check();">Submit</button>
                                <!--<input type="button" name="submit" class="form-control" style="color:#2d2a3b;">-->
                    </div>
                </div>

                <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                    <div class="form-group">
                        <label for="pwd"></label>
                        <!--<button type="button" id="0" class="form-control" onclick="return check();">Export</button>-->
                        <select style="color:#2d2a3b;" name="graphexport" class="form-control" id="graphexport" onchange="return graphorexport();">
                            <option value ="">Select</option>
                            <option value ="graph">Show Graph</option>
                            <option value ="export">Export In CSV</option>
                        </select>
                    </div>
                </div>
            </form>


            <div class="" id="tablediv">
                <!---<div class="addusertest">
                
</div>--->
                <div class="side-body">
                    <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;margin-top:20px;">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="card">
                                    <div class="card-body">
                                        <input type="hidden" name="jsres" id="jsres">
                                        <table class="datatable table table-responsive" cellspacing="2" width="100%" id="myTable">
                                            <thead>
                                                <tr>
													<th>SN</th>
                                                    <th>Employee Id</th>
                                                    <th>Employee Name</th>
                                                   
                                                    <th>Device</th>
                                                    <th>Login Date</th> 

                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
												    <th>SN</th>
                                                    <th>Employee Id</th>
                                                    <th>Employee Name</th>
                                                    
                                                    <th>Device</th>
                                                    <th>Login Date</th>
                                                </tr>
                                            </tfoot>
                                            <tbody id="tBody">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <!----------------------- chart --------->
            <div class="" id="graphdiv">
                <div class="side-body">
                    <div class="" style="border:1px solid #cdcdcd;padding:20px;margin-bottom:20px;margin-top:20px;">
                        <div class="row">
                            <div class="col-xs-12">
                                <div id="chart-container"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                if (window.parent && window.parent.parent) {
                    window.parent.parent.postMessage(["resultsFrame", {
                            height: document.body.getBoundingClientRect().height,
                            slug: "wYj95"
                        }], "*")
                }
            </script>
            <!---------------- end chart ------------------------------------->
        </div>
    </div>
    <?php include 'footer.php'; ?>	


