import autobind from "autobind-decorator";
import $ from "jquery";
import React from "react";

import { PHP_PATH } from "../data";

const updateInterval = 5000;

const Person = {
    ZACH: {id: 4, name: "LYB"},
    LUYAO: {id: 5, name: "Luyao"},
    YANG: {id: 6, name: "Yangjun"},
};

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
                key: "value",
                limit: 20,
            },
            dataType: "text",
            method: "POST",
            success: this._handleGetSuccess,
            url: `${PHP_PATH}/getMsg.php`,
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
            url: `${PHP_PATH}putMsg.php`,
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
    _displayMsg(msg, index) {
        return (
            <p key={index}>{`(${msg.time}) ${msg.firstname}: ${msg.comments}`}</p>
        );
    }

}
