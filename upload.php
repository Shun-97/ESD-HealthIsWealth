<?php
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
            background-color: #555 !important;
        }

        section{
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

        

        
        .card{
        width: auto;
        padding: auto;
        margin: 30px auto;
        }
        .scrollable{
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
        font-size: 2rem;
    }
    /* Add animation (fade in the popup) */
    @-webkit-keyframes fadeIn {
    from {opacity: 0;} 
    to {opacity: 1;}
    }

    @keyframes fadeIn {
    from {opacity: 0;}
    to {opacity:1 ;}
    }

    </style>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Vue JS -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/vue"></script> -->
</head>
<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
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
<body>   
    <!-- NAVBAR HERE COPY AND PASTE THIS SHIT IDK HOW ELSE TO INTEGRATE TO OTHER PAGES LOL -->
    <div class="w3-top">
        <div class="w3-bar w3-white w3-card" id="myNavbar">
        <a href="#home" class="w3-bar-item w3-button w3-wide"><img src='./img/earthchan.png' height="48px"
            width="48px">Health is Wealth</a>
        <!-- Right-sided navbar links -->
        <div class="w3-right w3-hide-small">
            <a href="planmeal.html" class="w3-bar-item w3-button"><i class="fa fa-user"></i> Plan My Meal</a>
            <a href="whatinmeal.html" class="w3-bar-item w3-button"><i class="fa fa-th"></i> What's In My Meal? </a>
            <a href="schedule" class="w3-bar-item w3-button"><i class="fa fa-calendar" aria-hidden="true"
                style="font-size:25px"></i></a>
            <a href="profile.html" class="w3-bar-item w3-button"><i class="fas fa-user-circle"
                style="font-size:25px"></i></a>
        </div>
        <!-- Hide right-floated links on small screens and replace them with a menu icon -->

        <a href="javascript:void(0)" class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium"
            onclick="w3_open()">
            <i class="fa fa-bars"></i>
        </a>
        </div>
    </div>

    <div id="app" class="container-fluid">
        <section>
            <div  style="padding-top: 10rem;">
        <h3 v-if="displayTxt === false" class="animate__heartBeat text-center w3-xxlarge w3-cursive w3-text-white mt-5 mb-5">
            Upload an Image below to view its recipe and contents!</h3>
        <h3 v-if="displayTxt === true" class="animate__heartBeat text-center w3-xxlarge w3-text-white w3-cursive mt-5 mb-5">Is the
            information given accurate? Otherwise, please use our search function.</h3>
            <div class="mb-3">
                <div class="search">
                    <input type="text" v-model="message" v:bind:value='message' placeholder="Search.." name="search" id='srchforRec'>
                    <button id='pSearch' v-on:click='srchRecipe'><i class="fa fa-search"></i></button>
                </div>
            </div>
        <div class="image-upload-wrap">

                <span class="drag-text">
                    <input class="file-upload-input" id='file' type='file' v-on:change="display" onchange="readURL(this);"
                        accept="image/*" />
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
    const get_curr_url = "http://127.0.0.1:5200/ana/recipe_image";
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
            srchRecipe: function(event) {
                let jsonData = JSON.stringify({
                        food: this.message
                });

                fetch("http://127.0.0.1:5100/ana/recipe", {
                            method: "POST",
                            headers: {
                                "Content-type": "application/json"
                            },
                            body: jsonData
                        }).then(response => response.json())
                        .then(data => {
                            resultlist = data.data.hits;
                            displaytab = `
                                <table class="mt-5">
                                        <tr>
                                            <th class='w3-cursive w3-xxlarge w3-wide'>
                                                Search Results 
                                            </th>
                                        </tr>`;                    
                            for(i=0;i<resultlist.length;i++){
                                temprecipe = resultlist[i].recipe;
                                console.log(temprecipe);
                                name_of_dish = temprecipe.label;
                                console.log(name_of_dish);
                                findoutmore = temprecipe.shareAs
                                nutrientObj = temprecipe.totalNutrients                                
                                console.log(findoutmore)
                                console.log(nutrientObj)
                                
                                let tablehere = `<table class="table text-white">
                                                <tr>
                                                    <th>
                                                        Nutrient
                                                    </th>
                                                    <th>
                                                        Value
                                                    </th>
                                                </tr>`;
                                for(let [key,value] of Object.entries(nutrientObj)){

                                    tablehere += `
                                        <tr>
                                            <th> 
                                                ${value.label}
                                            </th>
                                            <th>
                                                ${value.quantity.toFixed(2) + " " + value.unit}
                                            </th>
                                        </tr>`;
                                }
                                tablehere += `</table>`;
                                
                                displaytab += `
                                    <tr>
                                        <th>
                                            <div class="popup" onclick="myFunction(${i})" style="font-size: 1.5rem !important;"> ${name_of_dish}
                                                <span class="popuptext card" style="width: 23rem;" id="myPopup${i}">
                                                    <div class="card-body scrollable">
                                                        <h5 class="card-title w3-cursive w3-xxlarge w3-wide">${name_of_dish}</h5>
  
                                                        ${tablehere}
                                                        
                                                        <a href="${findoutmore}" class="btn btn-primary">Find out more</a>
                                                        
                                                        <a href="<?=$url?>"><i class="fab fa-linkedin-in"></i></a>
                                                    </div>
                                                    </span>
                                            </div>
                                        </th>
                                    </tr>`;
                            }
                            displaytab += `</table>`;
                            document.getElementById("displayinfo").innerHTML = displaytab;
                        })
            }
        },
    })
    
            function myFunction(i){
                var popup = document.getElementById(`myPopup${i}`);
                popup.classList.toggle("show");
            }

            function searchFor(i){
                console.log(i);
                zeText = document.getElementById(`imgsrch${i}`).innerText
                console.log(zeText);
                document.getElementById('srchforRec').value = zeText
                return zeText
            }
    const file = document.getElementById('file')
    //const img=document.getElementById('img')
    file.addEventListener('change', ev => {
        const formdata = new FormData()
        formdata.append("image", ev.target.files[0])
        fetch("https://api.imgur.com/3/image/", {
            method: "post",
            headers: {
                Authorization: "Client-ID 0e1d07aeb2818f9"
            },
            body: formdata
        }).then(data => data.json()).then(data => {
            console.log(data);
            const imgurLink = data.data.link;
            fetch(get_curr_url, {
                    method: "post",
                    headers: {
                        'Content-Type': "application/json",
                        "Accept": "application/json",
                        'Access-Control-Allow-Origin': 'http://127.0.0.1',
                        'Access-Control-Allow-Credentials': 'true',
                    },
                    body: JSON.stringify({
                        "link": imgurLink
                    })
                }).then(data => data.json())
                .then(data => {
                    console.log(data);
                    console.log(JSON.parse(data.strjsonobj));
                    retobj = JSON.parse(data.strjsonobj);
                    retlist = retobj.result;
                    displaytab = `
                <table class="makebigger">
                        <tr>
                            <th class='w3-cursive w3-xxxlarge w3-wide'>
                                Suggestions
                            </th>
                        </tr>`;
                    if (retlist.length < 10) {
                        for (i = 0; i < retlist.length; i++) {
                            displaytab += `
                            <tr>
                                <th>
                                    <button class='btn btn-outline-info' id='imgsrch${i}' onclick="searchFor(${i})">${textname}</button>
                                </th>
                            </tr>
                        `;
                        }
                    } else {
                        for (i = 0; i < 10; i++) {
                            let textname = retlist[i].name
                            
                            displaytab += `
                            <tr>
                                <th>
                                    <button class='btn btn-outline-info' id='imgsrch${i}' onclick="searchFor(${i})">${textname}</button>
                                </th>
                            </tr>
                        `;
                        }
                    }
                    displaytab += `</table>`;
                    document.getElementById("displayinfo").innerHTML = displaytab;
                })
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