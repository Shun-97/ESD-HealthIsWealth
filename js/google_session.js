function init() {
   gapi.load('auth2', function () {
      /* Ready. Make a call to gapi.auth2.init or some other API */
      var auth2 = gapi.auth2.init({
         client_id: '1051698943672-lrutkkrvnsu86ri9gdbe25m2c6hqha43.apps.googleusercontent.com'

      });
      console.log(auth2)
      auth2.then(function () {
         var isSignedIn = auth2.isSignedIn.get();
         var currentUser = auth2.currentUser.get();
         if (isSignedIn) {
            // User is signed in.
            // Pass currentUser to onSignIn callback.
            console.log('sign')
         } else {
            // User is not signed in.
            // call auth2.attachClickHandler
            // or even better call gapi.signin2.render
            console.log('out')
         }
      });
   });
}



