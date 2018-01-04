/*
*   Imports.
*/

import React from 'react'


/*
*   React component for a single Conversation excerpt card.
*/

const ConversationExcerpt = ({ conversation }) => (

    <div className="card conversation-excerpt">
        <div className="card-image">
            <figure className="image is-3by2" style={{ backgroundImage: `url('${ conversation.historical_image.image_file.sizes.medium_large }')` }} />
        </div>
        <div className="card-content">
            <div className="content" dangerouslySetInnerHTML={ { __html: conversation.summary } }></div>
            <a className="link" href={ conversation.link }>Click for conversation</a>
        </div>
    </div>
                    
)

export default ConversationExcerpt