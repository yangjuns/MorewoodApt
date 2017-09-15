var info = document.getElementById( 'app' );
console.log("hello world");

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

function callPage(url, div){
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
        console.log(data);
        ajax.open("POST", "../php/putMsg.php", true);
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.onreadystatechange=function(){
            if(ajax.readyState==4){
                if(ajax.status==200){
                    //do nothing
                }else{
                    //TODO: need to handle error
                }
            }
        }
        ajax.send(data);
    }

}
var btn = document.getElementById("sendMsg");
btn.onclick = sendMsg;

setInterval("callPage(\"../php/getMsg.php\", info)", 5000);
