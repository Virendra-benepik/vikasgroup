
$(window).load(function () {
    var $fileUpload = $("#files"), $list = $('#list'), thumbsArray = [], maxUpload = 15;

// READ FILE + CREATE IMAGE
    function read(f) {
        $('#list').empty();
        return function (e) {
            var base64 = e.target.result;
            var $img = $('<img/>', {
                src: base64,
                title: encodeURIComponent(f.name), //( escape() is deprecated! )
                "class": "thumb"
            });

            var $thumbParent = $("<span/>", {html: $img, "class": "thumbParent"}).append('<span class="remove_thumb"/> \n\
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"><label>Image Caption : </label><input type="text" name="imageCaption[]" class="form-control" /></div>');
            
            thumbsArray.push(base64); // Push base64 image into array or whatever.
            $list.append($thumbParent);
        };
    }

// HANDLE FILE/S UPLOAD
    function handleFileSelect(e) {
        e.preventDefault(); // Needed?
        var files = e.target.files;
        var len = files.length;
        if (len > maxUpload || thumbsArray.length >= maxUpload) {
            return alert("Sorry you can upload only 15 images");
        }
        for (var i = 0; i < len; i++) {
            var f = files[i];
            if (!f.type.match('image.*'))
                continue; // Only images allowed		
            var reader = new FileReader();
            reader.onload = read(f); // Call read() function
            reader.readAsDataURL(f);
        }
    }

    $fileUpload.change(function (e) {
        handleFileSelect(e);
    });

    $list.on('click', '.remove_thumb', function () {
        var $removeBtns = $('.remove_thumb'); // Get all of them in collection
        var idx = $removeBtns.index(this);   // Exact Index-from-collection
        $(this).closest('span.thumbParent').remove(); // Remove tumbnail parent
        thumbsArray.splice(idx, 1); // Remove from array
    });


// that's it. //////////////////////////////
// Let's test //////////////////////////////

    $('#upload').click(function () {
        var testImages = "";
        for (var i = 0; i < thumbsArray.length; i++) {
            testImages += "<div class='col-xs-6 col-sm-3 col-3 col-lg-3'><img src='" + thumbsArray[i] + "'></div>";
        }
        $('#server').empty().append(testImages);
    });
});//]]> 
