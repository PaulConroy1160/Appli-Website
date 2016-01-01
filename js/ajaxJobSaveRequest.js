
//Browser Support Code
function ajaxFunction(){
 var ajaxRequest;  // The variable that makes Ajax possible!
	
 try{
   // Opera 8.0+, Firefox, Safari
   ajaxRequest = new XMLHttpRequest();
 }catch (e){
   // Internet Explorer Browsers
   try{
      ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
   }catch (e) {
      try{
         ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
      }catch (e){
         // Something went wrong
         alert("Your browser broke!");
         return false;
      }
   }
 }
 // Create a function that will receive data 
 // sent from the server and will update
 // div section in the same page.
 /*
   0: request not initialized
   1: server connection established
   2: request received
   3: processing request
   4: request finished and response is ready
 */
 ajaxRequest.onreadystatechange = function(){
   if(ajaxRequest.readyState == 4){
      var ajaxDisplay = document.getElementById('saveNotifications');
      ajaxDisplay.innerHTML = ajaxRequest.responseText;
      console.log(ajaxRequest.responseText === '');
      
      if(ajaxRequest.responseText === ''){
          document.getElementById('saveNotifications').style.display = "none";
      } else {
          document.getElementById('saveNotifications').style.display = "block";
      }
   }
 }
 // Now get the value from user and pass it to
 // server script.
 var notif = document.getElementById('notification').value;
 var queryString = "?notification=" + notif ;
 ajaxRequest.open("GET", "ajaxJobSaves.php" + 
                              queryString, true);
 ajaxRequest.send(null); 

 setTimeout('ajaxFunction()', 1000);
}