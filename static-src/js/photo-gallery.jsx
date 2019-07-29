/*
*   Imports.
*/

import React from 'react'
import ReactDOM from 'react-dom'


/*
*   React component for rendering a gallery of photos with a lightbox
*   view.
*/

export default class PhotoGallery extends React.Component {

    constructor() {
        super()
        this.state = { lightboxPhotoUrl: null }
        this.openLightbox = this.openLightbox.bind(this)
        this.closeLightbox = this.closeLightbox.bind(this)
    }

    openLightbox(url) {
        document.body.parentElement.classList.add('modal-open')
        this.setState({ lightboxPhotoUrl: url })
    }

    closeLightbox() {
        document.body.parentElement.classList.remove('modal-open')
        this.setState({ lightboxPhotoUrl: null })
    }

    render() {
        return (
            <React.Fragment>
                <ul className='columns is-multiline reflection-gallery'>
                    {
                        (this.props.imageUrls || []).map(url => (
                            <li
                                className='column is-one-third reflection-gallery-image'
                                style={{ backgroundImage: `url(${url})` }}
                                onClick={() => this.openLightbox(url)}
                                key={url}
                            />
                        ))
                    }
                </ul>
                {
                    this.state.lightboxPhotoUrl ? ReactDOM.createPortal(
                        (
                            <div
                                className="photo-gallery-lightbox"
                                onClick={this.closeLightbox}
                            >
                                <div className="photo-gallery-lightbox-content">
                                    <img
                                        className="photo-gallery-lightbox-photo"
                                        src={this.state.lightboxPhotoUrl}
                                        onClick={e => e.stopPropagation()}
                                    />
                                </div>
                            </div>
                        ),
                        document.getElementById('react-modal-container'),
                    ) : null
                }
            </React.Fragment>
        )
    }

}
