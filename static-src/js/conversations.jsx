/*
*   Imports
*/

import React from 'react'
import { downloadConversations } from './rest.js'
import ExcerptGallery from './excerpt-gallery.jsx'


/*
*   React component for rendering three random Featured Conversations.
*/

export default class Conversations extends React.Component {

    constructor(props) {
        
        super(props)
        this.state = { conversations: [], loading: false }
        if (this.props.paged) {
            this.state.currentPage = -1
            this.state.morePages = true
        }

        this.componentDidMount = this.componentDidMount.bind(this)
        this.loadMore = this.loadMore.bind(this)
    
    }

    componentDidMount() { this.loadMore() }
    loadMore() {

        this.setState({ loading: true })
        downloadConversations({
            orderBy: this.props.orderBy,
            perPage: this.props.perPage,
            page: this.state.currentPage + 1,
            featured: this.props.featured,
            relatedId: this.props.relatedId,
        })
        .then({ nPages, conversations } => {
            this.setState({
                loading: false,
                conversations: [ ...this.state.conversations, conversations ],
                currentPage: this.state.currentPage + 1,
                morePages: this.state.currentPage + 1 <= nPages,
            })
        })
        .catch(console.error.bind(console))

    }

    render() {
        return 
            <ExcerptGallery conversations={ this.state.conversations } />
            {
                this.state.loading
                ? <div className='column is-size-4 has-text-weight-light has-text-centered has-text-grey'>Loading...</div>
                : null
            }
            {
                !this.state.loading && !this.state.conversations.length
                ? <div className='column is-size-4 has-text-weight-light has-text-centered has-text-grey'>No Results</div>
                : null
            }
            {
                this.props.paged && !this.state.loading && this.state.conversations.length && this.state.morePages 
                ? <a className='column is-size-4 has-text-weight-light has-text-centered has-text-grey block' onClick={ loadMoreConversations }>Load More</a>
                : null
            }
    }

}
