import React from "react";

export default function Comment(props) {

    const msg = props.msg;

    return (
        <div>
            <p>{`(${msg.time}) ${msg.firstname}: ${msg.comments}`}</p>
        </div>
    );
}
