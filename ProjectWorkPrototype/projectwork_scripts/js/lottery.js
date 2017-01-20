function takePart() {
   var email = document.getElementById("email").value;
   var id = document.getElementById("id_cookie").value;

   var url = "/projectworkprototype/projectwork_scripts/process_email.php"
   var params = "email="+email+"&id="+id;

   if (email.length != 0 && id.length != 0){
       var http = new XMLHttpRequest();
       http.open("POST", url, true);

       //Send the proper header information along with the request
       http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

       http.onreadystatechange = function() {//Call a function when the state changes.
           if(http.readyState == 4 && http.status == 200) {
               //alert(http.responseText);
               alert("Thank you for taking part!");
           }
       }
       http.send(params);
    }
}
