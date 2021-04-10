<html lang='en'>

<head>
  <style>
  </style>
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
  <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
  <script class="jsbin" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css">
  <script src="js/navbar.js"></script>
  <link rel="stylesheet" href="css/main.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>
<script>
  if (localStorage.getItem('username') == null) {
            localStorage.setItem("alertMsg", "You need to be a validated user first before accessing the profile page!")
            window.location.replace("index.php")
      } 
</script>
<body>
<div class="w3-top">
        <div class="w3-bar w3-white w3-card" id="myNavbar">
            <a href="index.php" class="w3-bar-item w3-button w3-wide"><img src='./img/earthchan.png' height="48px"
                    width="48px">Health is Wealth</a>
            <!-- Right-sided navbar links -->
            <div class="w3-right w3-hide-small">
                <a href="landing_plan.php" class="w3-bar-item w3-button"><i class="fa fa-user"></i> Plan My Meal</a>
                <a href="upload.php" class="w3-bar-item w3-button"><i class="fa fa-th"></i> What's In My Meal? </a>
                <a href="schedule.php" class="w3-bar-item w3-button"><i class="fa fa-calendar" aria-hidden="true"
                        style="font-size:25px"></i></a>
                <a href="profile.php" class="w3-bar-item w3-button"><i class="fas fa-user-circle"
                        style="font-size:25px"></i></a>
            </div>
            <!-- Hide right-floated links on small screens and replace them with a menu icon -->

            <a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium"
                onclick="w3_open()">
                <i class="fa fa-bars"></i>
            </a>
        </div>
    </div>
     <!-- Sidebar on small screens when clicking the menu icon -->
    <nav class="w3-sidebar w3-bar-block w3-black w3-card w3-animate-left w3-hide-medium w3-hide-large"
        style="display:none" id="mySidebar">
        <a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button w3-large w3-padding-16">Close ×</a>
        <a href="landing_plan.php" onclick="w3_close()" class="w3-bar-item w3-button">Plan My Meal</a>
        <a href="upload.php" onclick="w3_close()" class="w3-bar-item w3-button">What's In My Meal?</a>
        <a href="schedule.php" onclick="w3_close()" class="w3-bar-item w3-button"><i class="fa fa-calendar"
            aria-hidden="true" style="font-size:25px"></i></a>
        <a href="profile.php" onclick="w3_close()" class="w3-bar-item w3-button"><i class="fas fa-user-circle"
            style="font-size:25px"></i></a>
    </nav>
    <!-- NAVBAR ENDS HERE COPY AND PASTE THIS SHIT IDK HOW ELSE TO INTEGRATE TO OTHER PAGES LOL -->
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


      let url = "http://0.0.0.0:8000/api/v1/setcalender";


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
                  console.log(addedtocal)
                  description = response.result.description
                  console.log(description)
                  status = response.result.status
                  console.log(status)
                  summary = response.result.summary
                  console.log(summary)
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
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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