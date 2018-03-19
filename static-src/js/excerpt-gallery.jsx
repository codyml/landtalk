/*
*   Imports.
*/

import React from 'react'
import ConversationExcerpt from './conversation-excerpt.jsx'


/*
*   Constants.
*/

const COLUMNS = [ 0, 1, 2 ]


/*
*   React component for rendering three random Featured Conversations.
*/

const ExcerptGallery = ({ conversations }) => (

    <div className='columns is-multiline'>
        {
            conversations && conversations.length ? COLUMNS.map(columnIndex =>
                <div className='column is-one-third' key={ columnIndex }>
                    {
                        conversations.filter((c, i) => i % COLUMNS.length === columnIndex).map(conversation =>
                            <ConversationExcerpt key={ conversation.id } conversation={ conversation } />
                        )
                    }
                </div>
            ) : null
        }
    </div>

)

export default ExcerptGallery
