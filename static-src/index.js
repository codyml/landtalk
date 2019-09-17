/*
*   Webpack entrypoint: imports static assets that will be bundled
*   into theme 'static' directory.
*/

/*
*   Compiles Sass styles with Bulma framework.
*/

import './styles/base.scss';


/*
*   Imports React and React components for front-end interactivity.
*/

import React from 'react';
import ReactDOM from 'react-dom';

import addSubmitFormInteractivity from './js/submit-form';

import ConversationMap from './js/conversation-map';
import ConversationArchive from './js/conversation-archive';
import MiniConversationMap from './js/mini-conversation-map';
import RelatedConversations from './js/related-conversations';
import LessonArchive from './js/lesson-archive';
import ExcerptGallery from './js/excerpt-gallery';
import PhotoGallery from './js/photo-gallery';
import FeaturedConversations from './js/featured-conversations';

const components = {
  ConversationMap,
  ConversationArchive,
  MiniConversationMap,
  RelatedConversations,
  LessonArchive,
  ExcerptGallery,
  PhotoGallery,
  FeaturedConversations,
};


/*
*   Renders React components.
*/

document.addEventListener('DOMContentLoaded', () => {
  const elements = [...document.getElementsByClassName('react-component')];
  elements.forEach((element) => {
    const Component = components[element.dataset.componentName];
    if (Component) {
      const props = element.dataset.componentProps
        ? JSON.parse(element.dataset.componentProps)
        : {};
      ReactDOM.render(
        React.createElement(Component, props, null),
        element,
      );
    }
  });
});


/*
*   Adds interactivity to the Submit form.
*/

if (
  window.location.pathname === '/submit-conversation/'
  && window.location.search.indexOf('conversation') === -1
) {
  document.addEventListener('DOMContentLoaded', addSubmitFormInteractivity);
}
