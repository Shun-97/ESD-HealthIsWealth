document.addEventListener("DOMContentLoaded", function () {
// append team members
    const team_members = {
        edena: "edena.jpg",
        ck: "ck.jpeg",
        yc: "yc.png",
        sh: "sh1.jpg",
        py: "py.jpg"
    };
    for (const key of Object.keys(team_members)) {
        var el = document.getElementById("meetteam");
        el.innerHTML += "<img class='team_img' src='images/" + team_members[key] + "'/>";
        // console.log(team_members[key]);
    }

// add animation when user scroll to the segment
inView("#landing")
.on('enter', function () {
    document.getElementsByClassName("wrapper")[1].classList.add("animate__bounceInUp", "animate__animated");
});
inView("#about")
.on('enter', function () {
    document.getElementsByClassName("wrapper")[0].classList.add("animate__fadeInLeft", "animate__animated");
    document.getElementsByClassName("wrapper")[1].classList.add("animate__lightSpeedInLeft", "animate__animated");
    document.getElementsByClassName("wrapper")[2].classList.add("animate__fadeInBottomRight", "animate__animated");
    document.getElementsByClassName("wrapper")[3].classList.add("animate__rollIn", "animate__animated");

});
inView("#action")
.on('enter', function () {
    document.getElementsByClassName("btn-light")[0].classList.add("animate__flipInY", "animate__animated");
});
inView("#abt-us")
.on('enter', function () {
    document.getElementsByClassName("border-left")[0].classList.add("animate__fadeInLeft", "animate__animated");
    document.getElementsByClassName("border-right")[0].classList.add("animate__fadeInRight", "animate__animated");
});

});





$(function () {
    $(window).on('scroll', function () {
        if ($(window).scrollTop() > 500) {
            $('.navbar').addClass('active');
            $('.navbar').css("background-color","#030305a8");
        } else {
            $('.navbar').removeClass('active');
            $('.navbar').css("background-color","");
        }
    });

    // add animation when user clicks on navbar
    $('.navbar a').on('click', function (e) {
        if (this.hash !== '') {
            e.preventDefault();

            const hash = this.hash;


            $('html, body')
                .animate({
                    scrollTop: $(hash).offset().top
                }, 1000);
        }
    });
});
