//Show marker with slider
function modifyOffset(slider) {
    let newPoint, newPlace, offset, width;
    width    = slider.offsetWidth;
    //calculate new position
    newPoint = (slider.value - slider.min)/ (slider.max - slider.min);
    offset   = 0;
    // edge detection
    if (newPoint < 0) { newPlace = 0;}
    else if (newPoint > 1) { newPlace = width; }
    else {
        newPlace = width * newPoint;
        offset = 1+(1-newPoint)*2;
    }
    //set position
    let outputTag = document.getElementById("distance");
    outputTag.style.left       = newPlace + "px";
    outputTag.style.marginLeft = offset + "%";
    outputTag.innerHTML        = slider.value;
}

//from W3Schools
function getLocation(){
    //access location
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

//from W3Schools
//set position in text field
function showPosition(position) {
    document.getElementById('searchBar').value = position.coords.longitude + "," + position.coords.latitude;
}

function validateSubmit(form){
    //Check if user has entered a name
    if(!form.name.value){
        alert("Please enter a name");
        return false;
    }
    //check if user entered an email
    if (!form.description.value){
        alert("Please enter an email");
        return false;
    }
    //check if longitude within range
    if(form.lon.value > 180 || form.lon.value < -180){
        alert("Please enter a valid longitude");
        return false;
    }
    //check if latitude within range
    if(form.lat.value > 90 || form.lat.value< -90){
        alert("Please enter a valid latitude");
        return false;
    }
    //Check if user has selected type of spot
    if(form.type.value === "none"){
        alert("Please enter a valid type");
        return false;
    }
    //Check if user has uploaded image
    if(!form.image.value){
        alert("Please select an image");
        return false;
    }

    return true;
}

function validateSignIn(form) {
    const emailRegex = /^\w+[\w-\.]*\@\w+((-\w+)|(\w*))\.[a-z]{2,3}$/g;
    //check if user entered an email
    if (!form.email.value){
        alert("Please enter an email");
        return false;
    }
    //email matches regex
    if (!form.email.value.match(emailRegex)){
        alert("Please enter a valid email");
        return false;
    }
    //check if user entered an password
    if (!form.password.value){
        alert("Please enter a password");
        return false;
    }

    return true;

}

function validateRegister(form){
    //regular expression for email
    const emailRegex = /^\w+[\w-\.]*\@\w+((-\w+)|(\w*))\.[a-z]{2,3}$/g;

    //Check if user has entered a name
    if(!form.name.value){
        alert("Please enter a name");
        return false;
    }
    //check if user entered an email
    if (!form.email.value){
        alert("Please enter an email");
        return false;
    }
    //email matches regex
    if (!form.email.value.match(emailRegex)){
        alert("Please enter a valid email");
        return false;
    }
    //check if user entered an password
    if (!form.password.value){
        alert("Please enter a password");
        return false;
    }
    //check if user entered an repeat password
    if(!form["password-repeat"].value){
        alert("Please re-enter the password");
        return false;
    }
    //passwords match
    if (form.password.value !== form["password-repeat"].value){
        alert("Please make sure both passwords match");
        return false;
    }
    //at least one option was selected
    let userType = form["user-type"];
    let owner = false;
    let user = false;
    if(userType[0].checked){
        owner = true;
    }
    if (userType[1].checked){
        user = true;
    }
    if (!(user || owner)){
        alert("Please select the type of user");
        return false;
    }
    return true;
}
//global var
let longitude = 0;
let latitude = 0;

function validateSearch(form){
    //get value from search bar
    let location = form.searchBar.value;
    longitude = parseFloat(location.split(",")[0]);
    latitude = parseFloat(location.split(",")[1]);

    // console.log(form.minPrice.value > form.maxPrice.value);
    // console.log(form.minPrice.value);
    // console.log(form.maxPrice.value);

    //check if user entered location
    if (!location){
        alert("Please enter the longitude and latitude values or use the current location");
        return false;
    }
    //check if location has 2 elements separated by comma
    if((location.split(",").length) !== 2){
        alert("Please only enter 2 values");
        return false;
    }
    //check if longitude within range
    if(longitude > 180 || longitude < -180){
        alert("Please enter a valid longitude");
        return false;
    }
    //check if latitude within range
    if(latitude > 90 || latitude < -90){
        alert("Please enter a valid latitude");
        return false;
    }
    //check if minPrice exists or is < 0
    if (!form.minPrice.value || parseFloat(form.minPrice.value)<0){
        alert("Please enter a valid minimum price");
        return false;
    }
    //check if maxPrice exists or is < 0
    if (!form.maxPrice.value || parseFloat(form.maxPrice.value)<0){
        alert("Please enter a valid maximum price");
        return false;
    }
    //check if minPrice is greater than maxPrice
    if (parseFloat(form.minPrice.value) > parseFloat(form.maxPrice.value)){
        alert("Please ensure the max price is greater than the min price");
        return false;
    }
    return true;
}

function makeMap() {
    console.log("Map");

    //hard coding longitude and latitude
    longitude = -79.90806479;
    latitude = 43.2585787;

    //Make map square
    var mapElement = document.getElementById('mapId');
    var mapBounds = mapElement.offsetWidth;
    mapElement.style.height =  (mapBounds * 0.7) + 'px';

    let token = 'sk.eyJ1IjoicGFyZWVraXRlZWtpIiwiYSI6ImNqb2RkazZ4NzEyeXEzcHJ3OXloNnhjdGkifQ.fbyzmtswUJRTNKzrVYwu2g';
    let myMap = L.map('mapId').setView([latitude,longitude], 15);

    //create map
    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 20,
        id: 'mapbox.streets',
        accessToken: token
    }).addTo(myMap);
    // create marker
    var marker = L.marker([43.26,-79.919]).addTo(myMap);
    marker.bindPopup("Lot M parking spot <br> Price: $7 <br> <a href='parking.php'>Details</a>");
    // create marker
    var marker = L.marker([43.257985, -79.913611]).addTo(myMap);
    marker.bindPopup("1150 Hamilon RR 8 <br> Price: $20 <br> <a href='parking.php'>Details</a>");

}


function makeMapIndividual() {
    console.log("Map");

    //hard coding longitude and latitude
    longitude = -79.91922540000002;
    latitude = 43.260879;

    //Make map square
    var mapElement = document.getElementById('mapId');
    var mapBounds = mapElement.offsetWidth;
    mapElement.style.height =  (mapBounds * 0.7) + 'px';

    let token = 'sk.eyJ1IjoicGFyZWVraXRlZWtpIiwiYSI6ImNqb2RkazZ4NzEyeXEzcHJ3OXloNnhjdGkifQ.fbyzmtswUJRTNKzrVYwu2g';
    let myMap = L.map('mapId').setView([latitude,longitude], 16);

    //create map
    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 20,
        id: 'mapbox.streets',
        accessToken: token
    }).addTo(myMap);

    // create marker
    var marker = L.marker([latitude,longitude]).addTo(myMap);
    marker.bindPopup("Lot M parking spot");
}