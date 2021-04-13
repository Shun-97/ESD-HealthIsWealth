<!doctype html>
<html lang="en">
session_start();

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Main loader -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="./js/ScriptLoader.js"></script>
  <script src="./js/navbar.js"></script>
  <link rel="stylesheet" href="./css/main.css">

  <title> Health is Wealth </title>
  
</head>
<body>
  <header class="bgimg-1 w3-display-container w3-grayscale-min" id="home">
    <div class="w3-display-left w3-text-white" style="padding:48px">
      <div id="show"></div>
      <span class="w3-jumbo w3-hide-small">Start planning your meals</span><br>
      <span class="w3-xxlarge w3-hide-large w3-hide-medium">Start planning your meals</span><br>
      <span class="w3-large">For a better health, Eat with choice</span>
      <p><a href="register.php"
          class="w3-button w3-white w3-padding-large w3-large w3-margin-top w3-opacity w3-hover-opacity-off">Register
          now!</a>
        <a href="login.php"
          class="w3-button w3-blue w3-padding-large w3-large w3-margin-top w3-opacity w3-hover-opacity-off"
          style="opacity: 1">Login</a>
      </p>
    </div>
  </header>

  <!-- About Section -->
  <div class="w3-container" style="padding-top: 10rem;" id="about">
    <h3 class="w3-center">Health is Wealth</h3>
    <p class="w3-center w3-large">Solutions for your daily lives</p>
    <div class="w3-row-padding w3-center" style="margin-top:64px">
      <div class="w3-quarter">
        <i class="fas fa-carrot fa-spin w3-margin-bottom w3-jumbo w3-center"></i>
        <p class="w3-large">Analyse your food</p>
        <p>Upload a picture of your food and let our food analyser breakdown its ingredients and nutritional
          information! </p>
      </div>
      <div class="w3-quarter">
        <i class="fa fa-heart w3-margin-bottom w3-jumbo"></i>
        <p class="w3-large">Spread your diet</p>
        <p>Share them with your friends, build a healthy circle!</p>
      </div>
      <div class="w3-quarter">
        <i class="fas fa-robot w3-margin-bottom w3-jumbo"></i>
        <p class="w3-large">Receive recommendations</p>
        <p>Our application learns your behaviour and recommend you the healthiest choices</p>
      </div>
      <div class="w3-quarter">
        <i class="fas fa-running w3-margin-bottom w3-jumbo"></i>
        <p class="w3-large">Understand your calories input and output!</p>
        <p> Feeling that you are eating too much? Challenge yourself with our Exercising Application! </p>
      </div>
    </div>
  </div>

  <!-- Team Section -->
  <div class="w3-container w3-center" style="padding:128px 16px" id="team">
    <h3 class="w3-center">THE TEAM</h3>
    <p class="w3-center w3-large">The creators of this application</p>
    <div class="w3-row-padding w3-grayscale" style="margin-top:64px">
      <div class="w3-col l2 m6 w3-margin-bottom">
        <div class="w3-card">
          <img src="img/yc.jpg" alt="yc" style="width:100%">
          <div class="w3-container">
            <h3>Yeo Yao Cong</h3>
            <p class="w3-opacity"> Front-End Jesus</p>
            <p> Dealing with your user interface and delivering optimal user experience to you </p>
            <p><a href="https://www.linkedin.com/in/ycyc/"><button class="w3-button w3-light-grey w3-block"><i class="fa fa-envelope"></i> Contact</button></a></p>
          </div>
        </div>
      </div>
      <div class="w3-col l2 m6 w3-margin-bottom">
        <div class="w3-card">
          <img src="img/sh.jpg" alt="sh" style="width:100%">
          <div class="w3-container">
            <h3>Lee Shun Hui</h3>
            <p class="w3-opacity">Back-End</p>
            <p> Connecting your Microservices more efficient than an API Gateway</p>
            <p><a href="https://www.linkedin.com/in/leeshunhui/"><button class="w3-button w3-light-grey w3-block"><i class="fa fa-envelope"></i> Contact</button></p></a>
          </div>
        </div>
      </div>
      <div class="w3-col l2 m6 w3-margin-bottom">
        <div class="w3-card">
          <img src="img/tc.jpeg" alt="tc" style="width:100%">
          <div class="w3-container">
            <h3>Trisha Chua</h3>
            <p class="w3-opacity">API Digger</p>
            <p> No API Endpoint is safe from my sights </p>
            <p><a href="https://www.linkedin.com/in/trisha-chua/"><button class="w3-button w3-light-grey w3-block"><i class="fa fa-envelope"></i> Contact</button></a></p>
          </div>
        </div>
      </div>
      <div class="w3-col l2 m6 w3-margin-bottom">
        <div class="w3-card">
          <img src="img/lx.jpg" alt="lx" style="width:100%">
          <div class="w3-container">
            <h3>Hong Li Xuan</h3>
            <p class="w3-opacity">Designer</p>
            <p> The architecture design of our web application is as sleek as the apple floating on Marina Bay Sands </p>
            <p> <a href="https://www.linkedin.com/in/hong-li-xuan/"> <button class="w3-button w3-light-grey w3-block"><i class="fa fa-envelope"></i> Contact</button> </a> </p>
          </div>
        </div>
      </div>
      <div class="w3-col l2 m6 w3-margin-bottom">
        <div class="w3-card">
          <img src="img/ky.jpg" alt="ky" style="width:100%">
          <div class="w3-container">
            <h3>Kendrick Yeong</h3>
            <p class="w3-opacity"> Marketing Master </p>
            <p> Promoting our products and marketing them at a rate where you will be enticed within a second </p>
            <p> <a href="https://www.linkedin.com/in/kendrick-yeong/"> <button class="w3-button w3-light-grey w3-block"><i class="fa fa-envelope"></i> Contact</button> </a> </p>
          </div>
        </div>
      </div>
      <div class="w3-col l2 m6 w3-margin-bottom">
        <div class="w3-card">
          <img src="img/lxek.jpg" alt="jlx" style="width:100%">
          <div class="w3-container">
            <h3>Professor Jiang & Professor Lum</h3>
            <p class="w3-opacity"> Business Owners </p>
            <p> Providing our development team with wise advices like how Macdonalds provided us with Mcgriggles </p>
            <p> <a href="https://www.smu.edu.sg/faculty/profile/9617/JIANG-Lingxiao"> <button class="w3-button w3-light-grey w3-block"><i class="fa fa-envelope"></i> Contact</button> </a> </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  

  <!-- Footer -->
  <footer class="w3-center w3-black w3-padding-64">
    <a href="#home" class="w3-button w3-light-grey"><i class="fa fa-arrow-up w3-margin-right"></i>To the top</a>
    <div class="w3-xlarge w3-section">
      <img src="img/earthchan.png" width='200px' height='200px'>
      
    </div>
    <p>Powered by <a class="w3-hover-text-green"> G3T6 </a></p>
  </footer>

<script>
    // Modal Image Gallery
    function onClick(element) {
      document.getElementById("img01").src = element.src;
      document.getElementById("modal01").style.display = "block";
      var captionText = document.getElementById("caption");
      captionText.innerHTML = element.alt;
    }


    if (localStorage.getItem('alertMsg') != null) {
            var alertMsg = localStorage.getItem('alertMsg')
            alertmodal = `<div class="alert alert-danger" role="alert">
                              ${alertMsg}
                          </div>`;
          document.getElementById('show').innerHTML = alertmodal;
          localStorage.clear();
        }

  </script>
</body>

</html>