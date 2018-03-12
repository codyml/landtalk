/*
*   Imports.
*/

import React from 'react'
import debounce from 'lodash.debounce'
import CollapsibleSection from './collapsible-section.jsx'
import SearchBar from './search-bar.jsx'
import Conversations from './conversations.jsx'
import ConversatioNMap from './conversation-map.jsx'


/*
*   React component for the various Conversations page viewing options.
*/

export default class ConversationArchive extends React.Component {

    constructor(props) {

        super(props)
        this.state = {
            collapsed: {},
            searchBarValue: ''
        }

        //  Parses hash to determine ID of selected marker, if applicable
        if (location.hash) {
            const id = location.hash.match(/#(\d+)/)
            if (id) {
                this.state.selectedMarker = +id[1]
                this.state.collapsed.latestConversations = true
                this.state.collapsed.allConversations = true
            }
        }
        
        this.toggleCollapsibleSection = this.toggleCollapsibleSection.bind(this)
        this.handleSearchBarChange = debounce(this.handleSearchBarChange.bind(this))

    }


    /*
    *   Collapses or expands a section.
    */

    toggleCollapsibleSection(section) {
        
        this.setState({
            collapsed: {
                ...this.state.collapsed,
                [section.key]: !this.state.collapsed[section.key],
            }
        })
    
    }


    /*
    *   Handles a change to the All Conversations search bar.
    */

    handleSearchBarChange(event) {

        const searchValue = event.target.value
        this.setState({

            collapsed: { ...this.state.collapsed, allConversations: false },
            searchBarValue: searchBarValue,

        })

    }

    render() {
        
        //  Sets up the All Conversations search bar
        const searching = this.state.allConversationsSearching
        const allConversationsSearchBar = <div className={ `control is-small has-icons-left ${ searching ? 'is-loading' : '' }` }>
            <input
                type='text'
                className='input is-small'
                placeholder='search conversations'
                value={ this.state.allConversationsSearchValue }
                onChange={ this.handleSearchBarChange }
            />
            <span className="icon is-small is-left">
                <i className="fa fa-search"></i>
            </span>
        </div>

        return (

            <React.Fragment>
                {
                    SECTIONS.map(section => (

                        <div className='container' key={ section.key }>
                            <CollapsibleSection
                                collapsed={ this.state.collapsed[section.key]}
                                title={ section.title }
                                titleContent={ section.key === 'allConversations' && allConversationsSearchBar }
                                toggleCollapsed={ this.toggleCollapsibleSection.bind(this, section) }
                            >
                                <section.Component
                                    conversations={ this.state.conversations[section.key] }
                                    selectedMarker={ section.key === 'conversationMap' && this.state.selectedMarker }
                                    loading={ section.key === 'allConversations' && this.state.allConversationsLoading }
                                    loadMoreConversations={
                                        (section.key === 'allConversations' && this.state.allConversationsMoreToLoad)
                                        ? this.loadMoreConversations
                                        : null
                                    }
                                />
                            </CollapsibleSection>
                        </div>

                    ))
                }
            </React.Fragment>

        )
    
    }

}
