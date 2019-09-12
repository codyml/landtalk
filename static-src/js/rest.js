/*
*   Async function for downloading and parsing the Conversation
*   data.  Implements basic caching.
*/

/*
*   Downloads conversations based on passed parameters. See
*   `landtalk-custom-theme/inc/rest.php` for API description
*   and allowed parameters.
*/

const { absPath } = process.env;

const cache = {};
let randomSeed;
export const downloadConversations = async (params = {}) => {
  let url = `${absPath}/wp-json/landtalk/conversations?`;
  Object.entries(params).forEach(([key, value]) => {
    if (!value) return;

    if (key === 'orderBy') {
      if (value === 'rand') {
        if (params.page === 0) {
          randomSeed = Math.floor(Math.random() * 4294967295);
        }

        url += `orderBy=RAND(${randomSeed})&`;
      } else url += `orderBy=${params.orderBy}&`;
    } else url += `${key}=${encodeURIComponent(value)}&`;
  });

  if (!cache[url]) {
    const response = await fetch(url);
    cache[url] = await response.json();
  }

  return cache[url];
};

export const downloadLessons = async (params = {}) => {
  let url = `${absPath}/wp-json/landtalk/lessons?`;
  if (params.orderBy) {
    if (params.orderBy === 'rand') {
      if (params.page === 0) {
        randomSeed = Math.floor(Math.random() * 4294967295);
      }

      url += `orderBy=RAND(${randomSeed})&`;
    } else url += `orderBy=${params.orderBy}&`;
  }

  if (params.perPage) url += `perPage=${params.perPage}&`;
  if (params.page) url += `page=${params.page}&`;
  if (params.searchTerm) url += `searchTerm=${encodeURIComponent(params.searchTerm)}&`;
  if (!cache[url]) {
    const response = await fetch(url);
    cache[url] = await response.json();
  }

  return cache[url];
};


/*
* Retrieves geocoded results for an entered string.
*/

const N_RESULTS = 5;
export const getGeocodedAddress = async (inputAddress) => {
  const url = `${absPath}/wp-json/landtalk/geocode?inputAddress=${inputAddress}&nResults=${N_RESULTS}`;

  if (!cache[url]) {
    const response = await fetch(url);
    cache[url] = await response.json();
  }

  return cache[url];
};
