<html lang='en'>
  <head>
    <meta charset='utf-8' />
    <link href='./External_Files/fullcalendar/main.css' rel='stylesheet' />
    <script src='./External_Files/fullcalendar/main.js'></script>

<script type="text/javascript"></script>
<script src="https://apis.google.com/js/client.js?onload=handleClientLoad"></script>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<meta name="google-signin-client_id" content="1051698943672-lrutkkrvnsu86ri9gdbe25m2c6hqha43.apps.googleusercontent.com">


<script>
// var UserEmail = localStorage.getItem("email")
// // console.log(localStorage)

// function authenticate() {
//     return gapi.auth2.getAuthInstance()
//         .signIn({scope: "https://www.googleapis.com/auth/calendar https://www.googleapis.com/auth/calendar.events"})
//         .then(function() { console.log("Sign-in successful"); },
//               function(err) { console.error("Error signing in", err); });
//   }
//   function loadClient() {
//     gapi.client.setApiKey("AIzaSyCywHuX1P6klMUzzE9Qzv003axHgioqPUA");
//     return gapi.client.load("https://content.googleapis.com/discovery/v1/apis/calendar/v3/rest")
//         .then(function() { console.log("GAPI client loaded for API"); },
//               function(err) { console.error("Error loading GAPI client for API", err); });
//   }

//   function execute() {
//     return gapi.client.calendar.events.insert({
//       "calendarId": "lishunhui97@gmail.com",
//       "resource": {
//         "start": {
//           "dateTime": "2021-04-05T17:00:00-07:00",
//           "timeZone": "Singapore"
//         },
//         "end": {
//           "dateTime": "2021-04-05T17:00:00-07:00",
//           "timeZone": "Singapore"
//         }
//       }
//     })
//         .then(function(response) {
//                 // Handle the results here (response.result has the parsed body).
//                 console.log("Response", response);
//               },
//               function(err) { console.error("Execute error", err); });
//   }
  

// document.addEventListener('DOMContentLoaded', function() {
//     var calendarEl = document.getElementById('calendar');

//     var calendar = new FullCalendar.Calendar(calendarEl, {
//       googleCalendarApiKey: 'AIzaSyCywHuX1P6klMUzzE9Qzv003axHgioqPUA',
//       events: {
//     googleCalendarId: UserEmail,
//   },
//   dateClick: function(info) {
//     alert('Clicked on: ' + info.dateStr);
    
//     execute()
//   }
//     });

//     calendar.render();


//   });

  // gapi.load("client:auth2", function() {
  //   gapi.auth2.init({client_id: "1051698943672-lrutkkrvnsu86ri9gdbe25m2c6hqha43.apps.googleusercontent.com"});
  //   authenticate().then(loadClient)

  // });
//   calendar.function( dateClickInfo ) { console.log('ho') }

function onSignIn(googleUser) {
  var id_token = googleUser.getAuthResponse().id_token;

  var url = "http://127.0.0.1:5100/api/google_sign";
      const data = JSON.stringify({
        idtoken: id_token,
      });
      fetch(url,{
        method: "POST",
        headers:{"Content-type": "application/x-www-form-urlencoded"},
        body: data
      })
      .then(response => response.json())
      //grab the returned response
      .then(data => {
        console.log(data)
        // console.log(data.code)
        // if (data.code == 201){
        //   localStorage.setItem("username", data.data.username)
        //   window.location.replace("./profile.php")
        // }   
      })
}
</script>

  </head>
  <body>
    <div id='calendar'></div>
    <div class="g-signin2" data-onsuccess="onSignIn"></div>

  </body>
</html>