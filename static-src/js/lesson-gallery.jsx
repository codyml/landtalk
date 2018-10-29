/*
*   Imports.
*/

import React from 'react'
import LessonExcerpt from './lesson-excerpt.jsx'


/*
*   Constants.
*/

const COLUMNS = [ 0, 1]


/*
*   React component for rendering random lessons.
*/

const LessonGallery = ({ lessons }) => (

    <div className='columns is-multiline'>
        {
            lessons && lessons.length ? COLUMNS.map(columnIndex =>
                <div className='lesson column is-one-half' key={ columnIndex }>
                    {
                        lessons.filter((c, i) => i % COLUMNS.length === columnIndex).map(lesson =>
                            <LessonExcerpt key={ lesson.id } lesson={ lesson } />
                        )
                    }
                </div>
            ) : null
        }
    </div>

)

export default LessonGallery
