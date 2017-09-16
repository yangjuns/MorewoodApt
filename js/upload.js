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

function UploadFile(file) {

    var xhr = AjaxCaller();
    if (xhr.upload && file.size <= 50000) {

        // create progress bar
        var o = $id("progress");
        var progress = o.appendChild(document.createElement("p"));
        progress.appendChild(document.createTextNode("upload " + file.name));
        // progress bar
        xhr.upload.addEventListener("progress", function(e) {
            var pc = parseInt(100 - (e.loaded / e.total * 100));
            var bar = document.getElementsByClassName("progress-bar").item(0);
            console.log(bar);

            progress.style.backgroundPosition = pc + "% 0";
        }, false);
        // file received/failed
        xhr.onreadystatechange = function(e) {
            if (xhr.readyState == 4) {
                progress.className = (xhr.status == 200 ? "success" : "failure");
            }
        };
        // start upload
        xhr.open("POST", $id("upload").action, true);
        xhr.setRequestHeader("X-FILENAME", file.name);
        xhr.send(file);

    }
}

const form = document.getElementById("upload-form");
if (form) {
    form.onsubmit = UploadFile;
}
