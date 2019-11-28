/*
* Imports.
*/

import React from 'react';
import PropTypes from 'prop-types';


/*
* Component definition.
*/

const KeywordSearch = ({ searchedKeyword, setSearchedKeyword }) => (
  <div className="search-control keyword-search">
    <div className="search-control-title">Search by place or keyword:</div>
    <div className="keyword-search-field">
      <input
        type="text"
        value={searchedKeyword}
        onChange={(e) => setSearchedKeyword(e.target.value)}
        className="input"
        placeholder="place name or keyword"
      />
      {
        searchedKeyword ? (
          <a
            className="clear-button icon is-small"
            onClick={() => setSearchedKeyword('')}
          >
            <i className="fa fa-times-circle" />
          </a>
        ) : null
      }
    </div>

    <div className="search-control-description">
      Enter a word or phrase to find matching results.
    </div>
  </div>
);

KeywordSearch.propTypes = {
  searchedKeyword: PropTypes.string.isRequired,
  setSearchedKeyword: PropTypes.func.isRequired,
};

export default KeywordSearch;
