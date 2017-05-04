/**
 * Custom map implementation.
 */
function initMap() {

	// default map args
	var defaults = {
		center: { lat: 30, lng: 0 },
		zoom: 2,
		scrollwheel: false,
		minZoom: 2,
		styles: [
			{
				"featureType":"administrative",
				"elementType":"labels.text.fill",
				"stylers":[
					{
						"color":"#7d8d97"
					}
				]
			},
			{
				"featureType":"landscape",
				"elementType":"all",
				"stylers":[
					{
						"color":"#f2f2f2"
					}
				]
			},
			{
				"featureType":"landscape",
				"elementType":"geometry.fill",
				"stylers":[
					{
						"color":"#f3f3f3"
					}
				]
			},
			{
				"featureType":"poi",
				"elementType":"all",
				"stylers":[
					{
						"visibility":"off"
					}
				]
			},
			{
				"featureType":"poi.attraction",
				"elementType":"all",
				"stylers":[
					{
						"visibility":"off"
					}
				]
			},
			{
				"featureType":"poi.park",
				"elementType":"geometry.fill",
				"stylers":[
					{
						"color":"#e6f3d6"
					},
					{
						"visibility":"off"
					}
				]
			},
			{
				"featureType":"road",
				"elementType":"all",
				"stylers":[
					{
						"saturation":-100
					},
					{
						"lightness":45
					},
					{
						"visibility":"off"
					}
				]
			},
			{
				"featureType":"road.highway",
				"elementType":"all",
				"stylers":[
					{
						"visibility":"off"
					}
				]
			},
			{
				"featureType":"road.highway",
				"elementType":"geometry.fill",
				"stylers":[
					{
						"color":"#f4d2c5"
					},
					{
						"visibility":"simplified"
					}
				]
			},
			{
				"featureType":"road.highway",
				"elementType":"labels.text",
				"stylers":[
					{
						"color":"#4e4e4e"
					}
				]
			},
			{
				"featureType":"road.arterial",
				"elementType":"geometry.fill",
				"stylers":[
					{
						"color":"#f4f4f4"
					}
				]
			},
			{
				"featureType":"road.arterial",
				"elementType":"labels.text.fill",
				"stylers":[
					{
						"color":"#787878"
					}
				]
			},
			{
				"featureType":"road.arterial",
				"elementType":"labels.icon",
				"stylers":[
					{
						"visibility":"off"
					}
				]
			},
			{
				"featureType":"transit",
				"elementType":"all",
				"stylers":[
					{
						"visibility":"off"
					}
				]
			},
			{
				"featureType":"water",
				"elementType":"all",
				"stylers":[
					{
						"visibility":"on"
					},
					{
						"hue":"#ff0000"
					},
					{
						"saturation":"-100"
					},
					{
						"lightness":"45"
					}
				]
			},
			{
				"featureType":"water",
				"elementType":"geometry.fill",
				"stylers":[
					{
						"color":"#3c70b4"
					}
				]
			}
		]
	};

	// participating regions
	var pColor   = '#3c70b4';
	var pOpacity = '0.4';

	// hosting region
	var cColor   = '#292e4b';
	var cOpacity = '1.0';

	// initialize map
	var map = new google.maps.Map( document.getElementById( 'map' ), defaults );

	// load data
	map.data.loadGeoJson( techcamp_vars.content_url + '/themes/techcamp/map-data.json.php' );

	// create legend/key
	/* var legend = document.getElementById( 'legend' );
	var legendContainer = document.createElement( 'div' );
	legendContainer.innerHTML = '<p>This is the legend</p>';
	legend.appendChild( legendContainer );
	map.controls[google.maps.ControlPosition.RIGHT_BOTTOM].push(legend); */

	// set marker styles based on each feature's specified icon
	var icon;
	map.data.setStyle( function( feature ) {
		icon = feature.getProperty( 'icon' );
		if ( icon ) {
			return { icon: icon };
		}
	});

	// get all participating regions
	var participators = "'" + techcamp_map_vars.participators.join( "', '" ) + "'";

	// default styles for participating regions
	var pStyle = {
		where: "name IN ( " + participators + " )",
		polygonOptions: {
			fillColor: pColor,
			fillOpacity: pOpacity
		}
	};

	// get all host regions
	var hosts = "'" + techcamp_map_vars.hosts.join( "', '" ) + "'";

	// default styles for host regions
	var hStyle = {
		where: "name IN ( " + hosts + " )",
		polygonOptions: {
			fillColor: cColor,
			fillOpacity: cOpacity
		}
	};

	// global region polygons
	var regions = new google.maps.FusionTablesLayer( {
		map: map,
		query: {
			select: 'geometry',
			from: '1K-eenN5UTU3D7Jj9Wyt6IGkDvUZevrsk8MQUTjUV'
		},
		styleId: 9,
		styles: [ pStyle, hStyle ],
		suppressInfoWindows: true
	} );

	// global info window
	var infoWindow = new google.maps.InfoWindow();

	// info window vars
	var markerName,
		markerDate,
		markerDesc,
		markerURL,
		markerImg;

	// region highlighting vars
	var markerRegion,
		markerParticipators,
		markerStyles;

	// click events
	map.data.addListener( 'click', function( event ) {

		//
		// info window implementation
		//
		markerName = event.feature.getProperty( 'name' );
		markerDesc = event.feature.getProperty( 'desc' );
		markerDate = event.feature.getProperty( 'date' );
		markerURL  = event.feature.getProperty( 'url' );
		markerImg  = event.feature.getProperty( 'img' );

		infoWindow.setContent(
			'<div class="map__info">'
			+ markerImg
			+ '<div class="map__text">'
			+ '<h2 class="map__head"><a href="' + markerURL + '">' + markerName + '</a></h2>'
			+ ( markerDate ? '<div class="map__date">' + markerDate + '</div>' : '' )
			+ '<div class="map__desc">' + markerDesc + '</div>'
			+ '</div><!-- .map__info -->'
			+ '</div><!-- .map__text -->' );

		// attach infoWindow to marker
		infoWindow.setPosition( event.feature.getGeometry().get() );
		infoWindow.setOptions( { pixelOffset: new google.maps.Size( 0, -45 ) } );

		// trigger the opening
		infoWindow.open( map );

		//
		// region highlighting implementation
		//
		markerRegion = event.feature.getProperty( 'c1' );
		markerParticipators = event.feature.getProperty( 'c2' );
		markerStyles = [];

		// participating regions highlighting
		if ( markerParticipators.length ) {

			markerParticipators = "'" + markerParticipators.join( "', '" ) + "'";

			markerStyles.push( {
				where: "name IN ( " + markerParticipators + " )",
				polygonOptions: {
					fillColor: pColor,
					fillOpacity: pOpacity
				}
			} );

		}

		// techcamp region highlighting
		markerStyles.push( {
			where: "name = '" + markerRegion + "'",
			polygonOptions: {
				fillColor: cColor,
				fillOpacity: cOpacity
			}
		} );

		regions.set( 'styles', markerStyles );

		//
		// zoom behavior
		//
		/* if ( map.getZoom() < 4 ) {
			map.setZoom( 4 );
		} */

	} );

}
