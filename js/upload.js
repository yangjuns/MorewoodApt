const file = document.getElementById("file-upload-input");
const fileLabel = document.getElementById("file-upload-label");
const fileList = document.getElementById("file-ls");
const btn = document.getElementById("file-upload-btn");
const progressBar = document.getElementById("upload-progress");

if (btn != null) {
    btn.disable = true;
    btn.onclick = uploadFile;
}

function handleFiles(files) {
    if (files.length > 0) {
        fileLabel.innerHTML = files[0].name;
        btn.disable = false;
        btn.classList.remove("btn-disable");
    }
}

function uploadFile() {
    if(file.files.length === 0){
        return;
    }
    var data = new FormData();
    data.append('fileToUpload', file.files[0]);
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
        progressBar.style.width = (e.loaded/e.total) * 100 + '%';
    }, false);
    request.open('POST', "/php/upload.php");
    request.send(data);
}

function deleteFile(filename){
    console.log(filename);
    //get the file
    $.post("/php/deleteFile.php",
        {
            msg: filename
        },
        function(response) {
            window.location.reload();
        });
}

function adjustContentHeight() {
    const fileContainer = document.getElementById("file-upload-container");
    if (fileContainer) {
        const panelHeight = $(fileContainer).outerHeight();
        $(fileList).css("margin-bottom", panelHeight + 20);
    }
    if (screen.width < 900) {
        $(".file-modtime").remove();
        $(".file-type-img").remove();
    }
}

adjustContentHeight();
window.addEventListener("resize", adjustContentHeight);
