/*
*   Async function for downloading and parsing the Conversation
*   data.  Implements basic caching.
*/

/*
*   Downloads conversations based on passed parameters.  Parameters:
*    - orderBy: the order of the returned converstations.  Value is
*       passed directly to WordPress `orderby` query parameter:
*       [https://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters].
*    - perPage: enables pagination; if property is not set will
*       return all results.  Use int > 0 to set page length.
*    - page: if pagination is enabled as above, will return this
*       page of results.
*    - searchTerm: will filter results to those that contain the
*       the searched-for value.
*    - featured: will return the featured posts.  Other parameters
*       will be ignored.
*    - relatedId: will return posts that share a keyword with the
*       post matching the passed post ID.
*/

const cache = {}
let randomSeed
export const downloadConversations = async (params = {}) => {

    let url = 'https://web.stanford.edu/group/spatialhistory/cgi-bin/landtalk/wp-json/landtalk/conversations?'
    if (params.orderBy) {

        if (params.orderBy === 'rand') {

            if (params.page === 0) {
                randomSeed = Math.floor(Math.random() * 4294967295)
            }

            url += `orderBy=RAND(${randomSeed})&`

        } else url += `orderBy=${params.orderBy}&`

    }

    if (params.perPage) url += `perPage=${params.perPage}&`
    if (params.page) url += `page=${params.page}&`
    if (params.searchTerm) url += `searchTerm=${encodeURIComponent(params.searchTerm)}&`
    if (params.featured) url += `featured=true&`
    if (params.relatedId) url += `relatedId=${params.relatedId}&`
    if (!cache[url]) {

        const response = await fetch(url)
        cache[url] = await response.json()

    }

    return cache[url]

}
