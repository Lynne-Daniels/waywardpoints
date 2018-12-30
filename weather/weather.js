/* Get the weather and update the page
 *
 * API CALL:  api.openweathermap.org/data/2.5/weather?zip=33418,us&appid=9edbccf035e35ac9403515d616122550 //
 * Documentation:  http://openweathermap.org/current#current_JSON
 */
// Get user's location https://developer.mozilla.org/en-US/docs/Web/API/Geolocation/getCurrentPosition
var options = {
	enableHighAccuracy: false,
	timeout: 5000,
	maximumAge: 0
};

function success(pos)
{
	var crd = pos.coords;
	console.log('Your current position is:');
	console.log('Latitude : ' + crd.latitude);
	console.log('Longitude: ' + crd.longitude);
	console.log('More or less ' + crd.accuracy + ' meters.');
	// $("#users-coords").html("latitude: " + crd.latitude + " longitude: " + crd.longitude);
	getWeather(crd.latitude, crd.longitude); //pass the user's lat/long to the weather ajax request
};

function error(err)
{
	console.warn('ERROR(' + err.code + '): ' + err.message);
	// Chrome will not allow unless https is used.  TODO need a certificate.
	alert('Unable to obtain location.  Chrome does not allow this page. Use Firefox for now');
};
navigator.geolocation.getCurrentPosition(success, error, options);
//https://learn.jquery.com/ajax/jquery-ajax-methods/  Get the weather data
function getWeather(userLat, userLong)
	{
		$.ajax(
			{
				// The URL for the request example:
				//url: "http://api.openweathermap.org/data/2.5/weather?lat=26.8&lon=-80.1&appid=9edbccf035e35ac9403515d616122550&units=imperial",
				url: "http://api.openweathermap.org/data/2.5/weather?lat=" + userLat+"&lon=" + userLong + "&appid=9edbccf035e35ac9403515d616122550&units=imperial",
				// Whether this is a POST or GET request
				type: "GET",
				// The type of data we expect back
				dataType: "json",
			})
			// Code to run if the request succeeds (is done);
			// The response is passed to the function
			.done(function(json)
			{
				$("#users-coords").html(json.name);
				$("#current-weather").text(json.weather[0].main + " " + json.weather[0].description);
				// get temperatue in degrees Farenheit, use button group to control conversion to Centigrade
				temperatureFarenheit = Math.round(json.main.temp);
				$("#temperature").text(temperatureFarenheit + " °F");
				$("#wind").text("Wind Speed:  " + Math.round(json.wind.speed) +
					" MPH Direction:  " + degToCompass(Math.round(json.wind.deg)));
				//transform a number into a date object
				var sunriseDT = new Date(json.sys.sunrise * 1000);
				var sunsetDT = new Date(json.sys.sunset * 1000);
				$("#sunrise-sunset").html("Sunrise: " + sunriseDT.toLocaleString() +
					"<br> Sunset: " + (sunsetDT.toLocaleString()));
				console.log("epoch to string " + sunriseDT.toLocaleString());
				var weatherIcon = "http://openweathermap.org/img/w/" + json.weather[0].icon +
					".png";
				$("#weather-image").html('<img src = ' + weatherIcon +
					' alt = "weather related image"><img>');
				console.log(weatherIcon + " icon" + json.weather[0].icon);
			})
			// Code to run if the request fails; the raw request and
			// status codes are passed to the function
			.fail(function(xhr, status, errorThrown)
			{
				alert("Sorry, there was a problem!");
				console.log("Error: " + errorThrown);
				console.log("Status: " + status);
				console.dir(xhr);
			})
			// Code to run regardless of success or failure;
			.always(function(xhr, status)
			{
				//alert( "The request is complete!" );
			});
	}
	//http://stackoverflow.com/questions/7490660/converting-wind-direction-in-angles-to-text-words

function degToCompass(num)
{
	var val = Math.floor((num / 22.5) + 0.5);
	var arr = ["N", "NNE", "NE", "ENE", "E", "ESE", "SE", "SSE", "S", "SSW", "SW", "WSW", "W", "WNW", "NW", "NNW"];
	return arr[(val % 16)];
}
var temperatureKelvin = 0;
$(document).ready(function()
{
	$('#celcius').on('click', function(e)
	{
		$("#temperature").text(Math.round((temperatureFarenheit - 32) * 5 / 9) +" °C");
	});
	$('#farenheit').on('click', function(e)
	{
		$("#temperature").text(temperatureFarenheit + " °F");
	});
}); //doc ready