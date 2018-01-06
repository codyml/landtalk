/*
*   Webpack entrypoint: imports static assets that will be bundled
*   into theme 'static' directory.
*/

/*
*   Imports React components for front-end interactivity.
*/

import ConversationMap from './js/conversation-map.jsx'
import FeaturedConversations from './js/featured-conversations.jsx'
import ConversationArchive from './js/conversation-archive.jsx'
import MiniConversationMap from './js/mini-conversation-map.jsx'
const components = {
    ConversationMap,
    FeaturedConversations,
    ConversationArchive,
    MiniConversationMap,
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
        if (Component) ReactDOM.render(<Component postId={ element.dataset.postId } />, element)

    })

})


/*
*   Adds interactivity to the Submit form.
*/

// import addSubmitFormInteractivity from './js/submit-form.js'
// if (location.pathname === '/submit-conversation/') {

//     document.addEventListener('DOMContentLoaded', addSubmitFormInteractivity)

// }


/*
*   Compiles Sass styles with Bulma framework.
*/

import './styles/base.scss'
