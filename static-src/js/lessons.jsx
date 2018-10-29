import React from 'react';
import {downloadLessons} from './rest.js';
import LessonGallery from './lesson-gallery.jsx'


export default class Lessons extends React.Component {

    constructor(props) {
        super(props)
        this.state = { lessons: [], loading: false }
        if (this.props.paged) {
            this.state.currentPage = 0
            this.state.morePages = true
        }

        this.componentDidMount = this.componentDidMount.bind(this)
        this.loadMore = this.loadMore.bind(this)
    }

    componentDidMount() { this.loadMore() }

    componentWillReceiveProps(newProps) {
        if (this.props.searchTerm !== newProps.searchTerm) {
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
        downloadLessons({
            orderBy: this.props.orderBy,
            perPage: this.props.perPage,
            page: this.state.currentPage,
            searchTerm: this.props.searchTerm,
        })
        .then(response => {
            if (this.latestRequest !== thisRequest) {
                throw 'Obsolete request.'
            } else return response
        })
        .then(({ nPages, lessons }) => {
            this.setState({
                loading: false,
                lessons: [ ...this.state.lessons, ...lessons ],
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
                <LessonGallery lessons={ this.state.lessons } />
                {
                    this.state.loading
                    ? <div className='column is-size-4 has-text-weight-light has-text-centered has-text-grey'>Loading...</div>
                    : null
                }
                {
                    !this.state.loading && !this.state.lessons.length
                    ? <div className='column is-size-4 has-text-weight-light has-text-centered has-text-grey'>No Results</div>
                    : null
                }
                {
                    this.props.perPage && !this.state.loading && this.state.lessons.length && this.state.morePages
                    ? <a className='column is-size-4 has-text-weight-light has-text-centered has-text-grey block' onClick={ this.loadMore }>Load More</a>
                    : null
                }
            </React.Fragment>
        )
    }

}
