/*
*   Imports
*/

import React from 'react'
import { downloadFeaturedConversations } from './rest.js'
import ConversationExcerpt from './conversation-excerpt.jsx'


/*
*   React component for rendering three random Featured Conversations.
*/

export default class extends React.Component {

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
        return (
            <div className="columns">{
                this.state.featuredConversations.map(conversation => (
                    <div className="column is-one-third" key={ conversation.id }>
                        <ConversationExcerpt conversation={ conversation } />
                    </div>
                ))
            }</div>
        )
    }

}
