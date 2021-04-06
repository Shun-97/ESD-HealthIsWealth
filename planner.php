<!DOCTYPE html>
<html lang="en">
<head>
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


    <title> Planner </title>
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

    <div class="container" id="landing_plan" style="padding-top: 10rem;">
        <h1 class="display-4">Nutrition List Search</h1>
        Search food item: <input type="text" id="query" v-model="query">
        <button type="button" id="submit" v-on:click="fetchData">Search</button>
        <div id="queryInfo">
            <!-- To input query inforation and let users add the food -->
        </div>
        <div style="display:none" id="addBtn">
            <button class="btn btn-primary" v-on:click="addFood">Add food item</button>
        </div>
        <ul>
            <li v-for="food in data">{{food}}</li>
        </ul>
        <p>Total Calories: {{total_calories}}</p>
        <button v-on:click="addToDatabase" class="btn btn-primary">Create Meal Plan</button>
    </div>


</body>

<!-- Bootstrap  -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> 

<script>
    var app = new Vue({
        el: "#landing_plan",
        data: {
            username: "admin",
            data: [],
            total_calories: 0,
            query: "",
            calories: 0,
            foodName: ""
        },
        methods: {
            fetchData : function(){ 
                
                data = JSON.stringify({
                'query': this.query
                })
                console.log(data)

                fetch('http://127.0.0.1:6100/api/calories', {

                    method: 'POST',
                    headers: {
                        'content-type': 'application/json',

                    },
                    body: data
                })
                .then((response) => response.json())
                .then((data) => {
                    console.log(data.items[0]);
                    document.getElementById("queryInfo").innerHTML = data.items[0].calories +" "+ data.items[0].name;
                    document.getElementById("addBtn").style.display = "inline";
                    this.calories = data.items[0].calories;
                    this.foodName = data.items[0].name;

                })
            },
            addFood: function(){
                this.data.push(this.foodName);
                this.total_calories += this.calories;
                console.log(this.data);
                console.log(this.total_calories);
            },
            addToDatabase: function(){
                data = JSON.stringify({
                'username': this.username,
                'total_calories': this.total_calories,
                'description': this.data.join(",")
                })
                fetch("http://127.0.0.1:6100/api/calories/create",{
                    method: 'POST',
                    headers: {
                        'content-type': 'application/json',

                    },
                    body: data
                }).then((response)=> response.json())
                .then((data)=>{
                    console.log(data)
                    window.location.replace("./landing_plan.php")
                })
            }
        }
    })
</script>
</html>