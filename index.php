<?php
require_once 'php/include/common.php';
$username = "Guest";
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <title>ParkWhere</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/inview.min.js"></script>
    <script src="js/index.js"></script>
</head>

<body>
<div id="isUser" style="display:none;"><?=$username?></div>
    <div class="container-fluid" id='index'>
        <div class="row d-flex">
            <div class="col-sm-12 d-flex" id="caption">
                <div class="typewriter">
                    <h1 class="text-white">I can't find anywhere to park.</h1>
                </div>
            </div>

            <div class="col-sm-12 col-md-12" id="about">

                <div class="col-sm-12 col-md-6" style="display: inline-grid">
                    <div class="wrapper col-xs-12 col-md-12 d-inline-block"  id="about-1" >
                        <p class="display-4">We all could benefit from alittle help... sometimes</p>
                        <p>Join others helping each other to get there</p>
                    </div>

                    <div class="wrapper col-xs-12 col-md-12 d-inline-block"  id="about-2" >
                        <p class="display-4">Plan ahead of your time</p>
                        <p>Set a reminder on ParkWhere and we will remind you when it's time to get driving.</p>
                        <a href="schedule.php" class="border-bottom border-dark text-dark float-right mr-4">Learn More</a>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 float-right" style="display: inline-flex">
                    <div class="wrapper col-xs-12 col-md-12 d-inline-block "  id="about-3">
                        <p class="display-4">Share your experience</p>
                        <p>Know a secret parking spot? Want to warn others about dark alleyways at night?</p>
                        <img class="card-img-top" src="images/qwe.png">
                    </div>
                </div>

                <div class="col-sm-12 col-md-12 ">
                    <div class="wrapper col-xs-12 col-md-12 d-flex" id="about-4">

                    <div class="col-xs-12 col-md-4">
                        <p class="display-4 text-white">Find nearby carparks</p>
                        <p class="text-white">Going to a new place for the first time? We've got you covered.</p>
                    </div>
                    <div class="col-xs-12 col-md-8">
                        <img src="images/Maps.PNG"/>
                    </div>
                </div>

                </div>
            </div>

            <div class="col-sm-12 d-flex flex-row flex-wrap" id="abt-us">
                <div class="col-sm-12 col-md-6 m-auto">
                    <div class="wrapper border-left">
                        <p class="display-4">Our Vision</p>
                        <p>To cover all the info on carparks in Singapore on a website brought to locals as a service of
                            convenience with real-time updates</p>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 m-auto">
                    <div class="wrapper border-right">
                        <p class="display-4">Our Mission</p>
                        <p>To make parking easy and stress-free for the locals anytime, anywhere––all a couple of clicks
                            away</p>
                    </div>

                </div>
            </div>

            <div class="col-sm-12 d-flex" id="meet-the-team">
                <div class="wrapper text-center" id="meetteam">
                    <p class="display-3">Meet The Team</p>
                    <!--generate dynamically here-->
                </div>
            </div>

            <div class="col-sm-12 d-flex" id="action">
                <div class="wrapper text-center">
                    <h1 id="readytostart">Ready to start?</h1>
                    <a class="btn btn-light" href="search.php">Find my carpark</a>
                </div>
            </div>




        </div>



    </div>

</body>

</html>