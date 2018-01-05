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

const ExcerptGallery = ({ conversations, loading, loadMoreConversations }) => (

    <div className='columns is-multiline'>
        {
            conversations ? COLUMNS.map(columnIndex =>
                <div className='column is-one-third' key={ columnIndex }>
                    {
                        conversations.filter((c, i) => i % COLUMNS.length === columnIndex).map(conversation =>
                            <ConversationExcerpt key={ conversation.id } conversation={ conversation } />
                        )
                    }
                </div>
            ) : null
        }
        {
            !conversations || loading
            ? <div className='column is-size-4 has-text-weight-light has-text-centered has-text-grey'>Loading...</div>
            : null
        }
        {
            !loading && conversations && !conversations.length
            ? <div className='column is-size-4 has-text-weight-light has-text-centered has-text-grey'>No Results</div>
            : null
        }
        {
            !loading && conversations && conversations.length && loadMoreConversations
            ? <a className='column is-size-4 has-text-weight-light has-text-centered has-text-grey block' onClick={ loadMoreConversations }>Load More</a>
            : null
        }
    </div>

)

export default ExcerptGallery
