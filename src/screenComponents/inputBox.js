import autobind from "autobind-decorator";
import React from "react";

import "./input-box.css";

export const Person = {
    ZACH: {id: 6, name: "LYB"},
    LUYAO: {id: 5, name: "Luyao"},
    YANG: {id: 4, name: "Yangjun"},
};
export const Persons = [Person.YANG, Person.LUYAO, Person.ZACH];

export default class InputBox extends React.Component {

    render() {
        return (
            <div className="input-panel">
                <input className="input-box" type="text" value={this.props.usrMsg} onChange={this._handleInputChange}/>
                <button className="input-submit" onClick={this._handleSubmit}>Send Message</button>
                <br />
                {
                    Persons.map((person, index) =>
                        <label key={index}>
                            <input
                                type="radio"
                                checked={this.props.person === person}
                                onChange={this._handlePersonChange(person)}
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
    _handlePersonChange(person) {
        return () => this.props.onPersonChange(person);
    }

    @autobind
    _handleInputChange(event) {
        this.props.onInputChange(event.target.value);
    }

    @autobind
    _handleSubmit() {
        this.props.onSubmit();
    }
}