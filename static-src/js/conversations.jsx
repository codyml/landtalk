/*
*   Imports
*/

import React from 'react';
import PropTypes from 'prop-types';
import { downloadConversations } from './rest';
import ExcerptGallery from './excerpt-gallery';

/*
*   React component for rendering three random Featured Conversations.
*/

export default class Conversations extends React.Component {
  constructor(props) {
    super(props);
    this.state = { conversations: [], loading: false };
    const { paged } = this.props;
    if (paged) {
      this.state.currentPage = 0;
      this.state.morePages = true;
    }

    this.componentDidMount = this.componentDidMount.bind(this);
    this.loadMore = this.loadMore.bind(this);
  }

  componentDidMount() { this.loadMore(); }

  async loadMore() {
    this.setState({ loading: true });

    const thisRequest = {};
    this.latestRequest = thisRequest;

    const { queryParams } = this.props;
    const { currentPage, conversations } = this.state;
    const response = await downloadConversations({
      ...queryParams,
      page: currentPage || null,
    });

    if (this.latestRequest === thisRequest) {
      this.setState({
        loading: false,
        conversations: [...conversations, ...response.conversations],
        currentPage: currentPage + 1,
        morePages: currentPage < response.nPages - 1,
      });
    }
  }

  render() {
    const { queryParams: { perPage } } = this.props;
    const { conversations, loading, morePages } = this.state;
    const loadingTextClasses = 'column is-size-4 has-text-weight-light has-text-centered has-text-grey';

    return (
      // eslint-disable-next-line react/jsx-fragments
      <React.Fragment>
        <ExcerptGallery conversations={conversations} />
        {
          loading
            ? <div className={loadingTextClasses}>Loading...</div>
            : null
        }
        {
          !loading && !conversations.length
            ? <div className={loadingTextClasses}>No Results</div>
            : null
        }
        {
          perPage && !loading && conversations.length && morePages
            ? (
              <a className={`${loadingTextClasses} block`} onClick={this.loadMore}>
                Load More
              </a>
            )
            : null
        }
      </React.Fragment>
    );
  }
}

Conversations.propTypes = {
  paged: PropTypes.bool,
  queryParams: PropTypes.shape({
    query: PropTypes.string,
    filterBy: PropTypes.string,
    orderBy: PropTypes.string,
    perPage: PropTypes.number,
    pad: PropTypes.string,
  }).isRequired,
};

Conversations.defaultProps = {
  paged: false,
};
