
if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(processPosition);
} else {
    //alert("not supported")
}

function processPosition(position) {
  // make sure cookie is really set -> avoid ".json" as filename which happened sometimes
  if(document.getElementById('id_cookie_div').innerHTML.length > 0){

    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;

    var urlGoogle = "http://maps.googleapis.com/maps/api/geocode/json?latlng="+latitude+","+longitude+"&sensor=true";

    var httpGoogle = new XMLHttpRequest();
    httpGoogle.open("GET", urlGoogle, true);

    httpGoogle.onreadystatechange = function() {//Call a function when the state changes.
        if(httpGoogle.readyState == 4 && httpGoogle.status == 200) {
            var json = JSON.parse(httpGoogle.responseText);
            var jsonData = {};
            var id = document.getElementById('id_cookie_div').innerHTML;

            jsonData["id"] = id;
            jsonData["street"] = json.results[0].address_components[1].long_name +" " +json.results[0].address_components[0].long_name; // e. g. Bundesstraße 11
            jsonData["post"] = json.results[0].address_components[6].long_name; // e. g. 8770
            jsonData["city"] = json.results[0].address_components[2].long_name; // e. g. Leoben
            jsonData["country"] = json.results[0].address_components[5].long_name; // e. g. Österreich
            jsonData["state"] = json.results[0].address_components[4].long_name; // e. g. Steiermark
            //alert(JSON.stringify(jsonData))

            // send variables to server
            var urlServer = "/projectworkprototype/projectwork_scripts/process_address.php"

            // XMLHttpRequest
            var httpServer = new XMLHttpRequest();
            httpServer.open("POST", urlServer, true);
            //Send the proper header information along with the request
            httpServer.setRequestHeader("Content-Type", "application/json");
            httpServer.onreadystatechange = function(){
              if(httpServer.readyState == 4 && httpServer.status == 200) {
                //alert(httpServer.responseText)
              }
            }
            // send data
            httpServer.send(JSON.stringify(jsonData));

        }
    }
    httpGoogle.send();
  }
}
