window.onload = function(){
  // get all products from recently viewed
  var products = document.getElementById('hikashop_category_information_module_88').getElementsByClassName('hikashop_product_name')
  var json = {}
  var id = document.getElementById('id_cookie_div').innerHTML;

  json["id"] = id;

  // make sure cookie is really set -> avoid ".json" as filename which happened sometimes
  if(id.length > 0){

    if(products.length != 0) {
      // iterate through all recently viewed products and extract url
      for (var i=0, length = products.length; i < length; i++) {
          var product = products[i].innerHTML
          var regex = /.*?"(.*?)".*?/g;

          var url = regex.exec(product)
          url = url[1]
          // store url in json structure to send via XMLHttpRequest
          json[url.substring(url.lastIndexOf("/")+1)] = url
      }

      // send result to server
      var urlServer = "/projectworkprototype/projectwork_scripts/process_recently_viewed.php"

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
      httpServer.send(JSON.stringify(json));
    }
  }
}
