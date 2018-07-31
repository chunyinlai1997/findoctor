<style>
	#map {
  height: 600px;
  width: 100%;
	}
</style>

<script>

 function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
    center: new google.maps.LatLng(22.302847,114.178419),
    zoom: 11
  });
	var infoWindow = new google.maps.InfoWindow;

	// Change this depending on the name of your PHP or XML file
	downloadUrl('map_generate.php', function(data) {
	  var xml = data.responseXML;
	  var markers = xml.documentElement.getElementsByTagName('marker');
	  Array.prototype.forEach.call(markers, function(markerElem) {
		 var image = markerElem.getAttribute('image');  
	    var name = markerElem.getAttribute('name');
	    var address = markerElem.getAttribute('address');
	    var phone = markerElem.getAttribute('phone');
			var district = markerElem.getAttribute('district');
	    var point = new google.maps.LatLng(
	    parseFloat(markerElem.getAttribute('lat')),
	    parseFloat(markerElem.getAttribute('lng')));

	    var infowincontent = document.createElement('div');
	    var strong = document.createElement('strong');
	    strong.textContent = name
		
		var path = "img/"+image;

		 var img = document.createElement("IMG");
				img.setAttribute("src", path);
				img.setAttribute("width", "50");
				img.setAttribute("height", "50");
		infowincontent.appendChild(img);
	    infowincontent.appendChild(strong);
	    infowincontent.appendChild(document.createElement('br'));

	    var text = document.createElement('text');
	    text.textContent = address
	    infowincontent.appendChild(text);

	    var marker = new google.maps.Marker({
	      map: map,
	      position: point,

	    });
	    marker.addListener('click', function() {
	      infoWindow.setContent(infowincontent);
	      infoWindow.open(map, marker);
				var pos = map.getZoom();
			  map.setZoom(20);
			  map.setCenter(marker.getPosition());
	    });
	  });
	});
	}
</script>

<div id="map"></div>



 