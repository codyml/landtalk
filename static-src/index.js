/*
*   Webpack entrypoint: imports static assets that will be bundled
*   into theme 'static' directory.
*/

/*
*   Imports React components for front-end interactivity.
*/

import ConversationMap from './js/conversation-map.jsx'
import FeaturedConversations from './js/featured-conversations.jsx'
const components = {
    ConversationMap,
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
        if (Component) ReactDOM.render(<Component />, element)

    })

})


/*
*   Compiles Sass styles with Bulma framework.
*/

import './styles/base.scss'
