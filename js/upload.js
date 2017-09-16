function AjaxCaller(){
    var xmlhttp=false;
    try{
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    }catch(e){
        try{
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }catch(E){
            xmlhttp = false;
        }
    }

    if(!xmlhttp && typeof XMLHttpRequest!='undefined'){
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}

function UploadFile() {
    if(file.files.length === 0){
        return;
    }
    var data = new FormData();
    data.append('fileToUpload', file.files[0]);
    bar_box.style.display="block";
    var request = new XMLHttpRequest();
    request.onreadystatechange = function(){
        if(request.readyState == 4){
            try {
                window.location.reload();
            } catch (e){
                console.log(e);
            }
        }
    };
    request.upload.addEventListener('progress', function(e){
        console.log(e)
        console.log(e.total)
        bar.style.width = Math.ceil(e.loaded/e.total) * 100 + '%';
    }, false);
    request.open('POST', "/php/upload.php");
    request.send(data);
}

var btn = document.getElementById("upload-btn");
var file = document.getElementById("fileToUpload");
var bar_box = document.getElementById("bar-box");
var bar = document.getElementById("progress-bar");
btn.addEventListener("click", UploadFile);
