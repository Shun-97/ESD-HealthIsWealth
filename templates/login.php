<!DOCTYPE html>
<html lang="en">
<head>
<?php
  require_once "../auth/init.php";
?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!--Fontawesome CDN-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <!-- Personal Stylesheet -->
    <link rel="stylesheet" type="text/css" href="{{ url_for('static', filename='main.css')}}" />
    <!-- Vue JS -->
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Axios  -->
    <script src="https://unpkg.com/axios/dist/axios.js"></script> 
    <!-- Google Sign in -->
    <meta name="google-signin-client_id" content="267437506767-tr4fko9v6lelbaqaeh1v32b2uo6eahkt.apps.googleusercontent.com">
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
          <input type="username" class="form-control" id="username" v-model="username" name="username">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" v-model="password" name="password">
        </div>
        <br>
        <button class="btn btn-primary">Login</button>
        <!-- <button class="btn btn-primary" v-on:click="validatePassword()">Login</button> -->
    </form>
    <!-- <button v-on:click="register()">click me</button> -->
    <br>
    <label id="error" class="text-danger">{{error}}</label>
    <a href="/register">Don't have an account? Sign up here!</a>
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
      console.log(JSON.stringify(googleUser.getBasicProfile()))
      var profile = googleUser.getBasicProfile();
      console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
      console.log('Name: ' + profile.getName());
      console.log('Image URL: ' + profile.getImageUrl());
      console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
      // The ID token you need to pass to your backend:
      var id_token = googleUser.getAuthResponse().id_token;
      console.log("ID Token: " + id_token);

      var username = profile.getName()
      var password = profile.getId()
      var email = profile.getEmail()
      
      //Send the data to login
      var url = "http://localhost:5000/login";
      const data = JSON.stringify({
        username: username,
        password: password,
      });
      fetch(url,{
        method: "POST",
        headers:{"Content-type": "application/json"},
        body: data
      })
      .then(response => response.json())
      //grab the returned response
      .then(data => {
        console.log(data)
        console.log(data.code)
        if (data.code == 201){
          window.location.replace("http://localhost:5000/profile")
        }   
      })


    }
    // var vm = new Vue({
    //   el: "#login",
    //   data: {
    //     username: '',
    //     password: ''
    //   },
      // methods: {
      //   validatePassword(){
      //     axios.get('https://esd-healthiswell-69.hasura.app/api/rest/registration/'+this.username.toLowerCase(), {
      //     headers: {
      //       'Content-Type': 'application/json',
      //       'x-hasura-admin-secret': 'Qbbq4TMG6uh8HPqe8pGd1MQZky85mRsw5za5RNNREreufUbTHTSYgaTUquaKtQuk',
      //       }
      //     }).then((response)=>{
      //       console.log(response);
      //       var data = response.data.Registration
      //       if (data){
      //         var actualPassword = data[0].Password
      //         if (this.password == actualPassword){
      //           console.log("true")
      //           window.location.replace("/profile")
      //           return true;
      //         }
      //         else{
      //           console.log("false")
      //           return false;
      //         }
      //       }
      //     }).catch((error)=>{
      //       console.log(error);
      //     })
      //   }
      // }
    // })
  </script>
</html>