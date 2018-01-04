/*
*   Imports.
*/

import React from 'react'
import { downloadAllConversations } from './rest.js'
import { GOOGLE_MAPS_JS_API_KEY } from '../.env.js'
import markerIcon from '../img/marker.png'
import markerGroupIcon from '../img/marker-group.png'


/*
*   Returns a promise for loading the Google Maps JS API.
*/

const loadGoogleMapsAPI = () => new Promise(resolve => {

    window.googleMapsAPILoaded = resolve
    const element = document.createElement('script')
    element.type = 'text/javascript'
    element.src = `https://maps.googleapis.com/maps/api/js?key=${ GOOGLE_MAPS_JS_API_KEY }&callback=googleMapsAPILoaded`
    document.body.appendChild(element)
    
})


/*
*   Styles for the map.
*/

const MAP_STYLES = [
    { 
        elementType: 'labels',
        stylers: [ { visibility: 'off' } ],
    },
    {
        featureType: 'administrative.land_parcel',
        stylers: [ { visibility: 'off' } ],
    },
    {
        featureType: 'administrative.neighborhood',
        stylers: [ { visibility: 'off' } ],
    },
    {
        featureType: 'road',
        stylers: [ { visibility: 'off' } ],
    },
]


/*
*   React component for the map of conversations.
*/

export default class ConversationMap extends React.Component {

    constructor(props) {

        super(props)
        this.createMap = this.createMap.bind(this)
        this.addMarkers = this.addMarkers.bind(this)

    }


    /*
    *   Creates the map as soon as the DOM element is ready.
    */

    createMap(element) {

        if (element) {

            loadGoogleMapsAPI()
            .then(() => {

                this.map = new google.maps.Map(element, {
                    zoom: 2,
                    center: new google.maps.LatLng(39.8282, -98.5795),
                    streetViewControl: false,
                    mapTypeControl: false,
                })

                const styledMapType = new google.maps.StyledMapType(MAP_STYLES, { name: 'Styled Map' })
                this.map.mapTypes.set('styled_map', styledMapType)
                this.map.setMapTypeId('styled_map')
                this.infoWindow = new google.maps.InfoWindow()

            })
            .then(downloadAllConversations)
            .then(conversations => this.addMarkers(conversations))
            .catch(console.error.bind(console))

        }
    
    }


    /*
    *   Adds markers to the map from Conversation data.
    */

    addMarkers(conversations) {

        const markers = conversations.map(conversation => {

            const position = new google.maps.LatLng(conversation.location.latitude, conversation.location.longitude)
            const icon = {
                url: markerIcon,
                scaledSize: { width: 38, height: 60 }
            }

            const infoWindowContent = `
                <div class="map-popup-title">${ conversation.place_name }</div>
                <a href="${ conversation.link }" class="map-popup-link">Click for conversation</a>
            `
            
            const marker = new google.maps.Marker({ position, icon })
            marker.addListener('click', () => {
                this.infoWindow.setContent(infoWindowContent)
                this.infoWindow.open(this.map, marker)
            })

            return marker

        })

        new MarkerClusterer(this.map, markers, {
            styles: [
                {
                    url: markerGroupIcon,
                    height: 65,
                    width: 49,
                    textColor: '#fff',
                    textSize: 13,
                    anchorText: [ -3, -1 ], 
                },
            ],
            enableRetinaIcons: true,
        })

    }


    /*
    *   Renders the map wrapper.
    */

    render() {
        return (
            <div>
                <div className="map-wrapper" ref={this.createMap}>Map</div>
                <div className="map-subtitle">
                    Click a marker group <img src={markerGroupIcon} /> to zoom in on the map and explore conversations.
                </div>
            </div>
        )
    }

}
