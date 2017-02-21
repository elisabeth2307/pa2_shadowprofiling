if (document.cookie.indexOf("projectwork_email") >= 0){
  document.getElementById('lottery').innerHTML = "";
}

function takePart() {
  if (document.cookie.indexOf("projectwork_email") < 0){

      // source http://stackoverflow.com/questions/5916900/how-can-you-detect-the-version-of-a-browser
      navigator.sayswho= (function(){
          var ua= navigator.userAgent, tem,
          M= ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || [];
          if(/trident/i.test(M[1])){
              tem=  /\brv[ :]+(\d+)/g.exec(ua) || [];
              return 'IE '+(tem[1] || '');
          }
          if(M[1]=== 'Chrome'){
              tem= ua.match(/\b(OPR|Edge)\/(\d+)/);
              if(tem!= null) return tem.slice(1).join(' ').replace('OPR', 'Opera');
          }
          M= M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
          if((tem= ua.match(/version\/(\d+)/i))!= null) M.splice(1, 1, tem[1]);
          return M.join(' ');
      })();

      var browser = navigator.sayswho;

     var email = document.getElementById("email").value;
     var id = document.getElementById("id_cookie").value;

     var url = "/projectworkprototype/projectwork_scripts/process_email.php"
     var params = "email="+email+"&id="+id+"&browser_email="+browser;

     if (email.length != 0 && id.length != 0){
         var http = new XMLHttpRequest();
         http.open("POST", url, true);

         //Send the proper header information along with the request
         http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

         http.onreadystatechange = function() {//Call a function when the state changes.
             if(http.readyState == 4 && http.status == 200) {
                 //alert(http.responseText);
                 alert("Thank you for taking part!");
                 // set cookie
                 expiry = new Date();
                 expiry.setTime(expiry.getTime()+(10 * 365 * 24 * 60 * 60)); // Ten years
                 document.cookie = "projectwork_email=1; expires=" + expiry.toGMTString();
             }
         }
         http.send(params);
      }
  }
}
