/*
*   Imports
*/

import React from 'react'
import { downloadRelatedConversations } from './rest.js'
import ExcerptGallery from './excerpt-gallery.jsx'


/*
*   React component for rendering three random Featured Conversations.
*/

export default class RelatedConversations extends React.Component {

    constructor(props) {
        
        super(props)
        this.state = { relatedConversations: [] }
        this.componentDidMount = this.componentDidMount.bind(this)
    
    }

    componentDidMount() {
        
        downloadRelatedConversations(this.props.postId)
        .then(conversations => this.setState({ relatedConversations: conversations }))
        .catch(console.error.bind(console))
    
    }

    render() {
        return <ExcerptGallery conversations={ this.state.relatedConversations } />
    }

}
