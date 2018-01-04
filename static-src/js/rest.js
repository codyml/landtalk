/*
*   Async function for downloading and parsing the Conversation
*   data.
*/

export const downloadAllConversations = async () => {

    const response = await fetch('/wp-json/wp/v2/conversations')
    return response.json()

}


export const downloadFeaturedConversations = async () => {

    const idResponse = await fetch('/wp-json/landtalk/conversations/featured')
    const parsedIDResponse = await idResponse.json()
    const ids = parsedIDResponse.map(item => item.conversation.ID)
    const conversationsResponse = await fetch(`/wp-json/wp/v2/conversations?include=${ids.join(',')}`)
    return conversationsResponse.json()

}