<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Main loader -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="js/ScriptLoader.js"></script>
    <script src="js/navbar.js"></script>
    <link rel="stylesheet" href="css/main.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>



    <title> Landing Plan </title>
</head>
<script>
    if (localStorage.getItem('username') == null) {
            localStorage.setItem("alertMsg", "You need to be a validated user first before accessing the meal planning page!")
            window.location.replace("index.php")
        }
</script>
<body>

<div class="container-fluid w3-grayscale-min" id="landing_plan" style="padding-top: 10rem;">
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

<script>

    var app = new Vue({
        el: "#landing_plan",
        data: {
            username: localStorage.getItem('username'),
            data: ""
        },
        methods: {
            getData: function(){
                data = JSON.stringify({
                'username': this.username,
                })
                fetch("http://localhost:8000/api/v1/meal",{
                    method: 'POST',
                    headers: {
                        'content-type': 'application/json',

                    },
                    body: data
                }).then((response)=> response.json())
                .then((data)=>{
                    this.data = data.data.Meal
                    // console.log(this.data)
                })
            },
            deleteMeal: function(id){
                console.log(id);
                data = JSON.stringify({
                'id': id.toString(),
                'username' : username.toString(),
                })
                fetch("http://localhost:8000/api/v1/meal/delete",{
                    method: 'POST',
                    headers: {
                        'content-type': 'application/json',

                    },
                    body: data,
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