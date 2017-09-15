import autobind from "autobind-decorator";
import $ from "jquery";
import React from "react";

import { getCookie, setCookie } from "./lib/cookie";
import Comment from "./screenComponents/comment";
import InputBox, { Person, Persons } from "./screenComponents/inputBox";

const updateInterval = 5000;
const cookiePersonKey = "person";

import "./app.css";

export default class App extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            msgs: [],
            person: Person.ZACH,
            timer: null,
            usrMsg: "",
        }
    }

    componentDidMount() {
        this._getData();
        const timer = setInterval(this._getData, updateInterval);
        this.setState({ timer });
        const personName = getCookie(cookiePersonKey);
        for (const person of Persons) {
            if (person.name === personName) {
                this.setState({ person });
                return;
            }
        }
        setCookie(cookiePersonKey, this.state.person.name);
    }

    componentWillUnmount() {
        if (this.state.timer != null) {
            clearInterval(this.state.timer);
        }
    }

    render() {
        return (
            <div className="app-container">
                <div className="header-container">
                    <h2>Morewoodie</h2>
                </div>
                {this.state.msgs.map(this._displayMsg)}
                <InputBox
                    usrMsg={this.state.usrMsg}
                    person={this.state.person}
                    onPersonChange={this._handlePersonChange}
                    onInputChange={this._handleInputChange}
                    onSubmit={this._putData}
                />
            </div>
        );
    }

    _getUserId() {
        return this.state.person.id;
    }

    @autobind
    _updatePerson(person) {
        return () => this.setState({ person });
    }

    @autobind
    _getData() {
        $.ajax({
            data: {
                limit: 20,
            },
            dataType: "text",
            method: "POST",
            success: this._handleGetSuccess,
            url: `../php/getMsg.php`,
        });
    }

    @autobind
    _putData() {
        if (this.state.usrMsg === "") {
            return;
        }
        $.ajax({
            data: {
                msg: this.state.usrMsg,
                person: this._getUserId(),
            },
            dataType: "text",
            method: "POST",
            success: this._handlePutSuccess,
            url: `../php/putMsg.php`,
        });
    }

    @autobind
    _deleteMsg(id) {
        $.ajax({
            data: {
                commentid: id,
            },
            dataType: "text",
            method: "POST",
            success: this._getData,
            url: `../php/delMsg.php`,
        });
    }

    @autobind
    _handleGetSuccess(data) {
        const msgs = JSON.parse(data);
        this.setState({ msgs });
    }

    @autobind
    _handlePutSuccess() {
        this.setState({ usrMsg: "" });
        this._getData();
    }

    @autobind
    _handleMsgDelete(id) {
        return () => this._deleteMsg(id);
    }

    @autobind
    _displayMsg(msg, index) {
        return (
            <Comment key={index} msg={msg} onDelete={this._handleMsgDelete(msg.commentid)}/>
        );
    }

    @autobind
    _handleInputChange(usrMsg) {
        this.setState({ usrMsg });
    }

    @autobind
    _handlePersonChange(person) {
        this.setState({ person });
        setCookie(cookiePersonKey, person.name);
    }

}
