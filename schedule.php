<html lang='en'>

<head>

<script>
  if (localStorage.getItem('username') == null) {
            localStorage.setItem("alertMsg", "You need to be a validated user first before accessing the calendar page!")
            window.location.replace("index.php")
      } 
</script>

  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Main loader -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="js/ScriptLoader.js"></script>
  <script src="js/navbar.js"></script>
  
  <!-- full calendar -->
  <link href='External_Files/FullCalendar/main.css' rel='stylesheet' />
  <script src='External_Files/FullCalendar/main.js'></script>
  
  <!-- Google sign in -->
  <script src="https://apis.google.com/js/client.js?onload=handleClientLoad"></script>
  <script src="https://apis.google.com/js/platform.js" async defer></script>
  <script src="https://apis.google.com/js/platform.js?onload=init" async defer></script>
  <meta name="google-signin-client_id" content="1051698943672-lrutkkrvnsu86ri9gdbe25m2c6hqha43.apps.googleusercontent.com">
  
  <!-- Moment -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
</head>

<body>
    <div class="container text-center" style="padding-top: 10rem;">
      <div id='calendar'></div>
    <!-- Modal form -->
    <div id="dizplaymodal2"></div>
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
            <a data-bs-dismiss="modal"><button type="button" class="btn btn-primary" id="myBtn" name="myBtn" onclick="sendform()">PLAN FOR ME</button></a>
          </div>
        </div>
      </div>
    </div>
    </div>
</body>
<script>
      //  if (localStorage.getItem('tele_id') == null) {
      //       window.location.replace("landing_schedule.php")
      // }
    // console.log(localStorage)
    var googleEmail = ''
    function authenticate() {
      return gapi.auth2.getAuthInstance()
        .signIn({ scope: "https://www.googleapis.com/auth/calendar https://www.googleapis.com/auth/calendar.events" })
        .then(function (data) {
          googleEmail = data.getBasicProfile().getEmail();
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
        .then(function () {
          console.log("GAPI client loaded for API"); },
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
    })
    // calendar.function( dateClickInfo ) { console.log('ho') }

    function sendform() {
      // $('#exercise_form').modal('hide')
      let dateTime = document.getElementsByName('date')[0].value
      let duration = document.getElementsByName('duration')[0].value
      let difficulty = document.getElementsByName('difficulty')[0].value
      date = dateTime.split('T')[0]
      let momentDate = moment(dateTime)
      let starttime = momentDate.format()
      let telestart = momentDate.format('YYYY-MM-DD hh:mm:ss')
      let endtime = momentDate.add(duration, 'm').format()


      let url = "http://localhost:8000/api/v1/setcalendar";


      const data = JSON.stringify({
        date: date,
        duration: duration,
        difficulty: difficulty,
        starttime: telestart,
        username: localStorage.getItem('username'),
        telegramid: localStorage.getItem('tele_id')
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
            
            // console.log(data['exercise_type'])
            // console.log(data['Description'])

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
                  addedtocal = response.result.creator.email
                  // console.log(addedtocal)
                  description = response.result.description
                  // console.log(description)
                  status = response.result.status
                  // console.log(status)
                  summary = response.result.summary
                  // console.log(summary)
                  alertmodal = `
                          <div class="modal fade" id="alrtz2" tabindex="-1">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title text-success"> ${status} </h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  Activity: ${summary} has been logged into ${addedtocal}<br><br>
                                  Description: ${description}
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick = 'location.reload()'>Close</button>
                                </div>
                              </div>
                            </div>`;
                document.getElementById('dizplaymodal2').innerHTML = alertmodal;
                $('#alrtz2').modal('show');

              },
                function (err) { console.error("Execute error", err); });


          } else {
            alertmodal = `
                          <div class="modal fade" id="alrtz2" tabindex="-1">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title text-danger"> Error! </h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                  Activity: Activity is unable to be logged into account<br><br>
                                  Please try again later!
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>`;
                document.getElementById('dizplaymodal2').innerHTML = alertmodal;
                $('#alrtz2').modal('show');
          }
        })

        

    }
  </script>
</html