/*
* Imports.
*/

import React from 'react';
import PropTypes from 'prop-types';


/*
* Component definitions.
*/

const KeywordCloud = ({ keywords, searchedKeyword, setSearchedKeyword }) => (
  <div className="search-control">
    <div className="search-control-title">Popular topics:</div>
    <ul className="keyword-cloud">
      {
        keywords.map((keyword) => {
          let className = 'keyword-cloud-keyword';
          if (searchedKeyword === keyword) {
            className += ' has-text-weight-bold';
          }

          return (
            <a
              className={className}
              onClick={setSearchedKeyword.bind(null, keyword)}
              key={keyword}
            >
              {keyword}
            </a>
          );
        })
      }
    </ul>
  </div>
);

KeywordCloud.propTypes = {
  keywords: PropTypes.arrayOf(PropTypes.string).isRequired,
  searchedKeyword: PropTypes.string.isRequired,
  setSearchedKeyword: PropTypes.func.isRequired,
};

export default KeywordCloud;
