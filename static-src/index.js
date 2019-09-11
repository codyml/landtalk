/*
*   Webpack entrypoint: imports static assets that will be bundled
*   into theme 'static' directory.
*/

/*
*   Imports React components for front-end interactivity.
*/

import ConversationMap from './js/conversation-map.jsx'
import ConversationArchive from './js/conversation-archive.jsx'
import MiniConversationMap from './js/mini-conversation-map.jsx'
import RelatedConversations from './js/related-conversations.jsx'
import LessonArchive from './js/lesson-archive.jsx'
import ExcerptGallery from './js/excerpt-gallery.jsx'
import PhotoGallery from './js/photo-gallery.jsx'
import FeaturedConversations from './js/featured-conversations.jsx'
const components = {
    ConversationMap,
    ConversationArchive,
    MiniConversationMap,
    RelatedConversations,
    LessonArchive,
    ExcerptGallery,
    PhotoGallery,
    FeaturedConversations,
}


/*
*   Renders React components.
*/

import React from 'react'
import ReactDOM from 'react-dom'
document.addEventListener('DOMContentLoaded', () => {

    const elements = [ ...document.getElementsByClassName('react-component') ]
    elements.forEach(element => {

        const Component = components[element.dataset.componentName]
        if (Component) {

            const props = element.dataset.componentProps ? JSON.parse(element.dataset.componentProps) : {}
            ReactDOM.render(<Component {...props} />, element)

        }

    })

})


/*
*   Adds interactivity to the Submit form.
*/

import addSubmitFormInteractivity from './js/submit-form.js'
if (location.pathname === '/submit-conversation/' && location.search.indexOf('conversation') === -1) {
    document.addEventListener('DOMContentLoaded', addSubmitFormInteractivity)
}


/*
*   Compiles Sass styles with Bulma framework.
*/

import './styles/base.scss'
