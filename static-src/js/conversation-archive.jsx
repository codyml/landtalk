/*
* Imports.
*/

import React from 'react';
import PropTypes from 'prop-types';

import ConversationMap from './conversation-map';
import Conversations from './conversations';


/*
* Returns a state object from the URL hash.
*/

const getStateFromHash = () => {
  const state = {};

  if (window.location.hash.length > 1) {
    const hashComponents = window.location.hash.slice(1).split('&');
    hashComponents.forEach((keyValuePair) => {
      const [key, value] = keyValuePair.split('=');

      let placeAddress;
      let placeLatitude;
      let placeLongitude;
      if (key === 'place') {
        [placeAddress, placeLatitude, placeLongitude] = value.split(',');
      }

      switch (key) {
        case 'selected-marker':
          state.selectedMarker = decodeURIComponent(value);
          break;

        case 'keyword':
          state.searchedKeyword = decodeURIComponent(value);
          break;

        case 'place':
          state.searchedPlace = {
            placeAddress: decodeURIComponent(placeAddress),
            placeLatitude: decodeURIComponent(placeLatitude),
            placeLongitude: decodeURIComponent(placeLongitude),
          };
          break;

        case 'sort':
          state.searchSort = decodeURIComponent(value);
          break;

        default:
      }
    });
  }

  return state;
};


/*
* Sets the URL hash based on a state object.
*/

const setHashFromState = (state) => {
  const hashComponents = [];

  if (state.selectedMarker) {
    hashComponents.append(`selected-marker=${encodeURIComponent(state.selectedMarker)}`);
  }

  if (state.searchedKeyword) {
    hashComponents.append(`keyword=${encodeURIComponent(state.searchedKeyword)}`);
  }

  if (state.searchedPlace) {
    const placeComponents = [
      encodeURIComponent(state.searchedPlace.address),
      encodeURIComponent(state.searchedPlace.latitude),
      encodeURIComponent(state.searchedPlace.longitude),
    ];

    hashComponents.append(`place=${placeComponents.join(',')}`);
  }

  if (state.searchSort) {
    hashComponents.append(`sort=${encodeURIComponent(state.searchSort)}`);
  }

  window.location.hash = hashComponents.join('&');
};


/*
* ConversationArchive component definition.
*/

export default class ConversationArchive extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      selectedMarker: null,
      searchedKeyword: '',
      searchedPlace: null,
      searchSort: null,
      ...getStateFromHash(),
    };

    this.updateSearch = this.updateSearch.bind(this);
    this.getSearchQueryParams = this.getSearchQueryParams.bind(this);
  }

  getSearchQueryParams() {
    const {
      searchedKeyword,
      searchedPlace,
      searchSort,
    } = this.state;

    const queryParams = {
      perPage: 12,
    };

    const filterBy = [];

    if (searchedKeyword) {
      filterBy.append('relevance');
      queryParams.relevanceSearchTerm = searchedKeyword;
    }

    if (searchedPlace) {
      filterBy.append('radius');
      queryParams.radiusLat = searchedPlace.latitude;
      queryParams.radiusLng = searchedPlace.longitude;
    }

    if (filterBy.length) {
      queryParams.filterBy = filterBy.join(',');
    }

    if (searchSort) {
      queryParams.orderBy = searchSort;
    }

    return queryParams;
  }

  updateSearch(update) {
    this.setState(update, () => setHashFromState());
  }

  render() {
    const { topKeywords } = this.props;
    const {
      selectedMarker,
      searchedKeyword,
      searchedPlace,
      searchSort,
    } = this.state;

    return (
      <React.Fragment>
        <div className="full-bleed-container">
          <ConversationMap
            selectedMarker={selectedMarker}
          />
        </div>
        <div className="container">
          <div className="columns multiline">
            <div className="column is-full">
              <KeywordCloud
                keywords={topKeywords}
                searchedKeyword={searchedKeyword}
                setSearchedKeyword={(keyword) => this.updateSearch({ searchedKeyword: keyword })}
              />
            </div>
            <div className="column is-one-half">
              <PlaceSearch
                searchedPlace={searchedPlace}
                setSearchedPlace={(place) => this.updateSearch({ searchedPlace: place })}
              />
            </div>
            <div className="column is-one-half">
              <KeywordSearch
                searchedKeyword={searchedKeyword}
                setSearchedKeyword={(keyword) => this.updateSearch({ searchedKeyword: keyword })}
              />
            </div>
            <div className="column is-full">
              <SortDropdown
                searchedKeyword={searchedKeyword}
                searchSort={searchSort}
                setSearchSort={(sort) => this.updateSearch({ searchSort: sort })}
              />
            </div>
            <div className="column is-full">
              <Conversations
                paged
                queryParams={this.getSearchQueryParams()}
              />
            </div>
          </div>
        </div>
      </React.Fragment>
    );
  }
}

ConversationArchive.propTypes = {
  topKeywords: PropTypes.arrayOf(PropTypes.shape({
    name: PropTypes.string.isRequired,
    link: PropTypes.string.isRequired,
  })).isRequired,
};
