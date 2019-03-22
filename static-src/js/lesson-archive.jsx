/*
*   Imports.
*/

import React from 'react'
import debounce from 'lodash.debounce'
import Lessons from './lessons.jsx'

export default class LessonArchive extends React.Component {

    constructor(props) {
        super(props)
        this.state = {
            searchBarValue: ''
        }
        this.handleSearchBarChange = this.handleSearchBarChange.bind(this)
    }

    /*
    *   Handles a change to the All Conversations search bar.
    */

    handleSearchBarChange(event) {
        this.setState({
            searchBarValue: event.target.value,
        })
    }

    render() {
        //  Sets up the All Conversations search bar
        /*const allConversationsSearchBar = <div className={ 'control is-small has-icons-left' }>
            <input
                type='text'
                className='input is-small'
                placeholder='search conversations'
                value={ this.state.searchBarValue }
                onChange={ this.handleSearchBarChange }
            />
            <span className="icon is-small is-left">
                <i className="fa fa-search"></i>
            </span>
        </div>*/

        return (

            <React.Fragment>
                <Lessons orderBy='random' paged={false} />
            </React.Fragment>

        )

    }

}
