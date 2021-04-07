<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        #landing_plan{
            background-position: center;
            background-size: cover;
            background-image: url("img/plan1.jpg");
            min-height: 100%;   
        }
        .overlay {
            z-index: 1;
            height: 100%;
            width: 100%;
            position: fixed;
            overflow: auto;
            top: 0px;
            left: 0px;
            background: rgba(0, 0, 0, 0.4);
        }
        table tr td, table tr th{
            background-color: rgba(5,5,5, 0.3) !important;
        }
    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <!-- Styling and JS -->
    <script src="./js/navbar.js"></script>
    <link rel="stylesheet" href="./css/main.css">
    <!-- Font Awesome -->
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <!-- Vue JS -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Axios  -->
    <script src="https://unpkg.com/axios/dist/axios.js"></script> 


    <title> Landing Plan </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
 <!-- NAVBAR HERE COPY AND PASTE THIS SHIT IDK HOW ELSE TO INTEGRATE TO OTHER PAGES LOL -->
    <div class="w3-top">
        <div class="w3-bar w3-white w3-card" id="myNavbar">
            <a href="#home" class="w3-bar-item w3-button w3-wide"><img src='./img/earthchan.png' height="48px"
                width="48px">Health Is Wealth</a>
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

    <div class="w3-display-container w3-grayscale-min" id="landing_plan" style="padding-top: 10rem;">
    <div class='overlay'>
        <div class="w3-display-left w3-text-white" style="padding:48px">
        <span class="w3-xxlarge w3-hide-small"> Good Day! How would you like to plan your meals today?</span><br>
        <!-- <button class="btn btn-primary"> Do recommendation, based on receiving top 5 information of recent food, if calories are above 1.3k, recommend salad </button> -->
        <table class="table table-dark table-condensed table-bordered">  
        <tr>
        <th class="w3-cursive w3-xlarge w3-wide">Recent Food that you consumed</th>
        <th class="w3-cursive w3-xlarge w3-wide">Calories</th>
        <th class="w3-cursive w3-xlarge w3-wide">Actions</th>
        </tr>
        <tr v-for="food in data">
        <td class="active" >{{food.Description}} </td>
        <td class="active"> {{food.Total_Calories.toFixed(2)}} Cal</td>
        <td><button v-on:click="deleteMeal(food.Id)" class="btn btn-danger">Delete</button></td>
        </tr>
        </table>
        <a class="btn btn-primary" href="./planner.php">Create New Meal Plan</a>
    </div>
    </div>
</div>
</body>

<!-- Bootstrap  -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> 

<script>

    //username: localStorage.getItem('username'),
    var app = new Vue({
        el: "#landing_plan",
        data: {
            username: "admin",
            data: ""
        },
        methods: {
            getData: function(){
                data = JSON.stringify({
                'username': this.username,
                })
                fetch("http://127.0.0.1:6100/api/meal",{
                    method: 'POST',
                    headers: {
                        'content-type': 'application/json',

                    },
                    body: data
                }).then((response)=> response.json())
                .then((data)=>{
                    console.log(data)
                    this.data = data.data.Meal
                    console.log(this.data)
                })
            },
            deleteMeal: function(id){
                console.log(id);
                fetch("http://127.0.0.1:6100/api/meal/"+id,{
                    method: 'DELETE',
                    headers: {
                        'content-type': 'application/json',

                    },
                }).then((response)=> response.json())
                .then((data)=>{
                    location.reload();
                })
            }
        },
        created: function(){
            this.getData()
        }

    })
</script>
</html>