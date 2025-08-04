// Countdown ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
let countDown_days = document.getElementById("days");
let countDown_hours = document.getElementById("hours");
let countDown_minutes = document.getElementById("minutes");
let countDown_seconds = document.getElementById("seconds");
let CountdownDescription = document.getElementById("CountdownDescription");
let CountdownDates = [
    { date: new Date("Aug 23, 2025 20:00:00").getTime(), description: "Burschenparty", enddate: new Date("Aug 23, 2025 23:30:00").getTime()},
    { date: new Date("Aug 22, 2025 19:30:00").getTime(), description: "Wein-und Weißbierfest", enddate: new Date("Aug 22, 2025 23:30:00").getTime()},
    { date: new Date("Apr 18, 2025 11:00:00").getTime(), description: "Steckalfischgrillen", enddate: new Date("Apr 18, 2025 14:00:00").getTime()},
    { date: new Date("Aug 04, 2024 07:00:00").getTime(), description: "zum Festsonntag", enddate: new Date("Aug 04, 2024 23:00:00").getTime()},
    { date: new Date("Aug 03, 2024 19:00:00").getTime(), description: "zum Festabend", enddate: new Date("Aug 03, 2024 23:00:00").getTime()},
    { date: new Date("Aug 02, 2024 20:00:00").getTime(), description: "zur Almrauschparty", enddate: new Date("Aug 02, 2024 23:00:00").getTime()},
    { date: new Date("Aug 01, 2024 18:00:00").getTime(), description: "zur BVU Brass Night", enddate: new Date("Aug 01, 2024 23:00:00").getTime()},
    { date: new Date("Jul 30, 2024 18:00:00").getTime(), description: "zum Kabarett", enddate: new Date("Jul 30, 2024 23:00:00").getTime()},
    { date: new Date("Jul 28, 2024 10:00:00").getTime(), description: "zum Rasenmäherbulldogrennen", enddate: new Date("Jul 28, 2024 23:00:00").getTime()},
    { date: new Date("Jul 27, 2024 20:00:00").getTime(), description: "zur Burschenparty", enddate: new Date("Jul 27, 2024 23:00:00").getTime()},
    { date: new Date("Jul 26, 2024 19:00:00").getTime(), description: "zum Wein- und Weißbierfest", enddate: new Date("Jul 26, 2024 23:00:00").getTime()},
    { date: new Date("Jul 25, 2024 19:00:00").getTime(), description: "zum Bieranstich", enddate: new Date("Jul 25, 2024 23:00:00").getTime()},
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

    if (days < 0) days = 0;
    if (hours < 0) hours = 0;
    if (minutes < 0) minutes = 0;
    if (seconds < 0) seconds = 0;

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

// init ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function init() {
    changeCountdown();

    var cookie = document.cookie;
    if (cookie.includes("InstaAccepted=true")) {
        const SwitchInstaCard = document.getElementById("flexSwitchCheckInsta") as HTMLInputElement;
        if(SwitchInstaCard) {
            SwitchInstaCard.checked = true;
            LoadInstaCard();
        }
    }

    if (cookie.includes("MapsAccepted=true")) {
        const SwitchMapsCard = document.getElementById("flexSwitchCheckMaps") as HTMLInputElement;
        if(SwitchMapsCard) {
            SwitchMapsCard.checked = true;
            LoadMapsCard();
        }
    }
    
    const email = "bvunterneukirchen@gmx.de";
    const emailLink = document.getElementById("email-link");

    if (emailLink) {
        emailLink.innerHTML = `<a class="text-warning" href="mailto:${email}" style="text-decoration: none;">
            ${email}
        </a>`;
    }

    if (cookie.includes("CalendarAccepted=true")) {
        const SwitchCalendarCard = document.getElementById("flexSwitchCheckCalendar") as HTMLInputElement;
        if(SwitchCalendarCard) {
            SwitchCalendarCard.checked = true;
            LoadCalendarCard();
        }
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
        if (InstaCard != null) {
            InstaCard.innerHTML ="<blockquote class='instagram-media' data-instgrm-captioned data-instgrm-permalink='https://www.instagram.com/p/DHZIVyyKr6D/?utm_source=ig_embed&amp;utm_campaign=loading' data-instgrm-version='14' style=' background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:540px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);'><div style='padding:16px;'> <a href='https://www.instagram.com/p/DHZIVyyKr6D/?utm_source=ig_embed&amp;utm_campaign=loading' style=' background:#FFFFFF; line-height:0; padding:0 0; text-align:center; text-decoration:none; width:100%;' target='_blank'> <div style=' display: flex; flex-direction: row; align-items: center;'> <div style='background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;'></div> <div style='display: flex; flex-direction: column; flex-grow: 1; justify-content: center;'> <div style=' background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;'></div> <div style=' background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;'></div></div></div><div style='padding: 19% 0;'></div> <div style='display:block; height:50px; margin:0 auto 12px; width:50px;'><svg width='50px' height='50px' viewBox='0 0 60 60' version='1.1' xmlns='https://www.w3.org/2000/svg' xmlns:xlink='https://www.w3.org/1999/xlink'><g stroke='none' stroke-width='1' fill='none' fill-rule='evenodd'><g transform='translate(-511.000000, -20.000000)' fill='#000000'><g><path d='M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631'></path></g></g></g></svg></div><div style='padding-top: 8px;'> <div style=' color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;'>Sieh dir diesen Beitrag auf Instagram an</div></div><div style='padding: 12.5% 0;'></div> <div style='display: flex; flex-direction: row; margin-bottom: 14px; align-items: center;'><div> <div style='background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(0px) translateY(7px);'></div> <div style='background-color: #F4F4F4; height: 12.5px; transform: rotate(-45deg) translateX(3px) translateY(1px); width: 12.5px; flex-grow: 0; margin-right: 14px; margin-left: 2px;'></div> <div style='background-color: #F4F4F4; border-radius: 50%; height: 12.5px; width: 12.5px; transform: translateX(9px) translateY(-18px);'></div></div><div style='margin-left: 8px;'> <div style=' background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 20px; width: 20px;'></div> <div style=' width: 0; height: 0; border-top: 2px solid transparent; border-left: 6px solid #f4f4f4; border-bottom: 2px solid transparent; transform: translateX(16px) translateY(-4px) rotate(30deg)'></div></div><div style='margin-left: auto;'> <div style=' width: 0px; border-top: 8px solid #F4F4F4; border-right: 8px solid transparent; transform: translateY(16px);'></div> <div style=' background-color: #F4F4F4; flex-grow: 0; height: 12px; width: 16px; transform: translateY(-4px);'></div> <div style=' width: 0; height: 0; border-top: 8px solid #F4F4F4; border-left: 8px solid transparent; transform: translateY(-4px) translateX(8px);'></div></div></div> <div style='display: flex; flex-direction: column; flex-grow: 1; justify-content: center; margin-bottom: 24px;'> <div style=' background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 224px;'></div> <div style=' background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 144px;'></div></div></a><p style=' color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;'><a href='https://www.instagram.com/p/DHZIVyyKr6D/?utm_source=ig_embed&amp;utm_campaign=loading' style=' color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none;' target='_blank'>Ein Beitrag geteilt von Burschenverein Unterneukirchen (@burschenverein_unterneukirchen)</a></p></div></blockquote>";
        }

        // Dynamisch Instagram-Skript einfügen
        const existingScript = document.querySelector<HTMLScriptElement>(
            'script[src="//www.instagram.com/embed.js"]'
        );

        if (!existingScript) {
            const script = document.createElement("script");
            script.src = "//www.instagram.com/embed.js";
            script.async = true;
            document.body.appendChild(script);
        } else {
            // Falls Script schon geladen ist, Instagram-Embeds neu parsen
            // @ts-ignore
            if (window.instgrm && window.instgrm.Embeds) {
                // @ts-ignore
                window.instgrm.Embeds.process();
            }
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

function LoadCalendarCard() {
    const SwitchCalendarCard = document.getElementById("flexSwitchCheckCalendar") as HTMLInputElement;
    if(SwitchCalendarCard.checked) {

        // Cookie Setzen
        var now = new Date();
        var expireDate = new Date(now.getTime() + (1000 * 60 * 60 * 24 * 365));
        document.cookie = "CalendarAccepted" + "=" + "true" + "; expires=" + expireDate.toString() + "; SameSite=Strict;";
        
        // Karte laden
        const CalendarCard = document.getElementById("CalendarCard") as HTMLElement;
        if (CalendarCard != null) {
            CalendarCard.innerHTML = "<hr class='text-light-grey'> <iframe src='https://calendar.google.com/calendar/embed?height=600&wkst=1&ctz=Europe%2FBerlin&showPrint=0&showTz=0&showCalendars=0&title&showTitle=0&src=NGIxZGY0OWY3NDlkMTVkN2EyZTg4N2QzOGU5OTkyMThkMjE5MzNkM2VjZTFiNDI5MjA0MzM4Nzk1M2JiZTRmMkBncm91cC5jYWxlbmRhci5nb29nbGUuY29t&color=%230b8043'style='border-width:0' width='100%' height='600' frameborder='0' scrolling='no'></iframe></div>";
            CalendarCard.setAttribute("style", CalendarCard.getAttribute('style') + "min-height: 50vh;");
        }
    }
}

function copyICSLink() {
    const link = "webcal://calendar.google.com/calendar/ical/4b1df49f749d15d7a2e887d38e999218d21933d3ece1b4292043387953bbe4f2%40group.calendar.google.com/public/basic.ics";
    navigator.clipboard.writeText(link).then(() => {
        const toastElement = document.getElementById('copyToast');
        // @ts-ignore
        const toast = new window.bootstrap.Toast(toastElement);
        toast.show();
    });
  }