/*
* Imports.
*/

import React from 'react';
import PropTypes from 'prop-types';

import { getGeocodedAddress } from './rest';


/*
* Component definition.
*/

export default class PlaceSearch extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      dropdownOpen: false,
      placeSearchTerm: '',
      loading: false,
      results: [],
    };

    this.inputRef = React.createRef();

    this.handleDropdownTriggerClick = this.handleDropdownTriggerClick.bind(this);
    this.handleInputChange = this.handleInputChange.bind(this);
    this.selectResult = this.selectResult.bind(this);
  }

  componentWillUnmount() { this.latestRequest = null; }

  handleDropdownTriggerClick() {
    const { dropdownOpen } = this.state;

    if (dropdownOpen) {
      this.setState({ dropdownOpen: false });
    } else {
      this.setState(
        { dropdownOpen: true },
        () => this.inputRef.current.focus(),
      );
    }
  }

  async handleInputChange(event) {
    const placeSearchTerm = event.target.value;
    if (placeSearchTerm) {
      this.setState({
        placeSearchTerm,
        loading: true,
        results: [],
      });

      const thisRequest = {};
      this.latestRequest = thisRequest;

      const results = await getGeocodedAddress(placeSearchTerm);
      if (this.latestRequest === thisRequest) {
        this.setState({ loading: false, results });
      }
    } else {
      this.setState({
        placeSearchTerm,
        results: [],
      });
    }
  }

  selectResult(result) {
    const { setSearchedPlace } = this.props;
    setSearchedPlace(result);
    this.setState({
      dropdownOpen: false,
      placeSearchTerm: '',
      results: [],
    });
  }

  render() {
    const { searchedPlace } = this.props;
    const {
      dropdownOpen,
      placeSearchTerm,
      loading,
      results,
    } = this.state;

    return (
      <div className="search-control place-search">
        <div className="search-control-title">Search by place:</div>
        <div className={`dropdown ${dropdownOpen ? 'is-active' : ''}`}>
          <div className="dropdown-trigger">
            <button
              type="button"
              className="button"
              aria-haspopup="true"
              aria-controls="dropdown-menu"
              onClick={this.handleDropdownTriggerClick}
            >
              <div>
                {
                  searchedPlace
                    ? <Place place={searchedPlace} />
                    : 'No place selected'
                }
              </div>
              <span className="icon is-small">
                <i className="fa fa-angle-down" aria-hidden="true" />
              </span>
            </button>
          </div>
          <div className="dropdown-menu" role="menu">
            <div className="dropdown-content">
              <div className="dropdown-item">
                <div className={`control ${loading ? 'is-loading' : ''}`}>
                  <input
                    type="text"
                    value={placeSearchTerm}
                    onChange={this.handleInputChange}
                    ref={this.inputRef}
                    className="input"
                    placeholder="Address or coordinates"
                  />
                </div>
              </div>
              <hr className="dropdown-divider" />
              {
                !placeSearchTerm ? (
                  <em className="dropdown-item">
                    Start typing an address or enter a coordinate pair.
                  </em>
                ) : null
              }
              {
                placeSearchTerm && loading ? (
                  <em className="dropdown-item">
                    Loading...
                  </em>
                ) : null
              }
              {
                placeSearchTerm && !loading && !results.length ? (
                  <em className="dropdown-item">
                    No results.
                  </em>
                ) : null
              }
              {
                results.length ? results.map((result, i) => (
                  <a
                    className="dropdown-item"
                    onClick={() => this.selectResult(result)}
                    key={`${JSON.stringify(result)}-${i}`} // eslint-disable-line
                  >
                    <Place place={result} />
                  </a>
                )) : null
              }
              {
                searchedPlace ? (
                  <React.Fragment>
                    <hr className="dropdown-divider" />
                    <a className="dropdown-item has-text-danger" onClick={() => this.selectResult()}>
                      <strong>Clear</strong>
                    </a>
                  </React.Fragment>
                ) : null
              }
            </div>
          </div>
        </div>
        <div className="search-control-description">
          Enter a place name or coordinate pair to find results
          within 20 miles of that location.
        </div>
      </div>
    );
  }
}

PlaceSearch.propTypes = {
  searchedPlace: PropTypes.shape({
    address: PropTypes.string.isRequired,
    latitude: PropTypes.number.isRequired,
    longitude: PropTypes.number.isRequired,
  }),
  setSearchedPlace: PropTypes.func.isRequired,
};

PlaceSearch.defaultProps = {
  searchedPlace: null,
};


/*
* Helper component for rendering a place.
*/

const Place = ({ place: { address, latitude, longitude } }) => (
  <div className="place">
    <div>{`${latitude}, ${longitude}`}</div>
    <div className="address">{address}</div>
  </div>
);

Place.propTypes = {
  place: PropTypes.shape({
    address: PropTypes.string.isRequired,
    latitude: PropTypes.number.isRequired,
    longitude: PropTypes.number.isRequired,
  }).isRequired,
};
