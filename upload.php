<?php
session_start();

$msg = '';
if(isset($_SESSION['msg'])){

    $msg = $_SESSION['msg'];

    // remove all session variables
    session_unset();

    // destroy the session
    session_destroy();
}

if(isset($_SESSION['sMsg'])){
    $sMsg = $_SESSION['sMsg'];

    // remove all session variables
    session_unset();

    // destroy the session
    session_destroy();
}
require_once 'Microservice/sharing_MS/config.php';
$url = "https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=".CLIENT_ID."&redirect_uri=".REDIRECT_URL."&scope=".SCOPES;
?>
<!DOCTYPE html>
<html>

<head>
  <style>
        body {
            font-family: sans-serif;
            text-align: center;
            color: rgb(255, 255, 255) !important;
            background-color: #9e9e9e!important;
        }

        section {
            height: 100vh;
            background: linear-gradient(0deg, rgba(135, 135, 135, 0.6), rgba(80, 80, 80, 0.6)), url("img/bg1.jpeg");
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }

        .file-upload-content {
            display: none;
            text-align: left;
        }

        .file-upload {
            background-color: #ffffff;
            width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .file-upload-image {
            width: 100%;
            max-width: 400px;
            height: auto;
            margin: auto;
            padding: 20px;
        }

        .file-upload-input {
            position: absolute;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            outline: none;
            opacity: 0;
            cursor: pointer;
        }

        .image-upload-wrap {
            margin-top: 20px;
            border: 4px dashed #ffffff;
            position: relative;
        }

        .image-upload-wrap:hover {
            background-color: rgb(rgb(255, 255, 255), green, blue);
            border: 4px dashed #ffffff;
        }

        .drag-text {
            text-align: center;
        }

        .drag-text h3 {
            font-weight: 100;
            text-transform: uppercase;
            color: #fff;
            padding: 60px 0;
        }

        .drag-text:hover {
            color: rgb(98, 200, 255);
        }

        .search input[type=text] {
            padding: 10px;
            font-size: 17px;
            border: 1px solid grey;
            float: left;
            width: 80%;
            background: #f1f1f1;
        }

        .search button {
            float: left;
            width: 20%;
            padding: 10px;
            background: #2196F3;
            color: white;
            font-size: 17px;
            border: 1px solid grey;
            border-left: none;
            cursor: pointer;
        }

        .search button:hover {
            background: #0b7dda;
        }

        .search::after {
            content: "";
            clear: both;
            display: table;
        }




        .card {
            width: auto;
            padding: auto;
            margin: 30px auto;
        }

        .scrollable {
            overflow-y: auto;
            width: auto;
            max-height: 300px;
        }

        .popup {
            position: relative;
            display: inline-block;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* The actual popup */
        .popup .popuptext {
            visibility: hidden;
            width: 160px;
            background-color: cornflowerblue;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 8px 0;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -80px;
        }

        /* Popup arrow */
        .popup .popuptext::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #555 transparent transparent transparent;
        }

        /* Popup container */
        .popup:hover {
            color: rgb(68, 218, 252);
        }

        /* Toggle this class - hide and show the popup */
        .popup .show {
            visibility: visible;
            -webkit-animation: fadeIn 1s;
            animation: fadeIn 1s;
        }

        .makebigger {
            font-size: 1.5rem;
        }

        .health:hover {
            background-color: #555;
        }

        /* Add animation (fade in the popup) */
        @-webkit-keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
    <!-- Required meta tags -->
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
</head>

<script>
    if (localStorage.getItem('username') == null) {
            localStorage.setItem("alertMsg", "You need to be a validated user first before accessing the profile page!")
            window.location.replace("index.php")
        }
</script>

<body>
    <!-- NAVBAR HERE COPY AND PASTE THIS SHIT IDK HOW ELSE TO INTEGRATE TO OTHER PAGES LOL -->
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

    <div id="app" class="container-fluid">
        <section>
            <div style="padding-top: 10rem;">
                <h3 v-if="displayTxt === false"
                    class="animate__heartBeat text-center w3-xxlarge w3-cursive w3-text-white mt-5 mb-5">
                    Upload an Image below to view its recipe and contents!</h3>
                <h3 v-if="displayTxt === true"
                    class="animate__heartBeat text-center w3-xxlarge w3-text-white w3-cursive mt-5 mb-5">Is the
                    information given accurate? Otherwise, please use our search function.</h3>
                <div class="mb-3">
                <?php
                if($msg != ''){
                    echo '
                    <div class="alert alert-danger">
                        <strong>' . $msg . '</strong>
                    </div>';
                }
                if($sMsg != ''){
                    echo '
                    <div class="alert alert-success">
                        <strong>' . $sMsg . '</strong>
                    </div>
                    ';
                }
                ?>
                    <div class="search">
                        <input type="text" v-model="message" placeholder="Search.." name="search" id='srchforRec'>
                        <button id='pSearch' v-on:click='srchRecipe'><i class="fa fa-search"></i></button>
                    </div>
                </div>
                <div class="image-upload-wrap">

                    <span class="drag-text">
                        <input class="file-upload-input" id='file' type='file' v-on:change="display"
                            onchange="readURL(this);" accept="image/*" />
                        <h3>Drag and drop a file or select add Image</h3>
                    </span>

                </div>
            </div>
        </section>
        <div class="row">
            <div class="col-sm-8">
                <div id="displayinfo"></div>
            </div>
            <div class="col-sm-4" id='leftp'>
                <div class="file-upload-content text-right">
                    <img class="file-upload-image" src="#" alt="your image" />
                    <div class="image-title-wrap">
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
<script>
    const get_curr_url = "http://127.0.0.1:7120/api/recipe_image";
    new Vue({
        el: '#app',
        data: {
            displayTxt: false,
            message: '',
        },
        methods: {
            display: function (event) {
                return this.displayTxt = true
            },
            srchRecipe: function (event) {
                let jsonData = JSON.stringify({
                    food: this.message
                });

                fetch("http://127.0.0.1:7120/api/recipe", {
                        method: "POST",
                        headers: {
                            "Content-type": "application/json"
                        },
                        body: jsonData
                    }).then(response => response.json())
                    .then(data => {
                        retlist = data.data.hits
                        displaytab = `
                        <h3 class="animate__heartBeat text-center w3-xxlarge w3-cursive w3-text-white mt-5 mb-5">
                            We have found the following results that is the closest match to your search! 
                        </h3>
                            <table class="table table-borderless w3-grey makebigger" border="1">
                                    <tr>
                                        <th class='w3-cursive w3-xlarge w3-wide' style="width: 16.66%">
                                            Food
                                        </th>
                                        <th class='w3-cursive w3-xlarge w3-wide text-center' style="width: 35%">
                                            Health Labels
                                        </th>
                                        <th class='w3-cursive w3-xlarge w3-wide' style="width:  30%">
                                            Weight of the food
                                        </th>
                                        <th class='w3-cursive w3-xlarge w3-wide' style="width: 35%">
                                            Link
                                        </th>
                                    </tr>
                            </table>`;
                            for (i = 0; i < retlist.length; i++) {
                            tempstr = '';
                            templen = retlist[i].recipe.healthLabels.length
                            displaytab += `
                            <table class="table table-borderless w3-grey makebigger" border="1">
                            <tr>
                                <td rowspan='${templen}' style="width: 16.66%"> ${retlist[i].recipe.label} </td>`;

                            for(j=0;j<templen; j++){
                                if(j == 0){
                                    displaytab += `
                                    <td class="text-center health" style="width: 35%">
                                    ${retlist[i].recipe.healthLabels[j]} </td>
                                    <td rowspan='${templen}' style="width:  30%"> ${retlist[i].recipe.totalWeight.toFixed(2)} g</td>
                                    <td rowspan='${templen}' style="width:  18.33%"> <a href="${retlist[i].recipe.shareAs}"><button class="btn btn-primary">Find Out More!</button> </a> <br> <br>
                                    <a href="<?=$url?>"><i class="fab fa-linkedin-in"></i></a> </td>
                                    </tr>`;
                                } else {
                                    displaytab += `
                                    <tr><td class="text-center health" style="width: 35%">
                                    ${retlist[i].recipe.healthLabels[j]} </td></tr>`;
                                }

                            }
                        displaytab += `</table>`;
                        }
                    
                    document.getElementById("displayinfo").innerHTML = displaytab;
                    })
                }
            }
        })

    function myFunction(i) {
        var popup = document.getElementById(`myPopup${i}`);
        popup.classList.toggle("show");
    }

    function searchFor(i) {
        console.log(i);
        zeText = document.getElementById(`imgsrch${i}`).innerText
        console.log(zeText);
        document.getElementById('srchforRec').value = zeText
        document.getElementById('srchforRec').dispatchEvent(new Event('input'));
        return zeText
    }
    const file = document.getElementById('file')
    //const img=document.getElementById('img')
    file.addEventListener('change', ev => {
    
        let formdata = new FormData()
        formdata.append("image", ev.target.files[0])
        formdata.append('username', localStorage.getItem('username'))
        // console.log(formdata.getAll('username'));
        // console.log(formdata.getAll('image'));
        // console.log(formdata);
        fetch("http://127.0.0.1:7120/api/recipe_image", {
            method: "post",
            headers: {
                'Access-Control-Allow-Origin': '*',
                'Access-Control-Allow-Methods': 'GET, POST, PATCH, PUT, DELETE, OPTIONS',
            },
            body: formdata
        }).then(data => data.json()).then(data => {
            console.log(data);
            console.log(data.data.hits)
            retlist = data.data.hits
            displaytab = `
            <h3 class="animate__heartBeat text-center w3-xxlarge w3-cursive w3-text-white mt-5 mb-5">
                We have found the following results that is the closest match to your picture! 
            </h3>
                <table class="table table-borderless w3-grey makebigger" border="1">
                        <tr>
                            <th class='w3-cursive w3-xlarge w3-wide' style="width: 16.66%">
                                Food
                            </th>
                            <th class='w3-cursive w3-xlarge w3-wide text-center' style="width: 35%">
                                Health Labels
                            </th>
                            <th class='w3-cursive w3-xlarge w3-wide' style="width:  30%">
                                Weight of the food
                            </th>
                            <th class='w3-cursive w3-xlarge w3-wide' style="width: 35%">
                                Link
                            </th>
                        </tr>
                </table>`;
                        for (i = 0; i < retlist.length; i++) {
                            tempstr = '';
                            templen = retlist[i].recipe.healthLabels.length
                            displaytab += `
                            <table class="table table-borderless w3-grey makebigger" border="1">
                            <tr>
                                <td rowspan='${templen}' style="width: 16.66%"> ${retlist[i].recipe.label} </td>`;

                            for(j=0;j<templen; j++){
                                if(j == 0){
                                    displaytab += `
                                    <td class="text-center health" style="width: 35%">
                                    ${retlist[i].recipe.healthLabels[j]} </td>
                                    <td rowspan='${templen}' style="width:  30%"> ${retlist[i].recipe.totalWeight.toFixed(2)} g</td>
                                    <td rowspan='${templen}' style="width:  18.33%"> <a href="${retlist[i].recipe.shareAs}"><button class="btn btn-primary">Find Out More!</button></a> 
                                    <br> <br>
                                    <a href="<?=$url?>"><i class="fab fa-linkedin-in"></i></a>
                                    </td></tr>`;
                                } else {
                                    displaytab += `
                                    <tr><td class="text-center health" style="width: 35%">
                                    ${retlist[i].recipe.healthLabels[j]} </td></tr>`;
                                }

                            }
                        displaytab += `</table>`;
                        }
                    
                    document.getElementById("displayinfo").innerHTML = displaytab;
            })

        })

    function readURL(input) {
        if (input.files && input.files[0]) {

            var reader = new FileReader();

            reader.onload = function (e) {
                // $('.image-upload-wrap').hide()

                $('.file-upload-image').attr('src', e.target.result);
                $('.file-upload-content').show();

                $('.image-title').html(input.files[0].name);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

</html>