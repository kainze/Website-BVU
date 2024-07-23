// Countdown ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
let countDown_days = document.getElementById("days");
let countDown_hours = document.getElementById("hours");
let countDown_minutes = document.getElementById("minutes");
let countDown_seconds = document.getElementById("seconds");
let CountdownDescription = document.getElementById("CountdownDescription");
let CountdownDates = [
    { date: new Date("Aug 04, 2024 07:00:00").getTime(), description: "zum Festsonntag", enddate: new Date("Aug 04, 2024 23:00:00").getTime()},
    { date: new Date("Aug 03, 2024 19:00:00").getTime(), description: "zum Festabend", enddate: new Date("Aug 03, 2024 23:00:00").getTime()},
    { date: new Date("Aug 02, 2024 20:00:00").getTime(), description: "zur Almrauschparty", enddate: new Date("Aug 02, 2024 23:00:00").getTime()},
    { date: new Date("Aug 01, 2024 18:00:00").getTime(), description: "zur BVU Brass Night", enddate: new Date("Aug 01, 2024 23:00:00").getTime()},
    { date: new Date("Jul 30, 2024 18:00:00").getTime(), description: "zum Kabarett", enddate: new Date("Jul 30, 2024 23:00:00").getTime()},
    { date: new Date("Jul 28, 2024 10:00:00").getTime(), description: "zum Rasenmäherbulldogrennen", enddate: new Date("Jul 28, 2024 23:00:00").getTime()},
    { date: new Date("Jul 27, 2024 20:00:00").getTime(), description: "zur Burschenparty", enddate: new Date("Jul 27, 2024 23:00:00").getTime()},
    { date: new Date("Jul 26, 2024 19:00:00").getTime(), description: "zum Wein- und Weißbierfest", enddate: new Date("Jul 26, 2024 23:00:00").getTime()},
    { date: new Date("Jul 25, 2024 19:00:00").getTime(), description: "zum Bieranstich", enddate: new Date("Jul 26, 2024 23:00:00").getTime()},
    { date: new Date("Jul 25, 2024 18:00:00").getTime(), description: "zum Fest", enddate: new Date("Jul 24, 2024 18:00:00").getTime()},
];

var countDown_Date = new Date("Sep 06, 2024 18:00:00").getTime();

function setCountdown() {
    
    var now = new Date().getTime();
    
    var distance = countDown_Date - now;
    
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    if (countDown_days != null) {
        countDown_days.innerHTML = days.toString();
    }

    if (countDown_hours != null) {
        countDown_hours.innerHTML = hours.toString();
    }

    if (countDown_minutes != null) {
        countDown_minutes.innerHTML = minutes.toString();
    }

    if (countDown_seconds != null) {
        countDown_seconds.innerHTML = seconds.toString();
    }

    return;
}

function changeCountdown() {

    CountdownDates.forEach(element => {
        if(CountdownDescription == null) {
            console.warn("Cannot find CountdownDescription");
            return;
        }

        if(element.enddate > new Date().getTime()) {
            countDown_Date = element.date;
            CountdownDescription.innerText = element.description;
        }
    });
}


setInterval(function() { 
    // alle 3 Sekunden ausführen wenn Datum in der Zukunft liegt
    if(CountdownDates[0].date > new Date().getTime()) {
        setCountdown();
    }
}, 1000);

// function setBackgroundimage() {
//     // set background image on body
//     const switchElement = document.getElementById("flexSwitchCheckBackground") as HTMLInputElement;
//     if (switchElement != null && switchElement.checked) {
//         document.body.style.backgroundImage = `url('img/background.jpg')`;
//     } else {
//         document.body.style.backgroundImage = `url('img/TraegerVerein.jpg')`;
//     }
// }

// init ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function init() {

    changeCountdown();

    var cookie = document.cookie;
    if (cookie.includes("InstaAccepted=true")) {
        const InstaCard = document.getElementById("InstaCard") as HTMLElement;
        let InstaCardWidth = 400;
        let InstaCardHeight = 400;
        if (InstaCard != null) {
            InstaCard.innerHTML = "<iframe src=https://www.instagram.com/p/CljUVq_ql4G/embed height=420 frameborder=0 scrolling=no allowtransparency=true id=InstaFrame></iframe>";
            InstaCardWidth = InstaCard.clientWidth * 0.9;
            InstaCardHeight = InstaCard.clientWidth * 1.15;
        }
        const InstaFrame = document.getElementById("InstaFrame") as HTMLElement;
        if (InstaFrame != null) {
            InstaFrame.style.width = InstaCardWidth.toString() + "px";
            InstaFrame.style.height = InstaCardHeight.toString() + "px";
            InstaFrame.style.minHeight = "380px";
            InstaFrame.style.maxHeight = "640px";
        }
    }
    if (cookie.includes("MapsAccepted=true")) {
        const MapsCard = document.getElementById("MapsCard") as HTMLElement;
        if (MapsCard != null) {
            MapsCard.innerHTML = "<iframe src=https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2660.7639018928717!2d12.626980776832259!3d48.1726314487195!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4775db0050764fd7%3A0xbfc3eef7f1785f77!2sBurschengaufest%202024!5e0!3m2!1sde!2sde!4v1721730208950!5m2!1sde!2sde width=100% height=100% style=border:0; allowfullscreen= loading=lazy referrerpolicy=no-referrer-when-downgrade></iframe>";
            MapsCard.setAttribute("style", MapsCard.getAttribute('style') + "min-height: 50vh;");
        }
        const contactDiv = document.getElementById("contact") as HTMLElement;
        contactDiv.style.resize = "both";
    }
}
  
init();

// load Insta/Maps ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function LoadInstaCard() {
    const SwitchInstaCard = document.getElementById("flexSwitchCheckInsta") as HTMLInputElement;
    if(SwitchInstaCard.checked) {

        // Cookie Setzen
        var now = new Date();
        var expireDate = new Date(now.getTime() + (1000 * 60 * 60 * 24 * 365));
        document.cookie = "InstaAccepted" + "=" + "true" + "; expires=" + expireDate.toString() + "; SameSite=Strict;";
        const InstaCard = document.getElementById("InstaCard") as HTMLElement;
        let InstaCardWidth = 400;
        let InstaCardHeight = 400;
        if (InstaCard != null) {
            InstaCard.innerHTML = "<iframe src=https://www.instagram.com/p/CljUVq_ql4G/embed height=420 frameborder=0 scrolling=no allowtransparency=true id=InstaFrame></iframe>";
            InstaCardWidth = InstaCard.clientWidth * 0.9;
            InstaCardHeight = InstaCard.clientWidth * 1.15;
        }
        const InstaFrame = document.getElementById("InstaFrame") as HTMLElement;
        if (InstaFrame != null) {
            InstaFrame.style.width = InstaCardWidth.toString() + "px";
            InstaFrame.style.height = InstaCardHeight.toString() + "px";
            InstaFrame.style.minHeight = "380px";
            InstaFrame.style.maxHeight = "640px";
        }   
    }
}

function LoadMapsCard() {
    const SwitchMapsCard = document.getElementById("flexSwitchCheckMaps") as HTMLInputElement;
    if(SwitchMapsCard.checked) {

        // Cookie Setzen
        var now = new Date();
        var expireDate = new Date(now.getTime() + (1000 * 60 * 60 * 24 * 365));
        document.cookie = "MapsAccepted" + "=" + "true" + "; expires=" + expireDate.toString() + "; SameSite=Strict;";
        
        // Karte laden
        const MapsCard = document.getElementById("MapsCard") as HTMLElement;
        if (MapsCard != null) {
            MapsCard.innerHTML = "<iframe src=https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2660.7639018928717!2d12.626980776832259!3d48.1726314487195!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4775db0050764fd7%3A0xbfc3eef7f1785f77!2sBurschengaufest%202024!5e0!3m2!1sde!2sde!4v1721730208950!5m2!1sde!2sde width=100% height=100% style=border:0; allowfullscreen= loading=lazy referrerpolicy=no-referrer-when-downgrade></iframe>";
            MapsCard.setAttribute("style", MapsCard.getAttribute('style') + "min-height: 50vh;");
        }
        
    }
}
