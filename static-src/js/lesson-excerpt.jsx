/*
*   Imports.
*/

import React from 'react'


/*
*   Constants.
*/

const MAX_SYNOPSIS_EXCERPT_LENGTH = 200


/*
*   React component for a single Lesson.
*/

const LessonExcerpt = ({ lesson }) => {

    let synopsis = lesson.synopsis
    if (synopsis.length > MAX_SYNOPSIS_EXCERPT_LENGTH) {

        synopsis = synopsis.slice(0, MAX_SYNOPSIS_EXCERPT_LENGTH)
        const lastSpaceIndex = synopsis.lastIndexOf(' ')
        synopsis = synopsis.slice(0, lastSpaceIndex) + '...'

    }

    return (
        <a href={ lesson.link } className='lesson-excerpt'>
            <div className='card'>
                <div className='card-image'>
                    <figure className='image is-square' style={{ backgroundImage: `url('${ lesson.image_url }')` }} />
                </div>
                <div className='card-content'>
                    <div className='has-space-below'>{ lesson.lesson_title }</div>
                    <div className='content' dangerouslySetInnerHTML={ { __html: synopsis } }></div>
                    <div className='details'>
                      <span>{lesson.subject} </span>
                      <span>{lesson.subject_2} </span>
                      <span>{lesson.grade}</span>
                    </div>
                </div>
            </div>
        </a>
    )

}

export default LessonExcerpt
