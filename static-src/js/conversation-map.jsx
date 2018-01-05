/*
*   Imports.
*/

import React from 'react'
import { downloadAllConversations } from './rest.js'
import { GOOGLE_MAPS_JS_API_KEY } from '../.env.js'
import markerIcon from '../img/marker.png'
import selectedMarkerIcon from '../img/selected-marker.png'
import markerGroupIcon from '../img/marker-group.png'


/*
*   Returns a promise for loading the Google Maps JS API.
*/

const loadGoogleMapsAPI = () => new Promise(resolve => {

    if (window.google) resolve()
    else {
        window.googleMapsAPILoaded = resolve
        const element = document.createElement('script')
        element.type = 'text/javascript'
        element.src = `https://maps.googleapis.com/maps/api/js?key=${ GOOGLE_MAPS_JS_API_KEY }&libraries=geometry&callback=googleMapsAPILoaded`
        document.body.appendChild(element)
    }
    
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
        this.handleSelectedMarker = this.handleSelectedMarker.bind(this)
        this.findNearestMarkers = this.findNearestMarkers.bind(this)
        this.clusterMarkers = this.clusterMarkers.bind(this)

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
            .then(this.handleSelectedMarker)
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
                scaledSize: { width: 38, height: 60 },
            }

            const infoWindowContent = `
                <div class="map-popup-title">${ conversation.place_name }</div>
                <a href="${ conversation.link }" class="map-popup-link">Click for conversation</a>
            `
            
            const mapMarker = new google.maps.Marker({ position, icon })
            if (!this.props.miniMap) {

                mapMarker.addListener('click', () => {
                    this.infoWindow.setContent(infoWindowContent)
                    this.infoWindow.open(this.map, mapMarker)
                })

            }

            mapMarker.setMap(this.map)
            return { id: conversation.id, position, mapMarker, infoWindowContent }

        })

        this.markers = {}
        markers.forEach(({ id, position, mapMarker, infoWindowContent }) => {
            this.markers[id] = { position, mapMarker, infoWindowContent }
        })

    }


    /*
    *   Zooms into and opens the popup for the selected marker.
    */

    handleSelectedMarker() {

        if (this.props.selectedMarker && this.markers[this.props.selectedMarker]) {

            const { position, mapMarker, infoWindowContent } = this.markers[this.props.selectedMarker]

            //  Makes selected marker larger
            const icon = {
                url: selectedMarkerIcon,
                scaledSize: { width: 56, height: 86 },
            }

            mapMarker.setIcon(icon)

            //  Zooms into the mapMarker and closest other 2 mapMarkers
            const [ originalPosition, closestPosition, secondClosestPosition ] = this.findNearestMarkers(position, 3)
            const bounds = (new google.maps.LatLngBounds(originalPosition, closestPosition)).extend(secondClosestPosition)
            this.map.fitBounds(bounds, 50)

            //  Opens info window and sets up marker clustering if full-size map
            if (!this.props.miniMap) {
                
                this.infoWindow.setContent(infoWindowContent)
                this.infoWindow.open(this.map, mapMarker)
                let listener
                setTimeout(() => listener = this.map.addListener('bounds_changed', () => {
                    this.clusterMarkers()
                    google.maps.event.removeListener(listener)
                }), 500)
            
            } else this.map.setOptions({ gestureHandling: 'none', zoomControl: false })

        } else this.clusterMarkers()

    }


    /*
    *   Orders markers by distance to a marker, returning the closest two.
    */

    findNearestMarkers(position, nClosest) {

        const positions = Object.values(this.markers).map(marker => marker.position)
        const sortedPositions = positions.sort((a, b) => {

            const dA = google.maps.geometry.spherical.computeDistanceBetween(position, a)
            const dB = google.maps.geometry.spherical.computeDistanceBetween(position, b)
            return dA - dB

        })

        return sortedPositions.slice(0, nClosest)

    }


    /*
    *   Clusters the markers with the MarkerClustererPlus library.
    */

    clusterMarkers() {

        const mapMarkers = Object.values(this.markers).map(({ mapMarker }) => mapMarker)
        mapMarkers.forEach(mapMarker => mapMarker.setMap(null))
        new MarkerClusterer(this.map, mapMarkers, {
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


    render() {
        return (
            <React.Fragment>
                <div className="map-wrapper" ref={this.createMap}>Map</div>
                <div className="map-subtitle">
                    Click a marker group <img src={markerGroupIcon} /> to zoom in on the map and explore conversations.
                </div>
            </React.Fragment>
        )
    }

}
