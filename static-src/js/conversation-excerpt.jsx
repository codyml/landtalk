/*
*   Imports.
*/

import React from 'react'


/*
*   Constants.
*/

const MAX_SUMMARY_EXCERPT_LENGTH = 200


/*
*   React component for a single Conversation excerpt card.
*/

const ConversationExcerpt = ({ conversation }) => {

    let summary = conversation.summary
    if (summary.length > MAX_SUMMARY_EXCERPT_LENGTH) {

        summary = summary.slice(0, MAX_SUMMARY_EXCERPT_LENGTH)
        const lastSpaceIndex = summary.lastIndexOf(' ')
        summary = summary.slice(0, lastSpaceIndex) + '...'

    }

    return (
        <a href={ conversation.link } className='conversation-excerpt'>
            <div className='card'>
                <div className='card-image'>
                    <figure className='image is-3by2' style={{ backgroundImage: `url('${ conversation.historical_image_url }')` }} />
                </div>
                <div className='card-content'>
                    <div className='has-space-below'>{ conversation.place_name }</div>
                    <div className='content' dangerouslySetInnerHTML={ { __html: summary } }></div>
                    <div className='link' href={ conversation.link }>Click for conversation</div>
                </div>
            </div>
        </a>
    )

}

export default ConversationExcerpt
