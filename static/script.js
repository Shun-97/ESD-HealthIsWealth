setInterval(setClock, 1000)
setInterval(showTime, 1000)

const hourHand = document.getElementById('hour-hand');

const minHand = document.getElementById('min-hand');

const secHand = document.getElementById('sec-hand');

function setClock(){
    const currentDate = new Date();
    const seconds = currentDate.getSeconds() / 60;
    const minutes = (seconds + currentDate.getMinutes()) / 60;
    const hours = (minutes + currentDate.getHours()) / 12;
    setRotation(secHand, seconds);
    setRotation(minHand, minutes);
    setRotation(hourHand, hours);
}

function setRotation(hand,time){
    hand.style.setProperty('--rotation',time * 360);
}

function showTime(){
    const currentDate = new Date();
    var h = currentDate.getHours();
    var m = currentDate.getMinutes();
    var s = currentDate.getSeconds();
    var month = currentDate.getMonth();
    var year = currentDate.getFullYear();
    var date = currentDate.getDate();
    var day = currentDate.getDay();

    month_dic = {
        0 : "January",
        1 : "February",
        2 : "March",
        3 : "April",
        4 : "May",
        5 : "June",
        6 : "July",
        7 : "August",
        8 : "September",
        9 : "October",
        10 : "November",
        11 : "December"
    }
    day_dic = {
        1 : "Mo",
        2 : "Tu",
        3 : "We",
        4 : "Th",
        5 : "Fr",
        6 : "Sa",
        7 : "Su",
    }
    month = month_dic[month];
    week = document.getElementsByClassName("weekdays")[0].getElementsByTagName("li");
    for(weekday of week){
        if(day_dic[day] == weekday.innerText){
            weekday.setAttribute("class","active");
        }
    }
    dayofmonth = document.getElementsByClassName("days")[0].getElementsByTagName("li");
    for(theday of dayofmonth){
        if(theday.innerText == date){
            theday.setAttribute("class","active")
        }
    }
    if(h < 10){
        h = "0" + h
    } 
    if(m < 10){
        m = "0" + m
    } 
    if(s < 10){
        s = "0" + s
    } 

    const time = h + ":" + m + ":" + s;
    document.getElementById("time").innerText = time;
    // document.getElementById("time").textContent = time; 
    document.getElementById("year").innerText = year;
    document.getElementById("month").innerText = month;
    
}

setClock();
showTime();