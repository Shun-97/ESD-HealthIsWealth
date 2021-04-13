<!DOCTYPE html>
<html lang="en">
<head>
<?php
  require_once "./auth/init.php";
?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Main loader -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="js/ScriptLoader.js"></script>
  <script src="js/navbar.js"></script>
  <link rel="stylesheet" href="css/main.css">

  <!-- Google Sign in -->
  <meta name="google-signin-client_id" content="1051698943672-lrutkkrvnsu86ri9gdbe25m2c6hqha43.apps.googleusercontent.com">
  <script src="https://apis.google.com/js/platform.js" async defer></script>
  <script type="text/javascript" src="http://platform.linkedin.com/in.js"></script>
  <script src="https://apis.google.com/js/platform.js?onload=init" async defer></script>

  <title>Login Page</title>
</head>

<body>

  <div class="container" style="padding-top: 10rem;" id="login" >
    <h1>Login</h1>
    <form method="POST">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="username" class="form-control" id="username"name="username">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password"name="password">
        </div>
        <br>
        <button id ='login_button' class="btn btn-primary">Login</button>
        <!-- <button class="btn btn-primary" v-on:click="validatePassword()">Login</button> -->
    </form>
    <br>
    <!-- <button v-on:click="register()">click me</button> -->
    <div id = 'login_status'>
    </div>
    <br>
    <a href="register.php">Don't have an account? Sign up here!</a>
    <div>
    <span class="g-signin2" data-onsuccess="onSignIn"></span>
    </div>
</div>
</body>
  <!-- JS Part -->
  <script type="application/javascript">
    function onSignIn(googleUser){
      let login_status = document.getElementById('login_status');
      login_status.innerHTML = `
      <div class="alert alert-warning" role="alert">
        Loading... ... ...
      </div>`

      var id_token = googleUser.getAuthResponse().id_token;

      var url = "http://localhost:8000/api/v1/google/login";
      const data = JSON.stringify({
        idtoken: id_token,
      });
      fetch(url,{
        method: "POST",
        headers:{"Content-type": "application/x-www-form-urlencoded"},
        body: data
      })
      .then(response => response.json())
      //grab the returned response
      .then(data => {
        if (data.code == 201){
          login_status.innerHTML = `
          <div class="alert alert-success" role="alert">
            Success!
          </div>`
          localStorage.setItem("username", data.data.username)
          // localStorage.setItem('auth2', data.data.auth)
          window.location.replace("./profile.php")
        }
        if (data.code == 500){
          login_status.innerHTML = `
          <div class="alert alert-danger" role="alert">
            ${data.data.message}
          </div>`
          }   
      })


    }

    document.getElementById('login_button').addEventListener('click',function(event) { 
      let login_status = document.getElementById('login_status');
      login_status.innerHTML = `
      <div class="alert alert-warning" role="alert">
        Loading... ... ...
      </div>`

      event.preventDefault();
      // console.log('LOL')
      name = document.getElementById('username').value
      password = document.getElementById('password').value
      data = JSON.stringify({
        'username': name,
        'password': password
      })
      //change to this URL for KONG --> http://0.0.0.0:8000/api/v1/login
      fetch('http://localhost:8000/api/v1/login', { 
      
        method: 'POST',
        headers: {
            'Content-type': 'application/json',     
        },
        body: data  
      })
      .then((res) => res.json())
      .then((data) => {
        if (data.code == 201){
          login_status.innerHTML = `
          <div class="alert alert-success" role="alert">
            Success!
          </div>`
          localStorage.setItem("username", data.data.username)
          window.location.replace("./profile.php")
        } 
        if (data.code == 500){
          login_status.innerHTML = `
          <div class="alert alert-danger" role="alert">
            ${data.data.message}
          </div>`
          }
        }
      );
    })         
    
      
  </script>
</html>