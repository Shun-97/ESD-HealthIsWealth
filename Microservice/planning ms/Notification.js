document.addEventListener("DOMContentLoaded", function () {
    var output = `<button class="btn btn-danger" id='RemindMe'> Set my reminder! </button>`;
    user = document.getElementById("isUser").innerText;
    if (user == "Guest") {
        output = `<button class="btn btn-warning" data-toggle="modal" data-target="#LoginRegisterModal"> Not a User? Please Login to use this function </button>
       <div class='modal fade' id='NotUser' tabindex='-1' role='dialog' aria-labelledby='NotUsez' aria-hidden='true'>
       <div class='modal-dialog modal-dialog-centered' role='document'><div class='modal-content'>
           <div class='row'><div class='col-xs-12 popup-background'>
               <div class='popup-login p-5 m-auto bg-secondary'>
                   <button type='button' class='close btn-outline-danger ' data-dismiss='modal' aria-label='Close'>
                       <span aria-hidden='true'>&times;</span>
                       </button>
                   <a href='login.php' class='btn btn-primary'>Log In</button></a>
                   <a href='registration.php' class='btn btn-success'>Register</button></a>
                   </div>
               </div>
           </div>
       </div>`;
        document.getElementById("checkUser").innerHTML = output;
    } else {
        document.getElementById("iamUser").innerHTML = output;
    }
    if (document.getElementById("isUser").innerText != "Guest") {
        requestNotification();
        let SetAlert = document.getElementById('RemindMe');
        SetAlert.addEventListener('click', function (event) {
            event.preventDefault();

            var Departing = document.getElementById('Time').value;
            var Location = document.getElementById('place').value;
            var Prep_Time = Number(document.getElementById('prep').value);

            var date = new Date()
            // if the timing set is earlier than current time
            if (date.getHours() > Departing.split(':')[0]) {
                alert('Do not set a timing earlier than your current time');
                location.reload();
            } else {
                let hours_in_mili = (Number(Departing.split(':')[0]) - date.getHours()) * 3600000;
                let min_in_mili = (Number(Departing.split(':')[1]) - date.getMinutes()) * 60000;
                let timeout = hours_in_mili + min_in_mili - (Prep_Time * 60000);
                // setting the timer
                setTimeout(() => {
                    notifcation = new Notification('Start Preping!!')
                }, timeout);
                // alert('Timer Set')

                //set values for the bot
                let uniqueId = Math.floor(Math.random() * 10000000)
                var database_date = new Date();
                database_date.setHours(Departing.split(':')[0])
                database_date.setMinutes(Departing.split(':')[1])

                //minus preparation time
                database_date.setMinutes(database_date.getMinutes() - Prep_Time)


                let date_output = `${database_date.getFullYear()}-${database_date.getMonth() + 1}-${database_date.getDate()} ${database_date.getHours()}:${database_date.getMinutes()}:${database_date.getSeconds()}`


                // console.log(date_output)
                //send data to the database
                jsondata = {
                    'ID': uniqueId,
                    'username': user,
                    'location': Location,
                    'time': date_output
                }

                database_post(jsondata)

                document.getElementById('reminder_output').innerHTML = `<h3>Thank you for using the schedule service, please go to our telebot (@Parkwhere_Bot) and key in ${uniqueId}</h3>`
            }
        });
    }
});


function requestNotification() {
    // asking for permission for notification
    Notification.requestPermission(permission => {
        if (permission === 'granted') {
            console.log('granted')
        } else {
            alert('Notification not allowed! Please refresh ')
        }
    })
}

$(function () {
    $(window).on('scroll', function () {
        if ($(window).scrollTop() > 10) {
            $('.navbar').addClass('active');
        } else {
            $('.navbar').removeClass('active');
        }
    });
});


function database_post(jsondata) {
    const web = new XMLHttpRequest();
    let data = JSON.stringify(jsondata)
    web.onreadystatechange = function () {
        if (web.readyState == 4 && web.status == 200) {
            // console.log(JSON.parse(this.responseText))
            console.log(this.responseText)
            // console.log(jsondata);
        }

    };
    web.open('POST', "php/Schedule_Database.php", false);
    web.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    web.send('query=' + data);
    return jsondata;

}