/*
*   Imports.
*/

import React from 'react'
import debounce from 'lodash.debounce'
import {
    downloadFeaturedConversations,
    downloadLatestConversations,
    downloadAllConversations,
    downloadPageOfConversations,
} from './rest.js'

import CollapsibleSection from './collapsible-section.jsx'
import ExcerptGallery from './excerpt-gallery.jsx'
import ConversationMap from './conversation-map.jsx'


/*
*   Constants
*/

const GALLERY = 'gallery'
const MAP = 'map'
const SECTIONS = [
    
    {
        key: 'featuredConversations',
        title: 'Featured Conversations',
        Component: ExcerptGallery,
        request: downloadFeaturedConversations,
    },

    {
        key: 'conversationMap',
        title: 'Map',
        Component: ConversationMap,
        request: downloadAllConversations,
    },

    {
        key: 'allConversations',
        title: 'All Conversations',
        Component: ExcerptGallery,
        request: downloadPageOfConversations.bind(null, 0),
    },

]


/*
*   React component for the various Conversations page viewing options.
*/

export default class ConversationArchive extends React.Component {

    constructor(props) {

        super(props)
        this.state = {
            collapsed: {},
            conversations: {},
            allConversationsCurrentPage: 0,
            allConversationsLoading: false,
            allConversationsMoreToLoad: false,
            allConversationsSearching: false,
            allConversationsSearchValue: '',
        }

        //  Parses hash to determine ID of selected marker, if applicable
        if (location.hash) {
            const id = location.hash.match(/#(\d+)/)
            if (id) {
                this.state.selectedMarker = +id[1]
                this.state.collapsed.featuredConversations = true
                this.state.collapsed.latestConversations = true
                this.state.collapsed.allConversations = true
            }
        }
        
        this.componentDidMount = this.componentDidMount.bind(this)
        this.toggleCollapsibleSection = this.toggleCollapsibleSection.bind(this)
        this.loadMoreConversations = debounce(this.loadMoreConversations.bind(this), 500)
        this.handleSearchBarChange = this.handleSearchBarChange.bind(this)

    }


    /*
    *   Downloads Conversation data for each section and adds listener
    *   for lazy-loading in the All Conversations section.
    */

    componentDidMount() {
        
        SECTIONS.forEach(section => {

            section.request()
            .then(response => {

                this.setState({
                    conversations: {
                        ...this.state.conversations,
                        [section.key]: response,
                    }
                })

                if (section.key === 'allConversations') this.setState({
                    allConversationsMoreToLoad: this.state.allConversationsCurrentPage + 1 !== response.nPages
                })

            })
            .catch(console.error.bind(console))

        })

        document.addEventListener('scroll', this.handleScroll)
    
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
    *   Loads additional conversations in the All Conversations.
    */

    loadMoreConversations() {

        const nextPage = this.state.allConversationsCurrentPage + 1
        this.setState({
            allConversationsLoading: true,
            allConversationsCurrentPage: nextPage,
        })
        
        downloadPageOfConversations(nextPage, this.state.allConversationsSearchValue)
        .then(response => {

            this.setState({
                
                conversations: {
                    ...this.state.conversations,
                    allConversations: [
                        ...this.state.conversations.allConversations,
                        ...response,
                    ],
                },

                allConversationsLoading: false,
                allConversationsMoreToLoad: nextPage + 1 !== response.nPages,
                allConversationsSearching: false,

            })

        })
        .catch(console.error.bind(console))

    }


    /*
    *   Handles a change to the All Conversations search bar.
    */

    handleSearchBarChange(event) {

        const searchValue = event.target.value
        this.setState({

            collapsed: { ...this.state.collapsed, allConversations: false },
            conversations: { ...this.state.conversations, allConversations: [] },
            allConversationsSearchValue: searchValue,
            allConversationsSearching: searchValue,
            allConversationsCurrentPage: -1,
            allConversationsLoading: true,


        }, this.loadMoreConversations)

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
