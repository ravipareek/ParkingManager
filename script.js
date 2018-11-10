function getLocation(){
    console.log("Reached");
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        alert("Geolocation is not supported by this browser.");
    }
}

function showPosition(position) {
    document.getElementById('searchBar').value = position.coords.longitude + "," + position.coords.latitude;
    console.log(position.coords.longitude);
    console.log(position.coords.latitude);
}
function validateRegister(form){

    console.log(" " + form.password.value);
    console.log(" " + form["password-repeat"].value);

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
    if (!form.email.value.match(emailRegex)){
        alert("Please enter a valid email");
        return false;
    }

    if (!form.password.value){
        alert("Please enter a password");
        return false;
    }
    if(!form["password-repeat"].value){
        alert("Please re-enter the password");
        return false;
    }
    if (form.password.value !== form["password-repeat"].value){
        alert("Please make sure both passwords match");
        return false;
    }
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