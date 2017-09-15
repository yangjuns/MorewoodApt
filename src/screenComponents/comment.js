import React from "react";

import "./comment.css";

export default function Comment(props) {

    const msg = props.msg;

    return (
        <div className="comment-container">
            <p className="comment-time">{`${msg.time}`}</p>
            <p className="comment-name">{`${msg.firstname}`}</p>
            <p className="comment-text">{`${msg.comments}`}</p>
            <button onClick={props.onDelete} className="comment-del-btn">Remove</button>
        </div>
    );
}
