/*
*   Imports.
*/

import { loadGoogleMapsAPI } from './conversation-map.jsx'


/*
*   Adds a Google Maps embed with the selected location.
*/

const setupLocationPreview = () => {
    
    loadGoogleMapsAPI().then(() => {

        const latitude = document.querySelector('#submit-form-latitude input')
        const longitude = document.querySelector('#submit-form-longitude input')
        const locationPreview = document.querySelector('#submit-form-location-preview')
        locationPreview.innerHTML = `
            <div id="submit-form-location-preview-map"></div>
            <div class="is-size-6" id="submit-form-location-preview-title">
        `

        new google.maps.Map(element, {
            zoom: 2,
            center: new google.maps.LatLng(39.8282, -98.5795),
            streetViewControl: false,
            mapTypeControl: false,
            fullscreenControl: false,
        })

    })


    console.log(latitude, longitude, locationPreview)

}


/*
*   Adds a preview of the YouTube video.
*/

const setupVideoPreview = () => {
    
    

}

export default () => {
    setupLocationPreview()
    setupVideoPreview()
}
