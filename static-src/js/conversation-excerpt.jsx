/*
*   Imports.
*/

import React from 'react'


/*
*   React component for a single Conversation excerpt card.
*/

const ConversationExcerpt = ({ conversation }) => (

    <a href={ conversation.link } className='conversation-excerpt'>
        <div className='card'>
            <div className='card-image'>
                <figure className='image is-3by2' style={{ backgroundImage: `url('${ conversation.historical_image_url }')` }} />
            </div>
            <div className='card-content'>
                <div className='is-size-5 has-text-weight-light has-space-below'>{ conversation.place_name }</div>
                <div className='content' dangerouslySetInnerHTML={ { __html: conversation.summary } }></div>
                <div className='link' href={ conversation.link }>Click for conversation</div>
            </div>
        </div>
    </a>

)

export default ConversationExcerpt
