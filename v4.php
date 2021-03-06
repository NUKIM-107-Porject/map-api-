<!DOCTYPE html>
<html>
    <head>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg&libraries=places&callback=createMap" async defer></script>
        <style>
            html,
            body,
            #map {
                height: 99%;
                margin: 0;
                padding: 0;
            }
        </style>
    </head>


    <body>
        <?php include('DBconnection.php')?>
        <form>
            <input type="button" value="cafe" onclick="cafe();"/>
            <input type="button" value="hospital" onclick="hospital();"/>
            <input type="button" value="restaurant" onclick="restaurant();"/>
            <input type="button" value="pharmacy" onclick="pharmacy();"/>
            <input type="button" value="convenience_store" onclick="convenience_store();"/>
            <input type="button" value="supermarket" onclick="supermarket();"/>
            <input type="button" value="parking" onclick="parking();"/>
            <input type="button" value="doctor" onclick="doctor();"/>
            <input type="button" value="currentLoc" onclick="getCurrentLoc();"/>

        </form>
        <div id="map"></div>
        <script>

            var map;
            var infoWindow;
            var infowindow;
            var request;
            var pos;
            var markers=[];
            var marker;
            var infoObj=[];
            var geocoder;
            var response;
            var responseDiv;



            function createMap() {
                map = new google.maps.Map(document.getElementById('map'), {
                    center: {
                        lat: 22.687370,
                        lng: 120.301476
                    },
                    zoom: 14
                });

                getCurrentLoc();

                geocoder=new google.maps.Geocoder();
                const inputText = document.createElement("input");

                inputText.type = "text";
                inputText.placeholder = "Enter a location";
              
                const submitButton = document.createElement("input");
              
                submitButton.type = "button";
                submitButton.value = "Geocode";
                submitButton.classList.add("button", "button-primary");
              
                const clearButton = document.createElement("input");
              
                clearButton.type = "button";
                clearButton.value = "Clear";
                clearButton.classList.add("button", "button-secondary");
                response = document.createElement("pre");
                response.id = "response";
                response.innerText = "";
                responseDiv = document.createElement("div");
                responseDiv.id = "response-container";
                responseDiv.appendChild(response);
              
                map.controls[google.maps.ControlPosition.TOP_LEFT].push(inputText);
                map.controls[google.maps.ControlPosition.TOP_LEFT].push(submitButton);
                map.controls[google.maps.ControlPosition.TOP_LEFT].push(clearButton);
                marker = new google.maps.Marker({
                  map,
                });
                map.addListener("click", (e) => {
                  geocode({ location: e.latLng });
                });
                submitButton.addEventListener("click", () =>
                  geocode({ address: inputText.value })
                );
                clearButton.addEventListener("click", () => {
                  clear();
                });
                clear();
            }            


            function getCurrentLoc(){
                infoWindow = new google.maps.InfoWindow({map: map});
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        pos = {
                            lat: position.coords.latitude,
                            lng: position.coords.longitude
                        };

                        infoWindow.setPosition(pos);
                        infoWindow.setContent('Location found.');
                        map.setCenter(pos);

                    }, function() {
                        handleLocationError(true, infoWindow, map.getCenter());
                    });
                } else {
                    // Browser doesn't support Geolocation
                    handleLocationError(false, infoWindow, map.getCenter());
                }
            }


            function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                infoWindow.setPosition(pos);
                infoWindow.setContent(browserHasGeolocation ?
                                    'Error: The Geolocation service failed.' :
                                    'Error: Your browser doesn\'t support geolocation.');
            }

            function geocode(request) {
                clear();
                geocoder
                  .geocode(request)
                  .then((result) => {
                    const { results } = result;
              
                    map.setCenter(results[0].geometry.location);
                    for (var i = 0; i < results.length; i++) {
                        marker.setPosition(results[i].geometry.location);
                    }

                    marker.setMap(map);
                    responseDiv.style.display = "block";
                    response.innerText = JSON.stringify(result, null, 2);
                    return results;
                  })
                  .catch((e) => {
                    alert("Geocode was not successful for the following reason: " + e);
                  });
            }

            function clear() {
                marker.setMap(null);
                responseDiv.style.display = "none";
            }
            
            function cafe(){
                deleteMarkers();

                var request = {
                    location: map.getCenter(),
                    radius: 1500,
                    types: ["cafe"]
                }

                var service = new google.maps.places.PlacesService(map);

                service.nearbySearch(request, callback);
            }

            function hospital(){

                deleteMarkers();

                var request = {
                    location: map.getCenter(),
                    radius: 1500,
                    types: ["hospital"]
                }

                var service = new google.maps.places.PlacesService(map);

                service.nearbySearch(request, callback);
            }

            function restaurant(){
                deleteMarkers();

                var request = {
                    location: map.getCenter(),
                    radius: 1500,
                    types: ["restaurant"]
                }

                var service = new google.maps.places.PlacesService(map);

                service.nearbySearch(request, callback);
            }

            function convenience_store(){
                deleteMarkers();

                var request = {
                    location: map.getCenter(),
                    radius: 1500,
                    types: ["convenience_store"]
                }

                var service = new google.maps.places.PlacesService(map);

                service.nearbySearch(request, callback);
            }

            function parking(){
                deleteMarkers();

                var request = {
                    location: map.getCenter(),
                    radius: 1500,
                    types: ["parking"]
                }

                var service = new google.maps.places.PlacesService(map);

                service.nearbySearch(request, callback);
            }

            function doctor(){
                deleteMarkers();
                var request = {
                    location: map.getCenter(),
                    radius: 1500,
                    types: ["doctor"]
                }

                var service = new google.maps.places.PlacesService(map);

                service.nearbySearch(request, callback);
            }



            function pharmacy(){
                deleteMarkers();
                var request = {
                    location: map.getCenter(),
                    radius: 1500,
                    types: ["pharmacy"]
                }

                var service = new google.maps.places.PlacesService(map);

                service.nearbySearch(request, callback);
            }

            function supermarket(){
                deleteMarkers();
                var request = {
                    location: map.getCenter(),
                    radius: 1500,
                    types: ["supermarket"]
                }

                var service = new google.maps.places.PlacesService(map);

                service.nearbySearch(request, callback);
            }



            

            function callback(results, status) {
                if (status == google.maps.places.PlacesServiceStatus.OK) {
                    for (var i = 0; i < results.length; i++) {
                        createMarker(results[i]);
                    }
                }
            }

            function createMarker(place) {
                marker = new google.maps.Marker({
                    map: map,
                    position: place.geometry.location,
                    title: place.name
                });
                <?php
                    include("./DBconnection.php");
                    $lng=place.geometry.location.lng();
                    $lat=place.geometry.location.lat();
                    echo"$lng";
                    $sql = "SELECT S.ID , S.Name FROM store2 as S WHERE `S.Address_Longitude`= '$lng' AND `S.Address_Latitude`='$lat'";
                    $query_result = mysqli_query($conn, $sql);
                    $resultcheck = mysqli_num_rows($query_result);

                    if($query_result){
                        if ($resultcheck > 0) {
                            while ($row = mysqli_fetch_array($query_result)) {
                                echo "<li>"."<span>".$row['Name']."</span></li>";
                            }
                        }    
                    }
                    else{
                        echo "fail";
                    }                
                ?>
                markers.push(marker);
                infowindow=new google.maps.InfoWindow({
                    content:"123\n123"
                });
                google.maps.event.addListener(marker,'click',createInfo(marker));
            }
            
            function createInfo(marker){
                return function(){
                    infowindow.open(map,marker);
                };
            }

            function closeOtherInfo() {
                if (InforObj.length > 0) {
                    InforObj[0].set("marker", null);
                    InforObj[0].close();
                    InforObj.length = 0;
                }
            }



            function deleteMarkers() {
                for(var i=0;i<markers.length;i++){
                    markers[i].setMap(null);
                }
            }

            function setplaceinfo(place){
                var test=place.name;
                google.maps.event.addListener(marker,'click', (function(marker,infowindow){ 
                    return function() {
                        infowindow.open(map,marker);
                    };
                })(marker,infowindow));  
            }

        </script>
    </body>
</html>


