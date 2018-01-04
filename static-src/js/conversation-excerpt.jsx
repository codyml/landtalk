/*
*   Imports.
*/

import React from 'react'


/*
*   React component for a single Conversation excerpt card.
*/

const ConversationExcerpt = ({ conversation }) => (

    <a href={ conversation.link }>
        <div className="card conversation-excerpt">
            <div className="card-image">
                <figure className="image is-3by2" style={{ backgroundImage: `url('${ conversation.historical_image.image_file.sizes.medium_large }')` }} />
            </div>
            <div className="card-content">
                <div className="content" dangerouslySetInnerHTML={ { __html: conversation.summary } }></div>
                <div className="link" href={ conversation.link }>Click for conversation</div>
            </div>
        </div>
    </a>

)

export default ConversationExcerpt
