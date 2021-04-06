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

    <div class="w3-display-container w3-grayscale-min" id="landing_plan" style="padding-top: 10rem;">
        <div class='overlay'>
        
            <div class="w3-display-left w3-text-white" style="padding:48px">
                <h1 class="display-4" style="padding-top: 10rem;">Nutrition List Search</h1>
                    Search food item: <input type="text" id="query" v-model="query">
                    <button type="button" class="btn btn-primary" id="submit" v-on:click="fetchData">Search</button>
                        <div id="queryInfo">
                <!-- To input query inforation and let users add the food -->
                        </div>
                        <br>
                <h1 class="w3-cursive w3-xlarge w3-wide"><strong>Food to Add</strong>: {{foodName}}</h1>
                <table class="table table-dark table-condensed table-bordered"> 
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Nutritions List</th>
                                        <td> Values </td>
                                    </tr>
                                    <tr>
                                        <th>Serving Size (g)</th>
                                        <td>{{serving_size_g}}</td>
                                    </tr>
                                    <tr>
                                        <th>Sugar (g)</th>
                                        <td>{{sugar_g}}</td>
                                    </tr>
                                    <tr>
                                        <th>Fiber (g)</th>
                                        <td>{{fiber_g}}</td>
                                    </tr>
                                    <tr>
                                        <th>Sodium (mg)</th>
                                        <td>{{sodium_mg}}</td>
                                    </tr>
                                    <tr>
                                        <th>Potassium (mg)</th>
                                        <td>{{potassium_mg}}</td>
                                    </tr>
                                    <tr>
                                        <th>Saturated Fats (g)</th>
                                        <td>{{fat_saturated_g}}</td>
                                    </tr>
                                    <tr>    
                                        <th>Total Fats (g)</th>
                                        <td>{{fat_total_g}}</td>
                                    </tr>
                                    <tr>
                                        <th>Calories</th>
                                        <td>{{calories}}</td>
                                    </tr>
                                    <tr>
                                        <th>Cholesterol (mg)</th>
                                        <td>{{cholesterol_mg}}</td>
                                    </tr>
                                    <tr>
                                        <th>Protein (g)</th>
                                        <td>{{protein_g}}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Carbohydrates (g)</th>
                                        <td>{{carbohydrates_total_g}}</td>
                                    </tr>

                                </thead>
                            </table>
                <div style="display:none" id="addBtn">
                    <button class="btn btn-primary mt-3" v-on:click="addFood">Add food item</button>
                </div>
                
                <table class="table table-info table-condensed table-bordered mt-3"> 
                    <thead class="thead-info">
                        <tr>
                            <th>Currently Added food</th>
                        </tr>
                        <tr v-for="food in data">
                            <th> {{food}} </th>
                        </tr>
                    </thead>
                </table>
        <br>
        
        <table class="table table-info table-condensed table-bordered">  </table>
        <button v-on:click="addToDatabase" class="btn btn-primary"> Create Meal Plan </button>
        <a href="landing_plan.php"><button class="btn btn-warning"> Back </button></a>
            </div>
        </div>
    </div>
</div>  
<div id="dizplaymodal2"></div>
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
            calories: "",
            foodName: "Nothing yet",
            serving_size_g: "",
            sugar_g: "",
            fiber_g: "",
            sodium_mg: "",
            potassium_mg: "",
            fat_saturated_g: "",
            fat_total_g: "",
            cholesterol_mg: "",
            protein_g: "",
            carbohydrates_total_g: "",
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
                    // document.getElementById("queryInfo").innerHTML = data.items[0].calories +" "+ data.items[0].name;
                    document.getElementById("addBtn").style.display = "inline";
                    this.calories = data.items[0].calories;
                    this.foodName = data.items[0].name;
                    this.sugar_g = data.items[0].sugar_g;
                    this.fiber_g = data.items[0].fiber_g;
                    this.serving_size_g = data.items[0].serving_size_g;
                    this.sodium_mg = data.items[0].sodium_mg;
                    this.potassium_mg = data.items[0].potassium_mg;
                    this.fat_saturated_g = data.items[0].fat_saturated_g;
                    this.fat_total_g = data.items[0].fat_total_g;
                    this.cholesterol_mg = data.items[0].cholesterol_mg;
                    this.protein_g = data.items[0].protein_g;
                    this.carbohydrates_total_g = data.items[0].carbohydrates_total_g;

                })
            },
            addFood: function(){
                this.data.push(this.foodName);
                this.total_calories += this.calories;
                console.log(this.data);
                console.log(this.total_calories);
                alertmodal = `
                          <div class="modal fade" id="alrtz2" tabindex="-1">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title text-Success"> Added! </h5>
                                  <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ${this.foodName} has been added into Meal Plan!
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                              </div>
                            </div>`;
                document.getElementById('dizplaymodal2').innerHTML = alertmodal;
                $('#alrtz2').modal('show');
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