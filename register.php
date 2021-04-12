<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Main loader -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="js/ScriptLoader.js"></script>
  <script src="js/navbar.js"></script>
  <link rel="stylesheet" href="css/main.css">
  
  <!-- Google Sign in -->
  <meta name="google-signin-client_id"
    content="1051698943672-lrutkkrvnsu86ri9gdbe25m2c6hqha43.apps.googleusercontent.com">
  <script src="https://apis.google.com/js/platform.js" async defer></script>
  <script src="https://apis.google.com/js/platform.js?onload=init" async defer></script>

  <title>Register</title>
</head>


<body>
  <div class="container" style="padding-top: 10rem;" id="register">
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
      
      <button type="submit" class="btn btn-primary" id="signUp" v-on:click="register()">Sign up!</button>

      <br>
      <div id = 'register_status'>
      </div>
      <br>
      <a href="./login.php">Have an account? Login here!</a>
      <div class="g-signin2" data-onsuccess="onSignIn"></div>
    </form>
    <!-- Form End -->
  </div>
</body>
<!-- JS Part -->
<script>
  function onSignIn(googleUser) {
    let register_status = document.getElementById('register_status');
    register_status.innerHTML = `
      <div class="alert alert-warning" role="alert">
        Loading... ... ...
      </div>`
    var id_token = googleUser.getAuthResponse().id_token;

    var url = "http://localhost:8000/api/v1/google/create";
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
        // console.log(data)
        // console.log(data.code)
        if (data.code == 201) {
          register_status.innerHTML = `
          <div class="alert alert-success" role="alert">
            Success!
          </div>`
          //redirect to profile if successful
          localStorage.setItem("username", data.data.username)
          window.location.replace("./profile.php")
        }
        if (data.code == 500){
          register_status.innerHTML = `
          <div class="alert alert-danger" role="alert">
            ${data.data.message}
          </div>`
          }   
      })
    }

  document.getElementById('signUp').addEventListener('click',function(event) {
    let register_status = document.getElementById('register_status');
    register_status.innerHTML = `
      <div class="alert alert-warning" role="alert">
        Loading... ... ...
      </div>` 
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
    fetch('http://localhost:8000/api/v1/useraccount/create', {
    
      method: 'POST',
      headers: {
          'Content-type': 'application/json',     
      },
      body: data  
    })
    .then((res) => res.json())
    .then((data) => {
      // console.log(data)
      // console.log(data.code)
      if (data.code == 201){
        register_status.innerHTML = `
          <div class="alert alert-success" role="alert">
            Success!
          </div>`
        localStorage.setItem("username", data.data.username)
        window.location.replace("./profile.php")
        } 
      if (data.code == 500){
        register_status.innerHTML = `
          <div class="alert alert-danger" role="alert">
            ${data.data.message}
          </div>`
      }
      });
    })   
</script>

</html>