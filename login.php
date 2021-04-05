<!DOCTYPE html>
<html lang="en">
<head>
<?php

  require_once "./auth/init.php";
?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <!-- Personal Stylesheet -->
    <link rel="stylesheet" type="text/css" href="./css/main.css"/>
    <!-- Vue JS -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Axios  -->
    <script src="https://unpkg.com/axios/dist/axios.js"></script> 
    <!-- Google Sign in -->
    <meta name="google-signin-client_id" content="1051698943672-lrutkkrvnsu86ri9gdbe25m2c6hqha43.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script type="text/javascript" src="http://platform.linkedin.com/in.js"></script>
    <title>Login Page</title>
</head>

<body>
  <div class="container" id="login" >
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
    <!-- <button v-on:click="register()">click me</button> -->
    <br>
    <label id="error" class="text-danger"></label>
    <a href="register.php">Don't have an account? Sign up here!</a>
    <div>
    <span class="g-signin2" data-onsuccess="onSignIn"></span>
    <span>
      <a href="<?php echo $linkedin->getAuthUrl() ?>" style="font-size: large;">Sign in with LinkedIn</a>
        <!-- <button href="<?=$linkedin->getAuthUrl()?>" style="background-color: transparent; border: none;"><img src="../img/linkedinbut.png" width="200px" height="40px"></button> -->
    </span>
    </div>
</div>
</body>
  <!-- Bootstrap  -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>  
  <!-- <script src="{{url_for('static', filename='script.js')}}"></script> -->

  <!-- JS Part -->
  <script type="application/javascript">
    function onSignIn(googleUser){
      var id_token = googleUser.getAuthResponse().id_token;

      var url = "http://127.0.0.1:5110/api/google_signin";
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
        console.log(data)
        console.log(data.code)
        if (data.code == 201){
          localStorage.setItem("username", data.data.username)
          window.location.replace("./profile.php")
        }   
      })


    }

    document.getElementById('login_button').addEventListener('click',function(event) { 
      event.preventDefault();
      console.log('LOL')
      name = document.getElementById('username').value
      password = document.getElementById('password').value
      data = JSON.stringify({
        'username': name,
        'password': password
      })
      console.log(name,password,data)
      //change to this URL for KONG --> http://0.0.0.0:8000/api/v1/login
      fetch('http://0.0.0.0:5000/api/login/verification', { 
      
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
          document.getElementById('error').innerHTML = data.data.message
        }
      });
    })         
    
      
  </script>
</html>