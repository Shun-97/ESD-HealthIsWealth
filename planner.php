<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Main loader -->
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="js/ScriptLoader.js"></script>
<script src="js/navbar.js"></script>
<link rel="stylesheet" href="css/main.css">
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>

<title> Planner </title>
<!-- check for login -->
<script>
    if (localStorage.getItem('username') == null) {
            localStorage.setItem("alertMsg", "You need to be a validated user first before accessing the meal planning page!")
            window.location.replace("index.php")
        }
</script>
</head>

<body>
<div class="container-fluid w3-grayscale-min" id="landing_plan" style="padding-top: 10rem;">
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
                        <th>Actions</th>
                    </tr>
                    <tr v-for="(food,index) in data">
                        <th> {{food}} </th>
                        <th><button v-on:click="deleteFood(index)" class="btn btn-danger">Delete</button></th>
                    </tr>
                </thead>
            </table>
            <h3 id='Total' v-bind:style="styleObject">Total Calories: {{total_calories}}</h3>
            <br>
        
            <table class="table table-info table-condensed table-bordered">  </table>
            <button v-on:click="addToDatabase" class="btn btn-primary"> Create Meal Plan </button>
            <a href="landing_plan.php"><button class="btn btn-warning"> Back </button></a>
        </div>
    </div>
</div>
<div id="dizplaymodal2"></div>

</body>

<script>
    if (localStorage.getItem('tele_id') == 0 || !localStorage.getItem('tele_id')) {
        alert('No telegramID Found! Please input a telegramid in the profile page for the full experience')
    }
    var app = new Vue({
        el: "#landing_plan",
        data: {
            username: localStorage.getItem('username'),
            data: [],
            calories_breakdown: [],
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
        computed: {
            styleObject: function() {
                if (this.total_calories > 1000) {
                    style =  {
                    'color': 'red',
                    'font-weight': 'bold'
                    }
                    return style
                }
                else {
                    style =  {
                    'color': 'white',
                    'font-weight': 'normal'
                    }
                    return style
                }
            }
        },
        methods: {
            fetchData : function(){ 
                
                data = JSON.stringify({
                'query': this.query
                })
                // console.log(data)

                fetch('http://localhost:8000/api/v1/calories', {

                    method: 'POST',
                    headers: {
                        'content-type': 'application/json',

                    },
                    body: data
                })
                .then((response) => response.json())
                .then((data) => {
                    // console.log(data.items);
                    if (data.items.length == 0) {
                        alert('No item found. Please try again')
                    }
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
                this.calories_breakdown.push(this.calories);
                this.total_calories += this.calories;
                // console.log(this.data);
                // console.log(this.total_calories);

                alertmodal = `
                          <div class="modal fade" id="alrtz2" tabindex="-1">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title text-Success"> Added! </h5>
                                  
                                </div>
                                <div class="modal-body">
                                    ${this.foodName} has been added into Meal Plan!
                                    <div id='warning_display' style ='color: red; font-weight: bold'></div>
                                </div>
                                <div class="modal-footer">
                                    <span class="text-muted">Click anywhere outside the box to close this</span>
                                </div>
                              </div>
                            </div>`;
                document.getElementById('dizplaymodal2').innerHTML = alertmodal;
                if (this.total_calories > 1000) {
                    document.getElementById('warning_display').innerHTML = `WARNING, YOU HAVE EXCEEDED YOUR DAILY CALORIES INTAKE. 
                                    PLEASE GET SOMETHING HEALTHIER`
                }
                else {
                    document.getElementById('warning_display').innerHTML = ''
                }
                $('#alrtz2').modal('show');
            },
            addToDatabase: function(){
                data = JSON.stringify({
                'username': this.username,
                'total_calories': this.total_calories,
                'description': this.data.join(","),
                'telegramid': localStorage.getItem('tele_id')
                })
                fetch("http://localhost:8000/api/v1/meal/create",{
                    method: 'POST',
                    headers: {
                        'content-type': 'application/json',

                    },
                    body: data
                }).then((response)=> response.json())
                .then((data)=>{
                    // console.log(data)
                    window.location.replace("./landing_plan.php")
                })
            },
            deleteFood: function(id){
                this.data.splice(id,1);
                this.calories_breakdown.splice(id,1);
                this.total_calories = this.calories_breakdown.reduce(function(a, b){
                return a + b;
                    }, 0);

            }
        }
    })
</script>
</html>