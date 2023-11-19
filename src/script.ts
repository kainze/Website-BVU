//Pics Modal
let picsCarouselInner = document.getElementById('picsCarouselInner');
let carouselIndicatorsBilder = document.getElementById('carouselIndicatorsBilder');

// ZugaufstellungModal
let zugaufstellungModal = document.getElementById('zugaufstellungModal');
let closeZugaufstellungModal1 = document.getElementById('closeZugaufstellungModal1');
let closeZugaufstellungModal2 = document.getElementById('closeZugaufstellungModal2');
let btnclose = document.getElementById('btnclose');

// Countdown ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
let countDown_days = document.getElementById("days");
let countDown_hours = document.getElementById("hours");
let countDown_minutes = document.getElementById("minutes");
let countDown_seconds = document.getElementById("seconds");
let CountdownDescription = document.getElementById("CountdownDescription");
let CountdownDates = [
    { date: new Date("Jul 10, 2024 08:00:00").getTime(), description: "bis zu den Festwochen"},
    { date: new Date("Sep 09, 2024 19:00:00").getTime(), description: "zum Schafkopfturnier"},
    { date: new Date("Sep 08, 2024 20:00:00").getTime(), description: "zur Verkupplungsparty"},
    { date: new Date("Sep 07, 2024 18:30:00").getTime(), description: "zu Auf A Wort"},
    { date: new Date("Sep 06, 2024 19:00:00").getTime(), description: "zum Bieranstich"},
    { date: new Date("Sep 06, 2024 19:00:00").getTime(), description: "zum Fest"}
];

var countDown_Date = new Date("Sep 05, 2023 18:00:00").getTime();

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

        if(element.date > new Date().getTime()) {
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


// Modal direktlink ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function openModal() {
    // show modal if url has #zugaufstellung in it
    if(window.location.hash == "#zugaufstellung" && zugaufstellungModal != null) {
        zugaufstellungModal.style.display = "block";
        zugaufstellungModal.style.paddingRight = "17px";
        zugaufstellungModal.className="modal fade show";
    }

    if (closeZugaufstellungModal1 != null) {
        closeZugaufstellungModal1.addEventListener('click', (e) => {
            if(zugaufstellungModal != null) {
                zugaufstellungModal.style.display = "none";
                zugaufstellungModal.className="modal fade";
        }
        });
    }
    if (closeZugaufstellungModal2 != null) {
        closeZugaufstellungModal2.addEventListener('click', (e) => {
            if(zugaufstellungModal != null) {
                zugaufstellungModal.style.display = "none";
                zugaufstellungModal.className="modal fade";
        }
        });
    }
}

// load Pics ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
async function openBilder(choosenFilter: string) {

    // show loading screen d-none
    let loadingScreen = document.getElementById("loadingScreen");
    let imagesScreen = document.getElementById("imagesScreen");
    if(loadingScreen != null) {
        loadingScreen.classList.remove("d-none");
    }
    if(imagesScreen != null) {
        imagesScreen.classList.add("d-none");
    }
    

    await document.querySelectorAll(".filterButton").forEach(el => {
        el.classList.remove("active");
    });

    let choosenFilterElement = document.getElementById(choosenFilter);
    if(choosenFilterElement != null) {
        choosenFilterElement.classList.add("active");
    }

    // remove all old pics
    await document.querySelectorAll(".carouselPic").forEach(el => {
        el.remove();
    });

    await document.querySelectorAll(".carouselPicIndicator").forEach(el => {
        el.remove();
    });

    // set first carousel item and Indicator active
    let firstCarouselItem = document.getElementById("firstCarouselItem");
    if(firstCarouselItem != null) {
        firstCarouselItem.classList.add("active");
    }
    let firstCarouselIndicator = document.getElementById("firstCarouselIndicator");
    if (firstCarouselIndicator != null) {
        firstCarouselIndicator.classList.add("active");
    }


    // choose which pics to load
    if (choosenFilter == "bestof") {
        await loadAllPics(true);
    }
    else if (choosenFilter == "alleBilder") {
        await loadAllPics(false);
    }
    else if (choosenFilter == "imVorfeld" || choosenFilter == "bierzeltkabarett" || choosenFilter == "aufaWort" || choosenFilter == "verkupplungsparty" || choosenFilter == "schafkopfturnier" || choosenFilter == "festsonntag") {
        await loadPicsFromFolder(choosenFilter);
    }
    else {
        await loadAllPics(true);
        
    }

    // hide loading screen d-none
    if(loadingScreen != null) {
        loadingScreen.classList.add("d-none");
    }
    if(imagesScreen != null) {
        imagesScreen.classList.remove("d-none");
    }

}

function updateImgCarousel(i: number, picDir: string, pic: string) {

    if(i == 0) {
        let firstImg = document.getElementById("firstImg")
        if (firstImg != null) {
            firstImg.setAttribute("src", picDir);
        }
    }
    else {
        if(picsCarouselInner == null) {
            return;
        }
        if(carouselIndicatorsBilder == null) {
            return;
        }
        let picnumber = i + 1;
        picsCarouselInner.innerHTML = picsCarouselInner.innerHTML + '<div class="carousel-item carouselPic"> <div class="row"> <div class="col-lg-12 text-center" style="padding-bottom: 5px;"> <img src="' + picDir + '" alt="' + pic + '" class="img-fluid" style="max-height: 60vh;" /><p style="margin-bottom: 5vh;">' + picnumber + '</p> </div> </div> </div>';
        carouselIndicatorsBilder.innerHTML = carouselIndicatorsBilder.innerHTML + '<button class="carouselPicIndicator" type="button" data-bs-target="#carouselIndicatorBilder" data-bs-slide-to="' + i + '" aria-label="Bild ' + i +'"></button>';
    }
}

async function loadAllPics(bestof: boolean) {
    var imgList = await getImgListJSON();
    var i = 0;

    imgList.folders.forEach((folder: { id:string, folderDir: string, filenames: any[]; }) => {
        folder.filenames.forEach(pic => {
            if(bestof && pic.includes("DSC")){
                return;
            }
            var picDir = "img/picsByGS/" + folder.folderDir + "/" + pic;
            updateImgCarousel(i, picDir, pic);
            i++;
        });
    });
    let loadedPics = document.getElementById("loadedPics");
    if (loadedPics != null) {
        loadedPics.innerHTML = i.toString();
    }
    
}

async function loadPicsFromFolder(choosenFilter: string) {
    var imgList = await getImgListJSON();
    var i = 0;

    imgList.folders.forEach((folder: { id:string, folderDir: string, filenames: any[]; }) => {
        if(folder.id == choosenFilter) {
            folder.filenames.forEach(pic => {
                var picDir = "img/picsByGS/" + folder.folderDir + "/" + pic;
                updateImgCarousel(i, picDir, pic);
                i++;
            });
        }
        
    });
    let loadedPics = document.getElementById("loadedPics");
    if (loadedPics != null) {
        loadedPics.innerHTML = i.toString();
    }
}


async function getImgListJSON() {
    const response = await fetch("./img/picsByGS/imgList.json");
    const json = await response.json();
    return json;
}


function setBackgroundimage() {
    // set background image on body
    const images = [
        "./../../img/TraegerVerein.jpg",
        "./../../img/background.jpg",
        // Add more image URLs here
    ];
    const randomIndex = Math.floor(Math.random() * images.length);
    const randomImage = images[randomIndex];

    document.body.style.backgroundImage = `url('${randomImage}')`;
}


// init ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
function init() {

    changeCountdown();
    setBackgroundimage();


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
            MapsCard.innerHTML = "<iframe src=https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5385.758301536132!2d12.62573263860528!3d48.167979574388816!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4775dca0a0669d85%3A0xa7984d9e3e37c1ce!2sFreiwillige%20Feuerwehr%20Unterneukirchen!5e1!3m2!1sde!2sde!4v1670450915896!5m2!1sde!2sde width=100% height=100% style=border:0; allowfullscreen= loading=lazy referrerpolicy=no-referrer-when-downgrade></iframe>";
        }
        const contactDiv = document.getElementById("contact") as HTMLElement;
        contactDiv.style.resize = "both";
    }
    openModal();
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
            MapsCard.innerHTML = "<iframe src=https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5385.758301536132!2d12.62573263860528!3d48.167979574388816!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4775dca0a0669d85%3A0xa7984d9e3e37c1ce!2sFreiwillige%20Feuerwehr%20Unterneukirchen!5e1!3m2!1sde!2sde!4v1670450915896!5m2!1sde!2sde width=100% height=100% style=border:0; allowfullscreen= loading=lazy referrerpolicy=no-referrer-when-downgrade></iframe>";
        }
        
    }
}
