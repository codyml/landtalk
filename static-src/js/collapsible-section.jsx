/*
*   Imports.
*/

import React from 'react'


/*
*   React component for a collapsible section.
*/

const CollapsibleSection = ({ collapsed, title, children, titleContent, toggleCollapsed }) => (

    <div className='collapsible-section'>
        <div className='columns section-title'>
            <div className='column is-three-quarters is-size-4 has-text-weight-light' onClick={ toggleCollapsed }>
                <span className='disclosure-triangle'>{ collapsed ? '▸' : '▾' }</span>
                <span className='section-title-text'>{ title }</span>
            </div>
            <div className='column is-one-quarter'>{ titleContent }</div>
        </div>
        <hr />
        { collapsed ? null : children }
    </div>

)

export default CollapsibleSection
