import autobind from "autobind-decorator";
import $ from "jquery";
import React from "react";

import Comment from "./screenComponents/comment";

const updateInterval = 5000;

const Person = {
    ZACH: {id: 6, name: "LYB"},
    LUYAO: {id: 5, name: "Luyao"},
    YANG: {id: 4, name: "Yangjun"},
};

import "./app.css";

export default class App extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            msgs: [],
            person: Person.ZACH,
            persons: [Person.YANG, Person.LUYAO, Person.ZACH],
            timer: null,
            usrMsg: "",
        }
    }

    componentDidMount() {
        this._getData();
        const timer = setInterval(this._getData, updateInterval);
        this.setState({ timer });
    }

    componentWillUnmount() {
        if (this.state.timer != null) {
            clearInterval(this.state.timer);
        }
    }

    render() {
        return (
            <div>
                <div className="header-container">
                    <h4>Morewoodie</h4>
                </div>
                {this.state.msgs.map(this._displayMsg)}
                <input type="text" value={this.state.usrMsg} onChange={this._handleChange}/>
                <button onClick={this._putData}>Send Message</button>
                <br />
                {
                    this.state.persons.map((person, index) =>
                        <label key={index}>
                            <input
                                type="radio"
                                checked={this.state.person === person}
                                onChange={this._updatePerson(person)}
                            />
                            {person.name}
                        </label>,
                    )
                }
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
    _handleChange(event) {
        this.setState({ usrMsg: event.target.value });
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

}
