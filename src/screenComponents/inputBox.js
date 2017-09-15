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
            <div className="row">
                <div className="col-lg-6">
                    <form onSubmit={this._handleSubmit}>
                        <div className="input-group">
                            <div className="input-group-btn">
                                <button type="button" className="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{this.props.person.name}<span className="caret"></span></button>
                                <ul className="dropdown-menu">
                                    {
                                        Persons.map((person, index) =>
                                            <li key={index}><a onClick={this._handlePersonChange(person)}>{person.name}</a></li>,
                                        )
                                    }
                                </ul>
                            </div>
                            <input type="text" className="form-control" aria-label="..." value={this.props.usrMsg} onChange={this._handleInputChange} />
                            <span className="input-group-btn">
                                <button className="btn btn-default" type="submit">Send</button>
                            </span>
                        </div>
                    </form>
                </div>
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
    _handleSubmit(event) {
        event.preventDefault();
        this.props.onSubmit();
    }
}
