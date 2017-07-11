<?php
include 'navigationbar.php';
include 'leftSideSlide.php';
session_start();
$client = $_SESSION['client_id'];
require_once('Class_Library/class_getDepartment.php');

$recogobj = new Department();
$company1 = $recogobj->getCompanyName($client);
$company = json_decode($company1,true);
//echo "<pre>";
//print_r($company);

?>

<!--------------------Used For Analytics Graph pages Date 29 March 2017 start------------------------------>
<!--------------------Used For date range picker start------------------------------>
<link rel="stylesheet" type="text/css" media="all" href="css/daterangepicker.css" />
<script type="text/javascript" src="js/moment.js"></script>
<script type="text/javascript" src="js/daterangepicker.js"></script>
<!--------------------Used For Analytics Graph pages Date 29 March 2017 End------------->
<!--------------------Used For high chart or graph start------------------------------>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<!--------------------Used For high chart or graph end------------------------------>
<!--------------------Used For Analytics Graph pages Date 29 March 2017 End------------------------------>

<div class="side-body">
    <div class="container-fluid" style="margin-top:15px;border:1px solid #cdcdcd;margin-left:0px;">
        <div class="row" >
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h3><b>Active User Analytics Graph (Date wise)</b></h3><hr>
            </div>

        </div>

        <div class="row">
            <div class="col-md-4 col-md-offset-2 demo" style="margin-left:30px;">
<!--                <h4><b>Select Date From Here</b></h4>-->
                 <label for="sel1">Select Date From Here</label>
                <input type="text" id="config-demo" class="form-control">
                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
            </div>
            <input id="config-text" type="hidden"/>
           <div class="form-group col-md-4">
                                    <label for="sel1">Select Company</label>
                                    <select class="form-control" id="company1">
                                        <option value = "All" selected="">All</option>
                                        <?php
                                        $count = count($company);
                                        for ($i = 0; $i < $count; $i++) {
                                            echo '<option value="' . $company[$i]['companyUniqueId'] . '">' . $company[$i]['companyName'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>&nbsp;&nbsp;&nbsp;&nbsp;
               <div class="col-md-3">
                    <label for="sel1">  </label>
                                    <input type="submit" id="recognizeuser" onclick="getActiveuser();" class="btn btn-primary" value="Submit" />
                                </div>

        </div>

        <br><br><br><br><br>
        <div id="container" style="min-width: 350px; height: 500px; margin: 0 auto"></div>


    </div>
</div>


<form>
    <input type="hidden"  class="form-control" id="parentEl" value="" placeholder="body">
    <input type="hidden"  class="form-control" id="startDate" value="07/01/2015">
    <input type="hidden" class="form-control" id="endDate" value="07/15/2015">
    <input type="hidden" class="form-control" id="minDate" value="" placeholder="MM/DD/YYYY">
    <input type="hidden" class="form-control" id="maxDate" value="" placeholder="MM/DD/YYYY">
    <input type="hidden" id="autoApply"> 
    <input type="hidden" id="singleDatePicker"> 
    <input type="hidden" id="showDropdowns">
    <input type="hidden" id="showWeekNumbers"> 
    <input type="hidden" id="showISOWeekNumbers"> 
    <input type="hidden" id="timePicker"> 
    <input type="hidden" id="timePicker24Hour"> 
    <input type="hidden" class="form-control" id="timePickerIncrement" value="1">
    <input type="hidden" id="timePickerSeconds"> 
    <input type="hidden" id="dateLimit">
    <input style="display:none;" type="checkbox" id="ranges" checked="checked">
    <input type="hidden" id="locale">
    <input style="display:none;" type="hidden" id="rtl">
    <input style="display:none;"type="checkbox" id="alwaysShowCalendars" checked="checked"> 
    <input style="display:none;" type="checkbox" id="linkedCalendars" checked="checked">
    <input style="display:none;" type="checkbox" id="autoUpdateInput" checked="checked">	
    <input style="display:none;" type="checkbox" id="showCustomRangeLabel" checked="checked"> 
    <input type="hidden" id="opens" class="form-control"/>
    <input type="hidden" id="drops" class="form-control"/>
    <input type="hidden" class="form-control" id="buttonClasses" value="btn btn-sm">
    <input type="hidden" class="form-control" id="applyClass" value="btn-success">
    <input type="hidden" class="form-control" id="cancelClass" value="btn-default">
</form>


<script type='text/javascript'>
    
    function getActiveuser()
    {
         sel1 = $("#config-demo").val();
     //    alert(sel1);
         company = $("#company1").val();
      //    alert(company);
         getval(sel1,company);
    }
    
    function getval(duration,company) {
     
        var postData =
            {
                "date":duration,
               
	        "companyname": company
            }
            var dataString = JSON.stringify(postData);
        
        var saveData = $.ajax({
            type: 'POST',
            url: '<?php echo SITE; ?>'+"Link_Library/link_getActiveUser.php",
            data: {
                mydata: dataString
            },
            success: function (resultData) {
               // alert(resultData);
              //  console.log(resultData);
                var obj = JSON.parse(resultData);
             // console.log(obj);
                //mystring = mystring.replace(/["']/g, "");
              //  var myJSON = JSON.stringify(obj.categories);
              var myJSON = obj.categories;
           
               console.log(myJSON);
              
                 passValue(myJSON,obj.uniqueview,obj.totalview);
            }
        });
        saveData.error(function ( data, status, error ) {
              console.log(data);
                console.log(status);
                console.log(error);
            alert("Something went wrong");
        }); saveData.complete(function() {
                setTimeout(getval, 250);
            });

}
        /*********************************************************/
function passValue(categorydate1,uniqueview1,totalview1)
{

  console.log(categorydate1);
console.log(totalview1);
  console.log(uniqueview1);
        Highcharts.chart('container', {
            chart: {
                type: 'line'
            },
            title: {
                text: ''
            },
            subtitle: {
                text: ''
            },
             credits: {
      enabled: false
  },
            xAxis: {
                "categories" : categorydate1

            },
            yAxis: {
                 allowDecimals: false,
                title: {
                    text: 'Total Users and Unique Users'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                }
            },
            series: [{
                    name: 'Total Users',
                    data:  totalview1 // [7, 6, 9, 14, 18]
                }, {
                    name: 'Uniqe Users',
                    data:  uniqueview1 // [3, 4, 5, 8, 11]
                }]

        });
    }
//]]>

</script>	

<style type="text/css">
    .demo { position: relative; }
    .demo i {
        position: absolute; bottom: 10px; right: 24px; top: auto; cursor: pointer;
    }
</style>
<script>
    /* When the user clicks on the button, 
     toggle between hiding and showing the dropdown content */
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

// Close the dropdown if the user clicks outside of it
    window.onclick = function (event) {
        if (!event.target.matches('.dropbtn')) {

            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>


<script type="text/javascript">
    $(document).ready(function () {
//        var sel = $("#config-demo").val();
//        alert(sel);
//        getval(sel);

        $('#config-text').keyup(function () {
            eval($(this).val());
        });

        $('.configurator input, .configurator select').change(function () {
            updateConfig();
        });

        $('.demo i').click(function () {
            $(this).parent().find('input').click();
        });

        $('#startDate').daterangepicker({
            singleDatePicker: true,
            startDate: moment().subtract(6, 'days')
        });

        $('#endDate').daterangepicker({
            singleDatePicker: true,
            startDate: moment()
        });

        updateConfig();

        function updateConfig() {
            var options = {};

            if ($('#singleDatePicker').is(':checked'))
                options.singleDatePicker = true;

            if ($('#showDropdowns').is(':checked'))
                options.showDropdowns = true;

            if ($('#showWeekNumbers').is(':checked'))
                options.showWeekNumbers = true;

            if ($('#showISOWeekNumbers').is(':checked'))
                options.showISOWeekNumbers = true;

            if ($('#timePicker').is(':checked'))
                options.timePicker = true;

            if ($('#timePicker24Hour').is(':checked'))
                options.timePicker24Hour = true;

            if ($('#timePickerIncrement').val().length && $('#timePickerIncrement').val() != 1)
                options.timePickerIncrement = parseInt($('#timePickerIncrement').val(), 10);

            if ($('#timePickerSeconds').is(':checked'))
                options.timePickerSeconds = true;

            if ($('#autoApply').is(':checked'))
                options.autoApply = true;

            if ($('#dateLimit').is(':checked'))
                options.dateLimit = {days: 7};

            if ($('#ranges').is(':checked')) {
                options.ranges = {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                };
            }

            if ($('#locale').is(':checked')) {
                $('#rtl-wrap').show();
                options.locale = {
                    direction: $('#rtl').is(':checked') ? 'rtl' : 'ltr',
                    format: 'MM/DD/YYYY HH:mm',
                    separator: ' - ',
                    applyLabel: 'Apply',
                    cancelLabel: 'Cancel',
                    fromLabel: 'From',
                    toLabel: 'To',
                    customRangeLabel: 'Custom',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    firstDay: 1
                };
            } else {
                $('#rtl-wrap').hide();
            }

            if (!$('#linkedCalendars').is(':checked'))
                options.linkedCalendars = false;

            if (!$('#autoUpdateInput').is(':checked'))
                options.autoUpdateInput = false;

            if (!$('#showCustomRangeLabel').is(':checked'))
                options.showCustomRangeLabel = false;

            if ($('#alwaysShowCalendars').is(':checked'))
                options.alwaysShowCalendars = true;

            if ($('#parentEl').val().length)
                options.parentEl = $('#parentEl').val();

            if ($('#startDate').val().length)
                options.startDate = $('#startDate').val();

            if ($('#endDate').val().length)
                options.endDate = $('#endDate').val();

            if ($('#minDate').val().length)
                options.minDate = $('#minDate').val();

            if ($('#maxDate').val().length)
                options.maxDate = $('#maxDate').val();

            if ($('#opens').val().length && $('#opens').val() != 'right')
                options.opens = $('#opens').val();

            if ($('#drops').val().length && $('#drops').val() != 'down')
                options.drops = $('#drops').val();

            if ($('#buttonClasses').val().length && $('#buttonClasses').val() != 'btn btn-sm')
                options.buttonClasses = $('#buttonClasses').val();

            if ($('#applyClass').val().length && $('#applyClass').val() != 'btn-success')
                options.applyClass = $('#applyClass').val();

            if ($('#cancelClass').val().length && $('#cancelClass').val() != 'btn-default')
                options.cancelClass = $('#cancelClass').val();

            $('#config-text').val("$('#demo').daterangepicker(" + JSON.stringify(options, null, '    ') + ", function(start, end, label) {\n  console.log(\"New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')\");\n});");

            $('#config-demo').daterangepicker(options, function (start, end, label) {
                console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
            });

        }
        sel1 = $("#config-demo").val();
         company = $("#company1").val();
       // alert(sel1);
       //  alert(company);
        getval(sel1,company);
    });
</script>



<?php include 'footer.php';?>