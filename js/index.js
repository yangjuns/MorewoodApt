var info = document.getElementById( 'app' );

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

function getMsg(url, div){
    ajax=AjaxCaller();
    ajax.open("GET", url, true);
    ajax.onreadystatechange=function(){
        if(ajax.readyState==4){
            if(ajax.status==200){
                div.innerHTML = ajax.responseText;
            }
        }
    }
    ajax.send(null);
}

function sendMsg(){
    var text = document.getElementById("message")
    var message = text.value;
    text.value = "";
    if(message!=""){
        ajax=AjaxCaller();
        var data =
            "msg=" + encodeURIComponent(message);
        ajax.open("POST", "../php/putMsg.php", true);
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.onreadystatechange=function(){
            if(ajax.readyState==4){
                if(ajax.status==200){
                    getMsg("../php/getMsg.php", info);
                }else{
                    //TODO: need to handle error
                }
            }
        }
        ajax.send(data);
    }
}

function delMsg(id){
    ajax=AjaxCaller();
    var data =
        "commentid=" + encodeURIComponent(id);
    ajax.open("POST", "../php/delMsg.php", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.onreadystatechange=function(){
        if(ajax.readyState==4){
            if(ajax.status==200){
                getMsg("../php/getMsg.php", info);
            }
        }
    }
    ajax.send(data);
}

function handleInputSubmit(event) {
    event.preventDefault();
    sendMsg();
}


const inputForm = document.getElementById("input-form");
inputForm.onsubmit = handleInputSubmit;

setInterval("getMsg(\"../php/getMsg.php\", info)", 5000);
