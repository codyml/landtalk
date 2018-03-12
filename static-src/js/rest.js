/*
*   Async function for downloading and parsing the Conversation
*   data.  Implements basic caching.
*/

/*
*   Downloads conversations based on passed parameters.
*/

const cache = {}
export const downloadConversations = async ({ orderBy, perPage, page, searchTerm, featured, relatedId }) => {

    let url = '/wp-json/landtalk/conversations?'
    if (orderBy) url += `orderBy=${orderBy}&`
    if (perPage) url += `perPage=${perPage}&`
    if (page) url += `page=${page}&`
    if (searchTerm) url += `searchTerm=${encodeURIComponent(searchTerm)}&`
    if (featured) url += `featured=true&`
    if (relatedId) url += `relatedId=${relatedId}&`
    if (!cache[url]) {

        const response = await fetch(url)
        cache[url] = await response.json()

    }

    return cache[url]

}
