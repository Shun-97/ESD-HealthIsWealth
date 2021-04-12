document.addEventListener("DOMContentLoaded", function () {
   loadHeader();

   // Toggle between showing and hiding the sidebar when clicking the menu icon
   var mySidebar = document.getElementById("mySidebar");
});

load_script();

function load_script() { //specify commonly used JS and CSS here. Generates for every page.
   var js_scripts = [
      //Bootstrap JS
      "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js",
      //Vue JS
      "https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js",
      //fontawesome
      "https://kit.fontawesome.com/a076d05399.js",
      "https://unpkg.com/axios/dist/axios.js",
      "https://code.jquery.com/jquery-3.3.1.slim.min.js",
      "https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"

   ];

   var css_scripts = [
      "https://www.w3schools.com/w3css/4/w3.css",
      "https://fonts.googleapis.com/css?family=Raleway",
      "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css",
      //Bootstrap css
      // "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css",
      // "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css",
      "https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css",
      //
      "https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css",
      "https://use.fontawesome.com/releases/v5.15.3/css/all.css"

   ];

   js_scripts.forEach(function (filename) {
      var fileref = document.createElement('script');
      fileref.setAttribute("type", "text/javascript");
      fileref.setAttribute("src", filename);
      document.getElementsByTagName("head")[0].appendChild(fileref);
   });

   css_scripts.forEach(function (filename) {
      var fileref = document.createElement("link");
      fileref.setAttribute("rel", "stylesheet");
      fileref.setAttribute("type", "text/css");
      fileref.setAttribute("href", filename);
      document.getElementsByTagName("head")[0].appendChild(fileref);
   });
}

function w3_open() {
   if (mySidebar.style.display === 'block') {
      mySidebar.style.display = 'none';
   } else {
      mySidebar.style.display = 'block';
   }
}

// Close the sidebar with the close button
function w3_close() {
   mySidebar.style.display = "none";
}

// Modal Image Gallery
function onClick(element) {
   document.getElementById("img01").src = element.src;
   document.getElementById("modal01").style.display = "block";
   var captionText = document.getElementById("caption");
   captionText.innerHTML = element.alt;
}

$(window).scroll(function () {
   if ($(document).scrollTop() > 50) {
      $('.nav').addClass('affix');
      // console.log("OK");
   } else {
      $('.nav').removeClass('affix');
   }
});

function loadHeader() { //init header for every page. do not hardcode headers!!!!!
   var first_element_of_page = document.getElementsByTagName("body")[0];
   var header = document.createElement("nav");

   header.innerHTML = `
   <div class="w3-top">
      <div class="w3-bar w3-white w3-card" id="myNavbar">
         <a href="index.php" class="w3-bar-item w3-button w3-wide"><img src='./img/earthchan.png' height="48px"
                    width="48px">Health is Wealth</a>
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
   </nav>`

   first_element_of_page.prepend(header);
}