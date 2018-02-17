/*
*   Async function for downloading and parsing the Conversation
*   data.  Implements basic caching.
*/

/*
*   Downloads or returns cache of all Conversations.
*/

let allConversations
export const downloadAllConversations = async () => {

    if (!allConversations) {

        const response = await fetch('/wp-json/landtalk/conversations')
        allConversations = await response.json()

    }

    return allConversations

}


/*
*   Downloads or returns cache of Featured Conversations.  Does
*   two downloads because ACF doesn't serve complete objects with
*   all fields from Options page.
*/

let featuredConversations
export const downloadFeaturedConversations = async () => {

    if (!featuredConversations) {

        const response = await fetch('/wp-json/landtalk/conversations/featured')
        featuredConversations = await response.json()

    }
    
    return featuredConversations

}


/*
*   Downloads or returns cache of Latest Conversations.
*/

let latestConversations
export const downloadLatestConversations = async () => {

    if (!latestConversations) {

        const response = await fetch('/wp-json/landtalk/conversations/latest')
        latestConversations = await response.json()

    }

    return latestConversations

}


/*
*   Downloads or returns cache of a page of Conversations, optionally
*   filtered by a search term.
*/

const pagesOfConversations = {}
export const downloadPageOfConversations = async (pageNumber, searchTerm) => {

    if (!pagesOfConversations[pageNumber] || searchTerm) {

        const response = await fetch(`/wp-json/landtalk/conversations?page=${ pageNumber }&search=${ searchTerm || '' }`)
        const parsedResponse = await response.json()
        const page = parsedResponse.page
        page.nPages = parsedResponse.n_pages
        if (searchTerm) return page
        else pagesOfConversations[pageNumber] = page

    }

    return pagesOfConversations[pageNumber]

}


/*
*   Downloads or returns cache of Latest Conversations.
*/

let relatedConversations
export const downloadRelatedConversations = async (conversationId) => {

    if (!relatedConversations) {

        const response = await fetch(`/wp-json/landtalk/conversations/related?id=${ conversationId }`)
        relatedConversations = await response.json()

    }

    return relatedConversations

}
