<html>
<head>
<body>
<div id="selecteditems">
<script type="text/javascript">
    $(function () {
     $("#show_textbox").hide();
        $("input[name='selecteduser']").click(function () {
            if ($("#radio6").is(":checked")) {
                $("#show_textbox").show();
            } else {
                $("#show_textbox").hide();
            }
        });
    });
</script>		
</div>
<body>
</html>