<style type="text/css">
    #container {
        min-width: 310px;
        max-width: 100%;
        height: 400px;
        margin: 0 auto
    }
</style>
<script src="js/highcharts/highcharts.js"></script>
<script src="js/highcharts/exporting.js"></script>

<div id="container"></div>
<script>    
    
</script>
<script type='text/javascript' src="js/newGraph.js"></script>
<script>
    // tell the embed parent frame the height of the content
    if (window.parent && window.parent.parent) {
        window.parent.parent.postMessage(["resultsFrame", {
                height: document.body.getBoundingClientRect().height,
                slug: "None"
            }], "*")
    }
</script>