import React from 'react'
import ReactDOM from 'react-dom'

const MyFirstComponent = () => (
    <div className="button is-primary">React is working!</div>
)

document.addEventListener('DOMContentLoaded', () => {

    const element = document.getElementById('react')
    if (element) {
        ReactDOM.render(<MyFirstComponent />, element)
    }

})

