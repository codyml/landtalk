/*
*   Imports
*/

import React from 'react'
import { downloadFeaturedConversations } from './rest.js'
import ExcerptGallery from './excerpt-gallery.jsx'


/*
*   React component for rendering three random Featured Conversations.
*/

export default class FeaturedConversations extends React.Component {

    constructor(props) {
        
        super(props)
        this.state = { featuredConversations: [] }
        this.componentDidMount = this.componentDidMount.bind(this)
    
    }

    componentDidMount() {
        
        downloadFeaturedConversations()
        .then(conversations => this.setState({ featuredConversations: conversations }))
        .catch(console.error.bind(console))
    
    }

    render() {
        return <ExcerptGallery conversations={ this.state.featuredConversations } />
    }

}
