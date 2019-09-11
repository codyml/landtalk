/*
*   Imports.
*/

import React from 'react'
import ConversationMap from './conversation-map.jsx'


/*
*   React component for the mini conversation map.
*/

const MiniConversationMap = ({ postId }) => (
  <ConversationMap selectedMarker={ postId } height='20em' miniMap />
)

export default MiniConversationMap
