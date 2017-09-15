import React from "react";

import "./comment.css";
import { Person } from "./inputBox";

export default function Comment(props) {

    const msg = props.msg;

    var alertClass = "";
    switch (msg.firstname) {
    case Person.LUYAO.name:
        alertClass = "alert-info";
        break;
    case Person.YANG.name:
        alertClass = "alert-success";
        break;
    case Person.ZACH.name:
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
