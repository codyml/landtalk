/*
*   Imports.
*/

import React from 'react'
import debounce from 'lodash.debounce'
import CollapsibleSection from './collapsible-section.jsx'
import Conversations from './conversations.jsx'
import ConversationMap from './conversation-map.jsx'


/*
*   React component for the various Conversations page viewing options.
*/

export default class ConversationArchive extends React.Component {

    constructor(props) {

        super(props)
        this.state = {
            collapsed: { latest: false, map: false, all: false },
            searchBarValue: ''
        }

        //  Parses hash to determine ID of selected marker, if applicable
        if (location.hash) {
            const id = location.hash.match(/#(\d+)/)
            if (id) {
                this.state.selectedMarker = +id[1]
                this.state.collapsed.latest = true
                this.state.collapsed.all = true
            }
        }

        this.toggleCollapsibleSection = this.toggleCollapsibleSection.bind(this)
        this.handleSearchBarChange = this.handleSearchBarChange.bind(this)

    }


    /*
    *   Collapses or expands a section.
    */

    toggleCollapsibleSection(key) {

        this.setState({
            collapsed: {
                ...this.state.collapsed,
                [key]: !this.state.collapsed[key],
            }
        })

    }


    /*
    *   Handles a change to the All Conversations search bar.
    */

    handleSearchBarChange(event) {

        this.setState({

            collapsed: { ...this.state.collapsed, all: false },
            searchBarValue: event.target.value,

        })

    }

    render() {

        //  Sets up the All Conversations search bar
        const allConversationsSearchBar = <div className={ 'control is-small has-icons-left' }>
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
        </div>

        return (

            <React.Fragment>
                <div className='container'>
                    <CollapsibleSection
                        collapsed={ this.state.collapsed.map }
                        title='Map'
                        toggleCollapsed={ this.toggleCollapsibleSection.bind(this, 'map') }
                    >
                        <ConversationMap selectedMarker={ this.state.selectedMarker } />
                    </CollapsibleSection>
                </div>
                <div className='container'>
                    <CollapsibleSection
                        collapsed={ this.state.collapsed.all }
                        title='All Conversations'
                        titleContent={ allConversationsSearchBar }
                        toggleCollapsed={ this.toggleCollapsibleSection.bind(this, 'all') }
                    >
                        <Conversations orderBy='random' perPage={12} paged={true} searchTerm={ this.state.searchBarValue } />
                    </CollapsibleSection>
                </div>
            </React.Fragment>

        )

    }

}
