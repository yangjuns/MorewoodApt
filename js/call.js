//our username
var name;
var connectedUser;
var conn;

// connect to signaling server when page is ready
window.onload = function () {
    console.log("document load completed!");
    // Get the user name
    name = document.getElementById("username").firstChild.textContent;

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
            default:
                break;
        }
    };

    conn.onerror = function (err) {
        console.log("Got error", err);
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

//******
//UI selectors block
//******
var callPage = document.querySelector('#callPage');
var callToUsernameInput = document.querySelector('#callToUsernameInput');
var callBtn = document.querySelector('#callBtn');

var hangUpBtn = document.querySelector('#hangUpBtn');

var localVideo = document.querySelector('#localVideo');
var remoteVideo = document.querySelector('#remoteVideo');

var yourConn;
var stream;

function handleLogin(success) {
    if (success === false) {
        alert("Ooops...try a different username");
    } else {
        callPage.style.display = "block";

        //**********************
        //Starting a peer connection
        //**********************

        //getting local video stream
        navigator.getUserMedia({ video: true, audio: true }, function (myStream) {
            stream = myStream;

            //displaying local video stream on the page
            localVideo.src = window.URL.createObjectURL(stream);

            getReady();
        }, function (error) {
            console.log(error);
        });

    }
};

function getReady(){
    //using Google public stun server
    var configuration = {
        "iceServers": [{ "url": "stun:stun2.1.google.com:19302" }]
    };

    yourConn = new RTCPeerConnection(configuration);

    // setup stream listening
    yourConn.addStream(stream);

    //when a remote user adds stream to the peer connection, we display it
    yourConn.onaddstream = function (e) {
        remoteVideo.src = window.URL.createObjectURL(e.stream);
        handUpBtn.style.display="inline-block";
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

//initiating a call
callBtn.addEventListener("click", function () {

    var callToUsername = callToUsernameInput.value;

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

//when we got an ice candidate from a remote user
function handleCandidate(candidate) {
    yourConn.addIceCandidate(new RTCIceCandidate(candidate));
};

//hang up
hangUpBtn.addEventListener("click", function () {
    console.log("You closed connected.");
    send({
        type: "leave"
    });

    handleLeave();
});

function handleLeave() {
    connectedUser = null;
    remoteVideo.src = null;

    yourConn.close();
    yourConn.onicecandidate = null;
    yourConn.onaddstream = null;
    getReady();
};