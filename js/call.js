//our username
var name;
var connectedUser;
var conn;      // Ronnection to signal server
var yourConn;  // RTC P2P connection
var stream;    // Your local video stream

// connect to signaling server when page is ready
$(document).ready(function () {
    // Add functions to btns
    $("#hangUpBtn").click(function () {
        console.log("You closed connected.");

        send({
            type: "leave",
            from: name
        });
        handleLeave();
    });

    $("#input-panel").submit(function (e) {
        console.log("submitting...");
        var callToUsername = $(".msg-input").val();
        $(".send-msg-btn").text("Calling ... " + callToUsername);
        $(".msg-input").hide();
        e.preventDefault();
        if (callToUsername.length > 0) {

            connectedUser = callToUsername;

            // create an offer
            yourConn.createOffer(function (offer) {
                send({
                    type: "offer",
                    offer: offer
                });

                yourConn.setLocalDescription(offer);
            }, function (error) {
                alert("Error when creating an offer");
            });

        }
    });

    // Get the user name
    name = $("#username").text();

    conn = new WebSocket('wss://morewood.life:9090');

    conn.onopen = function () {
        console.log("Connected to the signaling server");
        // Login to server:
        send({type:"login", name: name});
    };

    //when we got a message from a signaling server
    conn.onmessage = function (msg) {
        console.log("Got message", msg.data);

        var data = JSON.parse(msg.data);

        switch(data.type) {
            case "login":
                handleLogin(data.success);
                break;
            //when somebody wants to call us
            case "offer":
                handleOffer(data.offer, data.name);
                break;
            case "answer":
                handleAnswer(data.answer);
                break;
            //when a remote peer sends an ice candidate to us
            case "candidate":
                handleCandidate(data.candidate);
                break;
            case "leave":
                console.log("The remote client closed connection.");
                handleLeave();
                break;
            case "query":
                console.log("Received all online users");
                handleQuery(data.users);
            default:
                break;
        }
    };

    conn.onerror = function (err) {
        console.log("Got error", err);
    };
});

// Ready to send/answer peer connections
function getReady(){
    //using Google public stun server
    var configuration = {
        "iceServers": [{ "urls": "stun:stun2.1.google.com:19302" }]
    };

    yourConn = new RTCPeerConnection(configuration);

    // setup stream listening
    yourConn.addStream(stream);

    //when a remote user adds stream to the peer connection, we display it
    yourConn.onaddstream = function (e) {
        // Change Remote Video Size
        setFullVideo($("#remoteVideo"));
        setSmallVideo($("#localVideo"));

        $("#remoteVideo").parent().show();
        $("#remoteVideo").attr("src", window.URL.createObjectURL(e.stream)).load();
        $("#hangUpBtn").show();
        $("#input-panel").hide();
    };

    // Setup ice handling
    yourConn.onicecandidate = function (event) {
        if (event.candidate) {
            send({
                type: "candidate",
                candidate: event.candidate
            });
        }
    };
}

//alias for sending JSON encoded messages
function send(message) {
    //attach the other peer username to our messages
    if (connectedUser) {
        message.name = connectedUser;
    }

    conn.send(JSON.stringify(message));
};

function handleLogin(success) {
    if (success === false) {
        alert("Ooops...try a different username");
    } else {
        $("#callPage").show();

        //**********************
        //Starting a peer connection
        //**********************

        // Get online users
        send({type:"query", from:name});

        //getting local video stream
        navigator.getUserMedia = navigator.getUserMedia ||
            navigator.webkitGetUserMedia ||
            navigator.mediaDevices.getUserMedia ||
            navigator.mozGetUserMedia;
        navigator.getUserMedia({ video: true, audio: true }, function (myStream) {
            stream = myStream;

            //displaying local video stream on the page
            $("#localVideo").get(0).srcObject = stream;

            getReady();
        }, function (error) {
            console.log(error);
        });

    }
};

//when somebody sends us an offer
function handleOffer(offer, name) {
    connectedUser = name;
    yourConn.setRemoteDescription(new RTCSessionDescription(offer));

    //create an answer to an offer
    yourConn.createAnswer(function (answer) {
        yourConn.setLocalDescription(answer);

        send({
            type: "answer",
            answer: answer
        });

    }, function (error) {
        alert("Error when creating an answer");
    });
};

//when we got an answer from a remote user
function handleAnswer(answer) {
    yourConn.setRemoteDescription(new RTCSessionDescription(answer));
};

//when we got a list of online users from server
function handleQuery(names){
    $("#onlineUsers").empty();
    for(i=0;i <names.length; i++){
        var node = $(document.createElement("a"));
        node.text(names[i]).addClass("list-group-item list-group-item-success");
        if(names[i] == name){
            node.addClass("disabled");
        }
        $("#onlineUsers").append(node);
    }
}

//when we got an ice candidate from a remote user
function handleCandidate(candidate) {
    yourConn.addIceCandidate(new RTCIceCandidate(candidate));
};

function handleLeave() {
    $("#hangUpBtn").hide();
    inputRestore();

    connectedUser = null;
    $("#remoteVideo").attr("src", null);
    $("#remoteVideo").parent().hide();

    //restore video size
    setFullVideo($("#localVideo"));
    setSmallVideo($("#remoteVideo"));

    yourConn.close();
    yourConn.onicecandidate = null;
    yourConn.onaddstream = null;
    getReady();
};

// UI Modification
function inputRestore() {
    $("#input-panel").show();
    $(".msg-input").attr("placeholder", "Who do you want to call?").show();
    $(".send-msg-btn").text("Call");
}

function setFullVideo(jObject){
    jObject.addClass("full-video");
    jObject.removeClass("small-video");
    jObject.parent().addClass("full-video-container");
    jObject.parent().removeClass("small-video-container");
}

function setSmallVideo(jObject){
    jObject.addClass("small-video");
    jObject.removeClass("full-video");
    jObject.parent().addClass("small-video-container");
    jObject.parent().removeClass("full-video-container");
}
$(".navbar").css("margin-bottom","0px");
inputRestore();

