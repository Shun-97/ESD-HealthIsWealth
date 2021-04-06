<html lang='en'>

<head>
  <meta charset='utf-8' />
  <link href='External_Files/FullCalendar/main.css' rel='stylesheet' />
  <script src='External_Files/FullCalendar/main.js'></script>

  <script type="text/javascript"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
  <script src="https://apis.google.com/js/client.js?onload=handleClientLoad"></script>
  <script src="https://apis.google.com/js/platform.js" async defer></script>
  <script src="https://apis.google.com/js/platform.js?onload=init" async defer></script>
  <meta name="google-signin-client_id"
    content="1051698943672-lrutkkrvnsu86ri9gdbe25m2c6hqha43.apps.googleusercontent.com">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
    crossorigin="anonymous"></script>
  <!-- <script src="js/google_session.js"></script> -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>




  <script>
    // console.log(localStorage)
    var googleEmail = ''
    function authenticate() {
      return gapi.auth2.getAuthInstance()
        .signIn({ scope: "https://www.googleapis.com/auth/calendar https://www.googleapis.com/auth/calendar.events" })
        .then(function (data) {
          googleEmail = data['Qs']['zt'];

          var calendarEl = document.getElementById('calendar');

          var calendar = new FullCalendar.Calendar(calendarEl, {
            googleCalendarApiKey: 'AIzaSyCywHuX1P6klMUzzE9Qzv003axHgioqPUA',
            events: {
              googleCalendarId: googleEmail,
            },
            dateClick: function (info) {
              // alert('Clicked on: ' + info.dateStr);

              execute(info.dateStr)
            }
          });

          calendar.render();
        },
          function (err) { console.error("Error signing in", err); });
    }
    function loadClient() {
      gapi.client.setApiKey("AIzaSyCywHuX1P6klMUzzE9Qzv003axHgioqPUA");
      return gapi.client.load("https://content.googleapis.com/discovery/v1/apis/calendar/v3/rest")
        .then(function () { console.log("GAPI client loaded for API"); },
          function (err) { console.error("Error loading GAPI client for API", err); });
    }

    // function execute() {

    // }
    function execute(date) {
      $('#exercise_form').modal('show')
      date_form = document.getElementById('date_form')
      date_form.value = date + 'T00:00'
    }


    // document.addEventListener('DOMContentLoaded', function () {



    // });

    gapi.load("client:auth2", function () {
      gapi.auth2.init({ client_id: "1051698943672-lrutkkrvnsu86ri9gdbe25m2c6hqha43.apps.googleusercontent.com" });
      authenticate().then(loadClient)

    });
    // calendar.function( dateClickInfo ) { console.log('ho') }

    function sendform() {
      // $('#exercise_form').modal('hide')
      let dateTime = document.getElementsByName('date')[0].value
      let duration = document.getElementsByName('duration')[0].value
      let difficulty = document.getElementsByName('difficulty')[0].value
      date = dateTime.split('T')[0]
      let momentDate = moment(dateTime)
      let starttime = momentDate.format()
      let endtime = momentDate.add(duration, 'm').format()


      let url = "http://127.0.0.1:5300/api/exercise";


      const data = JSON.stringify({
        date: date,
        duration: duration,
        difficulty: difficulty
      });
      fetch(url, {
        method: "POST",
        headers: {
          "Content-type": "application/json",
          'Accept': 'application/json',
        },
        body: data
      })
        .then(response => response.json())
        //grab the returned response
        .then(data => {
          // console.log(data)
          // console.log(data.code)
          if (data.code == 200) {
            console.log(data)
            console.log(data['exercise_type'])
            console.log(data['Description'])

            return gapi.client.calendar.events.insert({
              "calendarId": googleEmail,
              "resource": {
                'summary': data.data.exercise_type,
                'description': data.data.Description,
                'start': {
                  'dateTime': starttime,
                  'timeZone': 'Singapore',
                },
                'end': {
                  'dateTime': endtime,
                  'timeZone': 'Singapore',
                },
              }
            })
              .then(function (response) {
                // Handle the results here (response.result has the parsed body).
                console.log("Response", response);
              },
                function (err) { console.error("Execute error", err); });


          }
        })


    }

  </script>

</head>

<body>
  <div id='calendar'></div>
  <!-- Modal form -->
  <div class="modal fade" id="exercise_form" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Plan a completely random exercise</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Date: <input id='date_form' name='date' type='datetime-local'>
          <br>
          Duration:
          <select name='duration'>
            <option value='15'>15 Mins</option>
            <option value='30'>30 Mins</option>
            <option value='60'>60 Mins</option>
          </select>
          <br>
          Difficulty
          <select name='difficulty'>
            <option value="Easy">Easy</option>
            <option value="Medium">Medium</option>
            <option value="Hard">Hard</option>
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" onclick="sendform()">PLAN FOR ME</button>
        </div>
      </div>
    </div>
  </div>
</body>

</html