<!DOCTYPE html>
<html lang="en">

<head>
    <script>
        if (localStorage.getItem('username') == null) {
            localStorage.setItem("alertMsg", "You need to be a validated user first before accessing the profile page!")
            window.location.replace("index.php")
        }
    </script>

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Main loader -->
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="js/ScriptLoader.js"></script>
<script src="js/navbar.js"></script>
<link rel="stylesheet" href="css/main.css">
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>

<title>Profile</title>

</head>


<body>
    <div class="container" style="padding-top: 10rem;" id="app">
        <h1>Profile</h1>
        <h3>Welcome! {{user}}</h3>
        <form method="POST">
            <div class="mb-3">
                <label for="height" class="form-label">Height (in m)</label>
                <input type="number" class="form-control" id="height" name="height" v-model="height">
            </div>
            <div class="mb-3">
                <label for="wieght" class="form-label">Weight (in kg)</label>
                <input type="number" class="form-control" id="weight" name="weight" v-model="weight">
            </div>
            <div class="mb-3">
                <label for="bmi" class="form-label">BMI</label>
                <input type="number" class="form-control" id="bmi" name="bmi" v-model="bmi">
            </div>
            <div class="mb-3">
                <label for="calories" class="form-label">Set your targeted calories per day</label>
                <input type="number" class="form-control" id="calories" name="calories" v-model="calories">
            </div>
            <br>
            <h3></h3>
            <div class="mb-3">
                <label for="calories" class="form-label">Change your Telegram ID</label>
                <input type="number" class="form-control" id="telegramid" name="telegramid" v-model="telegramid">
            </div>
        </form>
        <br>
        <button class="btn btn-primary" v-on:click="updateUserAccount">Save</button>
        <!-- <label id="error" class="text-danger">{{error}}</label> --> 
        <button class="btn btn-danger" v-on:click="logout">Logout</button>
    </div>

</body>

<script>
// console.log(localStorage.getItem('username'))

var app = new Vue({
    el: '#app',
    data: {
        user: localStorage.getItem('username'),
        weight: 0.0,
        height: 0.0,
        calories: 0.0,
        telegramid: '',
    },
    computed: {
        bmi: function() {
            return ((this.weight/(this.height)**2).toFixed(2))
        }
    },
    methods: {
        logout: function(){
            // console.log("logout");
            localStorage.removeItem('username');
            window.location.replace("./index.php");
        },
        getUserAccount: function(){
            // console.log("getUserAccount");
            data = JSON.stringify({
            'username': this.user,
            })
            // console.log(data)
            fetch('http://localhost:8000/api/v1/useraccount', {
            
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
                    this.height = data.data[0]["Height"]
                    this.weight = data.data[0]["Weight"]
                    this.bmi = data.data[0]["BMI"]
                    this.calories = data.data[0]["Requested_Calories"]
                    this.telegramid = data.data[0]["TelegramId"]
                    localStorage.setItem("tele_id", data.data[0]["TelegramId"])
                } 
            });
            },
        updateUserAccount: function(){
            // console.log("updateUserAccount");
            data = JSON.stringify({
            'username': this.user,
            'weight': this.weight,
            'height': this.height,
            'bmi': this.bmi,
            'calories': this.calories,
            'telegramid': this.telegramid
            })
            fetch('http://localhost:8000/api/v1/useraccount/update', {
            
                method: 'POST',
                headers: {
                    'Content-type': 'application/json',     
                },
                body: data
            })
            .then((res) => res.json())
            .then((data) => {
                // console.log(data)
                if (data.code == 201){
                    // console.log("success")
                    this.height = data.data[0]["Height"]
                    this.weight = data.data[0]["Weight"]
                    this.bmi = data.data[0]["BMI"]
                    this.calories = data.data[0]["Requested_Calories"]
                    this.telegramid = data.data[0]["TelegramId"]
                    location.reload();
                } 
            });
            }
        },
    // Run this function when the page load  
    beforeMount(){
        this.getUserAccount();
    }
})

</script>

</html>