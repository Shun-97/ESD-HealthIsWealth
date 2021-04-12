<!doctype html>
<html lang="en">
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Main loader -->
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="js/ScriptLoader.js"></script>
<script src="js/navbar.js"></script>
<link rel="stylesheet" href="css/main.css">


<title> Landing Schedule </title>
</head>
<script>
  if (localStorage.getItem('username') == null) {
            localStorage.setItem("alertMsg", "You need to be a validated user first before accessing the scheduling page!")
            window.location.replace("index.php")
        }
</script>
<body>

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
    // console.log(data)
    fetch('http://localhost:8000/api/v1/tele/add', {
            
            method: 'POST',
            headers: {
                'Content-type': 'application/json',     
            },
            body: data
        })
        .then((res) => res.json())
        .then((data) => {
            // console.log(data.data)
            if (data.code == 201){
                // console.log("success")
                this.telegramid = data["TelegramId"]
                localStorage.setItem("tele_id", data["TelegramId"])
            } 
        });
        }
</script>
</html>