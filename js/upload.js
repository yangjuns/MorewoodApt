const file = document.getElementById("file-upload-input");
const fileLabel = document.getElementById("file-upload-label");
const fileList = document.getElementById("file-ls");
const btn = document.getElementById("file-upload-btn");

if (btn != null) {
    btn.disable = true;
}

const bar_box = document.getElementById("bar-box");
const bar = document.getElementById("progress-bar");

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

function handleFiles(files) {
    if (files.length > 0) {
        fileLabel.innerHTML = files[0].name;
        btn.disable = false;
        btn.classList.remove("btn-disable");
    }
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
                //console.log(request.responseText);
                window.location.reload();
            } catch (e){
                console.log(e);
            }
        }
    };
    request.upload.addEventListener('progress', function(e){
        bar.style.width = (e.loaded/e.total) * 100 + '%';
    }, false);
    request.open('POST', "/php/upload.php");
    request.send(data);
}

function DeleteFile(item){
    //get the file
    var filename = item.parentNode.parentNode.firstElementChild.firstElementChild.innerHTML;
    $.ajax({
        type: "POST",
        data: {
            msg: filename,
        },success: function(response) {
            window.location.reload();
        },
        url: "/php/deleteFile.php",
    });
}

function adjustContentHeight() {
    const fileContainer = document.getElementById("file-container");
    if (fileContainer) {
        const panelHeight = $(fileContainer).outerHeight();
        $(fileList).css("margin-bottom", panelHeight + 20);
    }
}

adjustContentHeight();
