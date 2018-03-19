/*
*   Imports
*/

import React from 'react'
import Conversations from './conversations.jsx'


/*
*   React component for rendering the Featured Conversations.
*/

const RelatedConversations = ({ postId }) => (
    <Conversations relatedId={postId} perPage={3} orderBy='rand' />
)

export default RelatedConversations