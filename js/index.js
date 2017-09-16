const info = document.getElementById( "content-container" );

const Person = {
    ZACH: {name: "LYB"},
    LUYAO: {name: "Luyao"},
    YANG: {name: "Yangjun"},
};

function isValidPerson(name) {
    name = name.toLowerCase();
    for (var key in Person) {
        if (Person.hasOwnProperty(key)) {
            if (name == Person[key].name.toLowerCase()) {
                return Person[key].name;
            }
        }
    }
    return "";
}


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

function findMentions(text) {
    const result = [];
    var mentionIndex = text.indexOf('@');
    while (mentionIndex >= 0) {
        var endIndex = text.indexOf(" ", mentionIndex + 1);
        if (endIndex < 0) {
            endIndex = text.length;
        }
        var name = text.substring(mentionIndex + 1, endIndex);
        name = isValidPerson(name);
        if (name.length > 0) {
            result.push(name);
        }
        if (endIndex < text.length) {
            mentionIndex = text.indexOf('@', mentionIndex + 1);
        } else {
            break;
        }
    }
    return result;
}

function sendMsg(){
    const text = document.getElementById("message")
    const message = text.value.trim();
    text.value = "";
    if(message!=""){
        $.ajax({
            type: "POST",
            data: {
                msg: message,
                emails: findMentions(message),
            },
            url: "../php/putMsg.php",
            success: function(response) {
                getMsg("../php/getMsg.php", info);
            },
        });
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
if (inputForm) {
    inputForm.onsubmit = handleInputSubmit;
}

const inputPanel = document.getElementById("input-panel");
if (inputPanel) {
    const panelHeight = $(inputPanel).outerHeight();
    const content = document.getElementById("content-container");
    $(content).css("margin-bottom", panelHeight + 20);
}

setInterval("getMsg(\"../php/getMsg.php\", info)", 5000);
