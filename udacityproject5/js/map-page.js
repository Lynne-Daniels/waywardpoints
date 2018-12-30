/*********************************
 
Lots going on here:
	1. Page uses knockout to link a search box with a list of search terms.
	2. Has a google map with a track and markers
		a. Track is an XML file
		b. Markers are in separate JSON file, but also repeated here in the code for easy testing w/o cross origin issues.
	3. Data from www.strava.com shows riders who have ridden a section of the course.
		a. Segment definition provided by Strava.  We have to find or upload new segments for any new pages.
	4. An infowindow describing the marker's location pulls data from TripAdvisor API to list local POI.
		a. TripAdvisor API key is for testing only.  Must show them the final page to get approval to publish.
		b. markers also have static content in their "html" attribute, which precedes the TripAdvisor Listings
		
TODO -- in the future, grab data about who is currently on the route in realtime from Spot, Garmin, Facebook, Foursquare, LDSCycling
	
expects JSON file with waypoint data where each waypoint has "title", "lat", "lng", "z", "info" properties.  don't need the z?
the JSON has data for the map markers and search terms only, the track is in a KML file 
***************/
var wptData = jQuery.getJSON('gpsdata/palm-beach-epic-wpts.json', function(json) {
		//	console.log("wptData", wptData); <--- use that to troubleshoot data
});

//Chrome errouniously thinks my local file violates cross origin policy and will not read my local json file 
// This data is a backup to be used when there is an Error.  Can remove if json file works on the webhosting server

if (wptData.statusText !== 'OK') {
	//	console.log("unable to access json file because Chrome cross origin funny. Using data from the js file.");
	wptData = {
		
			"waypoints": [{
				"title": "Grocery - Jupiter Farms",
				"lat": 26.94151,
				"lng": -80.19283,
				"z": 1,
				"info": "<p>Suburban mall has a McDonald's, a Publix grocery Store, and a convenience store.  The pizza at the gas station is surprisingly good.</p>"
			}, {
				"title": "Grocery - Acreage",
				"lat": 26.78158,
				"lng": -80.29298,
				"z": 2,
				"info": "<p>Suburban mall has a Subway, a Publix grocery, a restaurant serving breakfast, and more.</p>"
			}, {
				"title": "Entrance Fee - Corbett WMA North",
				"lat": 26.94388,
				"lng": -80.35478,
				"z": 3,
				"info": "<p><a href= 'http://myfwc.com/viewing/recreation/wmas/lead/jw-corbett/'>J.W. Corbett Wildlife Management Area</a></p>"
			}, {
				"title": "Entrance Fee - Corbett WMA South",
				"lat": 26.85385,
				"lng": -80.29225,
				"z": 4,
				"info": "<p><a href= 'http://myfwc.com/viewing/recreation/wmas/lead/jw-corbett/'>J.W. Corbett Wildlife Management Area</a></p>"
			}]
		};
}

//KML file contains the data for a track to be drawn on the map.  Users will travel along this track.
var trackLayer = new google.maps.KmlLayer({
	//copy is in url: '/gpsdata/palm-beach-epic.kml', but the google can't see it there
	url: 'http://floridabiketrail.org/gpsdata/palm-beach-epic-jupiter-start10.kml'
});

function createMap(track, waypoints) {
	var mapOptions = {
		zoom: 11,
		center: {
			lat: 26.859722,
			lng: -80.251944
		},
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	//TODO calculate center of map from waypoints?	
	var activeMap = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
	track.setMap(activeMap);

	//adds all the waypoints in [gpsdata/samefilename.json]	to the googlemap
	var i = 0;
	var markers = [];

	for (waypoints in wptData.waypoints) {
		if (wptData.waypoints.hasOwnProperty(waypoints)){
			var myLatlng = new google.maps.LatLng(wptData.waypoints[i].lat, wptData.waypoints[i].lng);
			var infowindow = new google.maps.InfoWindow({
				content: ""
			});
			var marker = new google.maps.Marker({
				position: myLatlng,
				title: wptData.waypoints[i].title,
				visible: true,
				html: wptData.waypoints[i].info,
				map: activeMap
			});
			markers.push(marker);
		//	console.log("markerarray", markers[i]);
			google.maps.event.addListener(markers[i], 'click', function() {
	
				loadTripAdvisor(this, this.position.A, this.position.F, 0.5, infowindow, activeMap);
			
			});
		}
		i++;
		
	}
	return markers;
}

function loadTripAdvisor(marker, lat, lng, distance, infowindow, activeMap){
	var tripAdvisorUrl = 'http://api.tripadvisor.com/api/partner/2.0/map/'+lat+','+lng+'?key=a2ff485704cd4a168145dc9772247229&distance='+distance;

  $.ajax({
    url: tripAdvisorUrl,
    type: "GET",
    dataType: "json",
    success: function(json)
		{
			var poiHTML = ''; // a big string containing all the HTML to make a list of local services
			function buildTripAdvisorPOIList(){
				var poi;
				if (json.data.length == 0)
					{poiHTML = 'TripAdvisor found no items within a half mile of this location.';}
				else{
					for (var i = 0; i < json.data.length; i++)
						{poi = ('<a href="'+json.data[i].web_url+'"'+'class="list-group-item"><h4 class="list-group-item-heading">'+
						json.data[i].category.localized_name+': '+json.data[i].name+'</h4><p class="list-group-item-text">'+
						json.data[i].address_obj.address_string +'</p><p class="list-group-item-text">'+
						json.data[i].distance+' miles to the ' +json.data[i].bearing+'</p></a>');
						poiHTML = poiHTML + poi;
						}}
				
			}
			buildTripAdvisorPOIList();
//TripAdvisor **requires** that its listings be preceeded by the following item
			var tripAdvisorPOI = ('powered by <img class = "trip-advisor-in-infomarker" src = "http://www.tripadvisor.com/img/cdsi/langs/en/tripadvisor_logo_transp_280x60-MCID-0.png">'+
				'<div class="list-group">'+poiHTML+ '</div>');
			
			infowindow.setContent(marker.html + tripAdvisorPOI);
					
			infowindow.open(activeMap, marker);

		},
	
	    // Code to run if the request fails; the raw request and
    // status codes are passed to the function
    error: function( xhr, status, errorThrown ) {
        infowindow.setContent(marker.html+'TripAdvisor data not availale'+'</div>');
        infowindow.open(activeMap, marker);
        console.log( 'Error: ' + errorThrown );
        console.log( 'Status: ' + status );
        console.dir( xhr );
    },
 
    // Code to run regardless of success or failure, could put 2nd API here maybe?
    //complete: function( xhr, status ) {
        //console.log( "The travelocity request is complete!" );
    //}
  });	
}

//TODO makelowercase search work -- converttolowercase or something like that
//This function filters the displayed waypoints on the list to only show items matching a user search
ko.observableArray.fn.filterBySearchTerm = function(propName, matchValue) {
	return ko.pureComputed(function() {
		var allItems = this(),
			matchingItems = [];
		for (var i = 0; i < allItems.length; i++) {
			var current = allItems[i];
			if ((((ko.unwrap(current)[propName])().indexOf(matchValue())) > (-1)) || (matchValue() == undefined)) {
				matchingItems.push(current);
			}
		}
		return matchingItems;
	}, this);
};

function Waypoint(title, lat, lng, z) {
	this.title = ko.observable(title);
	this.lat = ko.observable(lat);
	this.lng = ko.observable(lng);
	this.z = ko.observable(z);
}

function AppViewModel() {
	//TODO change this to use data from the JSON 	Use "with" and a loop so can have any num wpts??
	//Not sure I will use the search feature on other pages, so not doing the change now.
	//See how the first one grabs the title -- can do for all the others too
	//Don't need the lat/lng here anymore since map does not use KO, but will leave here in case there is future use
	this.searchTerm = ko.observable();
	this.waypoints = ko.observableArray([
		new Waypoint(wptData.waypoints[0].title, 26.94151, -80.19283, 1),
		new Waypoint('Grocery - Acreage', 26.78158, -80.29298, 2),
		new Waypoint('Entrance Fee - Corbett WMA North', 26.94388, -80.35478, 3),
		new Waypoint('Entrance Fee - Corbett WMA South', 26.85385, -80.29225, 4)
	]);

	// Here's where the list items are filtered by the search term

	this.searchedWaypoints = this.waypoints.filterBySearchTerm("title", this.searchTerm);

}

var viewModel = new AppViewModel();

//Strava shows the history of cyclists that have ridden a portion of the route.  I did make another strava segment that shows riders that did the entire ride, but as it is new, i am the only rider so far.  Also, i need to check that road consruction has not altered the route beforeI publish.  Better this short segment, 1179271, to test the code.  9583770 is the segment for the whole ride.
function loadStrava() {

	var stravaUrl = 'https://www.strava.com/api/v3/segments/1179271/leaderboard?&access_token=5a056ffacbea314928b43827ec071886b170dfeb&callback=stravaCallback';
	var stravaRequestTimeout = setTimeout(function() {
		$('#strava-header').text('Strava Data Did Not Download -- Refresh to Try Again');
		$('#strava-header').css('color', 'red');
		console.log('strava failed');
	}, 8000);
	$.ajax({
		url: stravaUrl,
		dataType: 'jsonp',
		success: function(response) {
			var leaderList = response;
			for (var i = 0; i < leaderList.entries.length; i++) {
// TODO For this to work, must have avatar/athlete/large.png (This is a kludge - Strava's API returns a local path when there is no image.  Should be updated to use CSS/HTML instead.)

				$('#strava-container').append('<div class = "row stravaRider"><div class = "col-xs-4"><img class="profilepic"src ="' + leaderList.entries[i].athlete_profile + '"></div>' + '<div class = "col-xs-8"><table><tr><th class="left-column">Name:  </th><td class="right-column">' + leaderList.entries[i].athlete_name + '</td></tr><tr><th>Date: </th><td>' + leaderList.entries[i].start_date_local + '</td></tr><tr><th>Time: </th><td>' + (leaderList.entries[i].elapsed_time / 60) + '</td></tr></table></div></div>');

			}

			clearTimeout(stravaRequestTimeout);

		}
	});
	return false;
}

//initialize and create a Google Map
wptData.allTheMarkers = "";
$(document).ready(wptData.allTheMarkers = function() {
	var mmarkers = createMap(trackLayer, wptData.waypoints);
	ko.applyBindings(viewModel);
	loadStrava();
	return mmarkers;
}());

$("#searching").keyup(function() {

	filterMapMarkers();

});
//Map will only show markers that contain the search term
//TODO makelowercase search
function filterMapMarkers() {

	for (var i in wptData.allTheMarkers) {

		if (((wptData.allTheMarkers[i].title.indexOf($("#searching").val())) > -1) || ($("#searching") == undefined || null)) {
			wptData.allTheMarkers[i].setVisible(true);
		} else {
			wptData.allTheMarkers[i].setVisible(false);
		}
	}

}