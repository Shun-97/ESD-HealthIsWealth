<!doctype html>
<html lang="en">
<head>
<style>
  header {
    background-position: center;
    background-size: cover;
    background-image: url("img/ins.jpg");
    min-height: 100%;
  }

  #ins2 {
    background-position: center;
    background-size: cover;
    background-image: url("img/ins2.jpg");
    min-height: 100%;
  }

  #ins3{
    background-position: center;
    background-size: cover;
    background-image: url("img/ins3.jpg");
    min-height: 100%;
  }
</style>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title> Health is Wealth </title>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
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
            <!-- Vue JS -->
              <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

  <!-- Styling and JS -->
  <script src="./js/navbar.js"></script>
  <link rel="stylesheet" href="./css/main.css">


  <!-- Font Awesome -->
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

  <!-- Styling and JS -->
  <script src="./js/navbar.js"></script>
  <link rel="stylesheet" href="./css/main.css">

  <!-- Font Awesome -->
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

  <title> Health is Wealth </title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

  <header class="w3-display-container w3-grayscale-min" style="padding-top: 10rem;" id="home">
    <div class="w3-display-left w3-text-white" style="padding:48px">
      <span class="w3-jumbo w3-hide-small"> Why are you seeing this page? <img src="img/ins1.png" width="200px" height="200px"></span><br>
      <span class="w3-xxlarge w3-hide-large w3-hide-medium"> Why are you seeing this page? <img src="img/telebot.png"></span><br>
      <span class="w3-xlarge"> We are unable to access your Google Calendar! </span> <br><br>
      <span class="w3-xlarge"> Make your Google Calendar Public!</span>
      <div class="w3-xlarge"> 
        <ol>
            <li> In the Google Calendar Interface, locate the "My Calendars" area on the left </li>
            <li> Hover over the calendar you need and click the downward arrow. </li>
            <li> A menu will appear. Click "Share this Calendar" </li>
            <li> Check "Make this Calendar Public" </li>
            <li> Make sure "share only my free/busy information" is <b>unchecked</b> </li>
            <li> Click Save! </li>
        </ol>
      </div>
    </div>
  </header>

<div class="container-fluid w3-grayscale-min" style="padding-top: 10rem;" id="ins2">
    <div class="w3-display-left w3-text-white" style="padding:48px">
      <span class="w3-jumbo w3-hide-small"> Why are you seeing this page? <img src="img/telebot.png"></span><br>
      <span class="w3-xxlarge w3-hide-large w3-hide-medium"> Why are you seeing this page? <img src="img/telebot.png"></span><br>
      <span class="w3-xlarge">You have not fully set-up your account! Get your telebot chat id now! </span> <br>
      <div class="w3-xlarge"> 
        <ol>
            <li> Launch your Telegram </li>
            <li> In the search bar, search for @G3T6_HiW_bot or Click ---> <a href="https://t.me/G3T6_HiW_bot"><i class="w3-xxxlarge fab fa-telegram fa-spin"></i></a> </li>
            <li> Type /start </li>
            <li> Request for a chat id by typing /chatid </li>
            <li> Copy the Chat ID and fill in the form below</li>
        </ol>
      </div>
</div>
</div>
</div>
<div class="w3-display-container w3-grayscale-min" style="padding-top: 10rem;" id="ins3">
    <div class="w3-display-center w3-text-white" style="padding:48px">
          <div class="form-group">
            <label for="chatid" class="w3-xxlarge">Chat ID</label>
            <br>
            <br>
            <input type="number" class="form-control" id="chatid" placeholder="Enter chatid">
            <small id="emailHelp" class="form-text text-info">Your chat id is private and is only available to us </small>
          </div>
          <div class="form-group">
            <input type="hidden" class="form-control" id="username" value="">
          </div>
          <br>
          <br>
          <button onclick = execute() type="submit" class="btn btn-primary">Start Challenging your Exercise Schedule Today!</button>
    </div>
</div>
</body>
<script>
  if (localStorage.getItem('username')) {
      console.log(localStorage.getItem('username'));
      username = document.getElementById('username');
      username.value = localStorage.getItem('username');
  }

  function execute() {
    telegramid =  document.getElementById('chatid').value
    data = JSON.stringify({
      'telegramid' : telegramid,
      'username' : localStorage.getItem('username') 
    })
    console.log(data)
    fetch('http://127.0.0.1:5100/api/add/id', {
            
            method: 'POST',
            headers: {
                'Content-type': 'application/json',     
            },
            body: data
        })
        .then((res) => res.json())
        .then((data) => {
            console.log(data.data)
            if (data.code == 201){
                console.log("success")
                this.telegramid = data["TelegramId"]
                localStorage.setItem("tele_id", data["TelegramId"])
            } 
        });
        }

  
</script>
</html>