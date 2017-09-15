import React from "react";

import "./comment.css";

export default function Comment(props) {

    const msg = props.msg;

    var alertClass = "";
    switch (msg.firstname) {
    case "Luyao":
        alertClass = "alert-info";
        break;
    case "Yangjun":
        alertClass = "alert-success";
        break;
    case "LYB":
        alertClass = "alert-warning";
        break;
    }

    return (
        <div className={`alert ${alertClass} alert-dismissible`} role="alert">
            <button type="button" className="close" aria-label="Close" onClick={props.onDelete}><span aria-hidden="true">&times;</span></button>
            <button className="close" style={{fontSize: "10px", marginRight: "10px", paddingTop: "7px"}}>{msg.time}</button>
            <strong>{`${msg.firstname}: `}</strong>{`  ${msg.comments}`}
        </div>
    );
}
