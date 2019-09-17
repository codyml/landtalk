/*
* Imports.
*/

import React from 'react';
import PropTypes from 'prop-types';


/*
* Sorting constants; correspond to possible parameters defined in
* `landtalk-custom-theme/inc/rest.php`.
*/

export const RELEVANCE_SORT = 'relevance';
export const RANDOM_SORT = 'rand';
export const POPULAR_SORT = 'popular';
export const RECENT_SORT = 'recent';
const SORT_OPTIONS = [
  { display: 'Relevance', value: RELEVANCE_SORT },
  { display: 'Random', value: RANDOM_SORT },
  { display: 'Popular', value: POPULAR_SORT },
  { display: 'Recent', value: RECENT_SORT },
];

/*
* Component definitions.
*/

const SortDropdown = ({ searchedKeyword, searchSort, setSearchSort }) => (
  <div className="search-control sort-dropdown">
    <div className="search-control-title">Sort conversations by:</div>
    <div className="select">
      <select value={searchSort} onChange={(e) => setSearchSort(e.target.value)}>
        {
          SORT_OPTIONS.map((option) => (
            option.value !== RELEVANCE_SORT || searchedKeyword ? (
              <option value={option.value} key={option.value}>{option.display}</option>
            ) : null
          ))
        }
      </select>
    </div>
  </div>
);

SortDropdown.propTypes = {
  searchedKeyword: PropTypes.string.isRequired,
  searchSort: PropTypes.oneOf([
    RELEVANCE_SORT,
    RANDOM_SORT,
    POPULAR_SORT,
    RECENT_SORT,
  ]).isRequired,
  setSearchSort: PropTypes.func.isRequired,
};

export default SortDropdown;
