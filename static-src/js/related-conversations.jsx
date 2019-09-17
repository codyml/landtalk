/*
*   Imports
*/

import React from 'react'
import Conversations from './conversations.jsx'


/*
*   React component for rendering the Related Conversations.
*/

const RelatedConversations = ({ postId }) => <Conversations queryParams={{
    query: 'related',
    relatedId: postId,
    perPage: 3,
    pad: 'rand',
}} />

export default RelatedConversations
