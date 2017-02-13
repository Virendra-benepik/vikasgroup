function ValidatePostNews()
{
    var title = document.form1.title;
    var uploadimage = document.form1.uploadimage;
    //var content = document.form1.content;


    if (title.value == "")
    {
        window.alert("Please enter Title.");
        title.focus();
        return false;
    }
    if (uploadimage.value == "")
    {
        window.alert("Please Upload Image.");
        uploadimage.focus();
        return false;
    }
//	if(content.value == "")
    //  {
    //    window.alert("Please enter News Content.");
    //  content.focus();
    //return false;
    //}
    return true;
}



function ValidatePostMessage()
{
    var title = document.postmessageform.title;
    var content = document.postmessageform.content;
    if (title.value == "")
    {
        window.alert("Please enter Post Title.");
        title.focus();
        return false;
    }
    if (content.value == "")
    {
        window.alert("Please enter Post Message.");
        content.focus();
        return false;
    }

    return true;
}

function ValidatePostpicture()
{
    var uploadimage = document.postpictureform.uploadimage;
   // var content = document.postpictureform.content;

    if (uploadimage.value == "")
    {
        window.alert("Please Select Picture.");
        uploadimage.focus();
        return false;
    }
   /*
   if (content.value == "")
    {
        window.alert("Please Enter Description");
        content.focus();
        return false;
    }
	*/

    return true;
}


function ValidatePostalbum()
{
    var title = document.postalbumform.title;
    var desc = document.postalbumform.desc;
    //var album = document.postalbumform.album;
    //var files = document.getElementById('files').value;
    var fi = document.getElementById("files");
	//var fi = document.postalbumform.album[];
    if (title.value == "")
    {
        window.alert("Please Enter Album Title.");
        title.focus();
        return false;
    }
    if (desc.value == "")
    {
        window.alert("Please Enter Description");
        desc.focus();
        return false;
    }
    if (fi.value == "")
    {
        window.alert("Please Select Image");
		fi.focus();
        return false;
    }
    return true;
}


function ValidatePostonboard()
{
    var name = document.form1.name;
    var uploadimage = document.form1.uploadimage;
    var userabout = document.form1.userabout;
    var designation = document.form1.designation;
    var doj = document.form1.doj;
    var location = document.form1.location;

    if (name.value == "")
    {
        window.alert("Please Enter Joinee's Name");
        name.focus();
        return false;
    }
    if (uploadimage.value == "")
    {
        window.alert("Please Select Image");
        uploadimage.focus();
        return false;
    }
    if (userabout.value == "")
    {
        window.alert("Please write Short Paragraph In About Fields");
        userabout.focus();
        return false;
    }
    if (designation.value == "")
    {
        window.alert("Please Enter Designation");
        designation.focus();
        return false;
    }
    if (doj.value == "")
    {
        window.alert("Please Enter Date Of joining");
        doj.focus();
        return false;
    }
    if (location.value == "")
    {
        window.alert("Please Enter Location");
        location.focus();
        return false;
    }


    return true;
}

function ValidatePostCeoMessage()
{
    var title = document.form1.title;
    var uploadimage = document.form1.uploadimage;
    //var content = document.form1.content;
    if (title.value == "")
    {
        window.alert("Please Enter Title");
        title.focus();
        return false;
    }
    if (uploadimage.value == "")
    {
        window.alert("Please Select Image");
        uploadimage.focus();
        return false;
    }

    // if(document.getElementById('editor1').value == "") 
    //    {      
    //  alert("Please Enter Message");
    // document.getElementById('editor1').focus();
// return false;
    //	 }		
    return true;
}

function ValidatePostNotice()
{
    var title = document.notice.noticetitle;
    var content = document.notice.noticecontent;
    if (title.value == "")
    {
        window.alert("Please enter Notice Title.");
        noticetitle.focus();
        return false;
    }
    if (content.value == "")
    {
        window.alert("Please enter Notice Message.");
        noticecontent.focus();
        return false;
    }

    return true;
}




