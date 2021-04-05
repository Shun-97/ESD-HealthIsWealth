<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Bootstrap CDN -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
    integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <!-- Personal CSS -->
  <link rel="stylesheet" type="text/css" href="{{ url_for('static', filename='main.css')}}" />
  <!-- Vue JS -->
  <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
  <!-- jquery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- Axios  -->
  <script src="https://unpkg.com/axios/dist/axios.js"></script>
  <!-- Google Sign in -->
  <meta name="google-signin-client_id"
    content="1051698943672-lrutkkrvnsu86ri9gdbe25m2c6hqha43.apps.googleusercontent.com">
  <script src="https://apis.google.com/js/platform.js" async defer></script>
  <script src="https://apis.google.com/js/platform.js?onload=init" async defer></script>

  <title>Register</title>
</head>


<body>
  <div class="container" id="register">
    <h1>Registration</h1>
    <!-- Form Start -->
    <form method="POST">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="username" class="form-control" id="username" v-model="username" name="username">
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" v-model="email" name="email">
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" v-model="password" name="password">
      </div>
      <!-- <div class="mb-3">
              <label for="confirmPassword" class="form-label">Confirm Password</label>
              <input type="password" class="form-control" id="confirmPassword">
            </div> -->
      <button type="submit" class="btn btn-primary" id="signUp" v-on:click="register()">Sign up!</button>
      <!-- <button v-on:click="register()">click me</button> -->
      <label id="error" class="text-danger"></label>
      <br>
      <a href="./login.php">Have an account? Login here!</a>
      <div class="g-signin2" data-onsuccess="onSignIn"></div>
    </form>
    <!-- Form End -->
  </div>
</body>

<!-- Bootstrap  -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
  integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
  integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
  integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<!-- JS Part -->
<script>
  function onSignIn(googleUser) {
    var id_token = googleUser.getAuthResponse().id_token;

    var url = "http://127.0.0.1:5110/api/google_signup";
    const data = JSON.stringify({
        idtoken: id_token,
      });
      fetch(url,{
        method: "POST",
        headers:{"Content-type": "application/x-www-form-urlencoded"},
        body: data
      })
      .then(response => response.json())
      .then(data => {
        console.log(data)
        console.log(data.code)
        if (data.code == 201) {
          //redirect to profile if successful
          localStorage.setItem("username", data.data.username)
          window.location.replace("./profile.php")
        }
      })
    }

  document.getElementById('signUp').addEventListener('click',function(event) { 
    event.preventDefault();
    console.log('LOL')
    name = document.getElementById('username').value
    password = document.getElementById('password').value
    email = document.getElementById('email').value
    data = JSON.stringify({
      'username': name,
      'password': password,
      "email": email
    })
    console.log(name,password,email,data)
    fetch('http://0.0.0.0:5000/api/register/verification', {
    
      method: 'POST',
      headers: {
          'Content-type': 'application/json',     
      },
      body: data  
    })
    .then((res) => res.json())
    .then((data) => {
      console.log(data)
      console.log(data.code)
      if (data.code == 201){
        localStorage.setItem("username", data.data.username)
        window.location.replace("./profile.php")
        } 
      if (data.code == 500){
        document.getElementById('error').innerHTML = data.data
      }
      });
    })   
</script>

</html>