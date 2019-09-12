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
            this.state.currentPage = 0
            this.state.morePages = true
        }

        this.componentDidMount = this.componentDidMount.bind(this)
        this.loadMore = this.loadMore.bind(this)

    }

    componentDidMount() { this.loadMore() }
    componentWillReceiveProps(newProps) {

        if (this.props.queryParams !== newProps.queryParams) {

            const newState = { conversations: [], loading: false }
            if (this.props.paged) {
                newState.currentPage = 0
                newState.morePages = true
            }

            this.setState(newState, this.loadMore)

        }

    }

    loadMore() {

        this.setState({ loading: true })
        const thisRequest = {}
        this.latestRequest = thisRequest
        downloadConversations({
            ...this.props.queryParams,
            page: this.state.currentPage,
        })
        .then(response => {

            if (this.latestRequest !== thisRequest) {

                throw 'Obsolete request.'

            } else return response

        })
        .then(({ nPages, conversations }) => {
            this.setState({
                loading: false,
                conversations: [ ...this.state.conversations, ...conversations ],
                currentPage: this.state.currentPage + 1,
                morePages: this.state.currentPage < nPages - 1,
            })
        })
        .catch(error => {
            if (error !== 'Obsolete request.') console.error(error)
        })

    }

    render() {
        return (
            <React.Fragment>
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
                    this.props.perPage && !this.state.loading && this.state.conversations.length && this.state.morePages
                    ? <a className='column is-size-4 has-text-weight-light has-text-centered has-text-grey block' onClick={ this.loadMore }>Load More</a>
                    : null
                }
            </React.Fragment>
        )
    }

}
