<!DOCTYPE html>
<html lang="en">

<head>
    <script>

        if (localStorage.getItem('username') == null) {
            window.location.replace("index.php")
        }
    </script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css"
        integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <!-- Personal Stylesheet -->
    <link rel="stylesheet" type="text/css" href="./css/main.css" />
    <!-- NEEDED FOR NAVBAR TO WORK-->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <!-- Vue JS -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Axios  -->
    <script src="https://unpkg.com/axios/dist/axios.js"></script>
    <script src="https://apis.google.com/js/platform.js?onload=init" async defer></script>
    <script src="js/google_session.js"></script>


    <title>Profile</title>
</head>


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
        <a href="javascript:void(0)" onclick="w3_close()" class="w3-bar-item w3-button w3-large w3-padding-16">Close
            ×</a>
        <a href="planmeal.html" onclick="w3_close()" class="w3-bar-item w3-button">Plan My Meal</a>
        <a href="whatinmeal.html" onclick="w3_close()" class="w3-bar-item w3-button">What's In My Meal?</a>
        <a href="schedule.html" onclick="w3_close()" class="w3-bar-item w3-button"><i class="fa fa-calendar"
                aria-hidden="true" style="font-size:25px"></i></a>
        <a href="profile.html" onclick="w3_close()" class="w3-bar-item w3-button"><i class="fas fa-user-circle"
                style="font-size:25px"></i></a>
    </nav>
    <!-- NAVBAR ENDS HERE COPY AND PASTE THIS SHIT IDK HOW ELSE TO INTEGRATE TO OTHER PAGES LOL -->

    <div class="container" id="app">
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
        </form>
        <button class="btn btn-primary" v-on:click="updateUserAccount">Save</button>
        <!-- <label id="error" class="text-danger">{{error}}</label> --> 
        <button class="btn btn-primary" v-on:click="logout">Logout</button>
    </div>

</body>

<!-- Bootstrap  -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
    integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
    crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
    integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
    crossorigin="anonymous"></script>
<!-- <script src="{{url_for('static', filename='script.js')}}"></script> -->
<!-- JS Part -->
<script>
console.log(localStorage.getItem('username'))

var app = new Vue({
    el: '#app',
    data: {
        user: localStorage.getItem('username'),
        weight: 0.0,
        height: 0.0,
        calories: 0.0,
    },
    computed: {
        bmi: function() {
            return ((this.weight/(this.height)**2).toFixed(2))
        }
    },
    methods: {
        logout: function(){
            console.log("logout");
            localStorage.removeItem('username');
            window.location.replace("./index.php");
        },
        getUserAccount: function(){
            console.log("getUserAccount");
            data = JSON.stringify({
            'username': this.user,
            })
            console.log(data)
            fetch('http://127.0.0.1:5100/api/userAccount', {
            
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
                    this.height = data.data[0]["Height"]
                    this.weight = data.data[0]["Weight"]
                    this.bmi = data.data[0]["BMI"]
                    this.calories = data.data[0]["Requested_Calories"]

                } 
            });
            },
        updateUserAccount: function(){
            console.log("updateUserAccount");
            data = JSON.stringify({
            'username': this.user,
            'weight': this.weight,
            'height': this.height,
            'bmi': this.bmi,
            'calories': this.calories
            })
            fetch('http://127.0.0.1:5100/api/userAccount/update', {
            
                method: 'POST',
                headers: {
                    'Content-type': 'application/json',     
                },
                body: data
            })
            .then((res) => res.json())
            .then((data) => {
                console.log(data)
                if (data.code == 201){
                    console.log("success")
                    this.height = data.data[0]["Height"]
                    this.weight = data.data[0]["Weight"]
                    this.bmi = data.data[0]["BMI"]
                    this.calories = data.data[0]["Requested_Calories"]
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