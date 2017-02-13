$(document).ready(function(){
    $("#sel_location").on('change', function dept(){
        var matchvalue = $(this).val(); // this.value
      /*  $.ajax({ 
            url: 'matchedit-data.php',
            data: { matchvalue: matchvalue },
            type: 'post'
        }).done(function(responseData) {
            console.log('Done: ', responseData);
        }).fail(function() {
            console.log('Failed');
        }); */
        alert(matchvalue);
    });
}); 