var map;
var infowindow;
var pos;
  
//finding current location using geoloaction
function initAutoComplete() 
{
	if (navigator.geolocation) 
		navigator.geolocation.getCurrentPosition(show); 
	else 
		window.alert("Browser doesn't support Geolocation");
	function show(position)
	{
		pos = 
		{
			lat: position.coords.latitude,
			lng: position.coords.longitude,
		};
		map = new google.maps.Map(document.getElementById('map'), 
		{
			 center: pos,
			 zoom: 16,
		});  
		//Create marker for new Location.
		var hmarker = new google.maps.Marker({
		map: map,
		icon: {
				  url: 'https://vignette.wikia.nocookie.net/howtoprogram/images/9/9a/Home.png',
				  anchor: new google.maps.Point(11, 11),
				  scaledSize: new google.maps.Size(50, 50)
			  },
		position: pos});
		
		infowindow = new google.maps.InfoWindow();
		infowindow.setPosition(pos);
		infowindow.setContent( '<div><strong>'+ "Your Location" +'</strong></br>');
		infowindow.open(map);
	}
}

function findPlacesAroundMe() 
{
	//if geolocation is not enabled it uses default location
	if (pos === undefined) 
	{
		//window.alert("Couldn't get the current location, use default");
		pos = {lat: -37.8142176 , lng: 144.9631608}
		map = new google.maps.Map(document.getElementById('map'), 
		{
			center: pos,
			zoom: 15
		});
	}
	//the current-location co-ordinates are passed to find the restaurants nearby
	infowindow = new google.maps.InfoWindow();
	var service = new google.maps.places.PlacesService(map);
	service.nearbySearch(
	{
		location: pos,
		radius: 500,
		type: ['restaurant']
	}, callback);

	//20 Restaurants around current-location. 
	function callback(results, status) 
	{
		service = new google.maps.places.PlacesService(map);
		if (status === google.maps.places.PlacesServiceStatus.OK) 
		{
			for (var i = 0; i < 20; i++) 
			{
				createMarker(results[i]);
			}
		}
	}

	//Create Marker for each location.
	function createMarker(place) 
	{
		var placeLoc = place.geometry.location;
		var marker = new google.maps.Marker(
		{
			map: map,
			position: placeLoc
		});

		//The infowindow displays the restaurants name/address when the marker is clicked.
		google.maps.event.addListener(marker, 'click', function() 
		{ 
			infowindow.setContent('<div><strong>' + place.name + '</strong><br>' +
				place.vicinity+ '<br>');
			infowindow.open(map, this);
		});

	}
}
 
 
 
