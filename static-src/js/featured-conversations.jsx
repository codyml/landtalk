/*
*   Imports
*/

import React from 'react'
import Conversations from './conversations.jsx'


/*
*   React component for rendering the Featured Conversations.
*/

const FeaturedConversations = () => <Conversations queryParams={{
    query: 'featured',
}} />

export default FeaturedConversations
