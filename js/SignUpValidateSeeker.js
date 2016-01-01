function validateSignUp(form) {
    var firstName = form['fName'].value;
    var surname = form['surname'].value;
    var email = form['email'].value;
    var password = form['password'].value;
    var bio = form['bio'].value;
    
    var valid = true;

    if (firstName === "") {
        valid = false;
        form.fName.placeholder = "First Name is required";
        form.fName.style.border = '2px solid #FF0000';
        console.log("validate");
    }
    if (surname === "") {
        valid = false;
        form.surname.placeholder = "Surname is reqiured";
        form.surname.style.border = '2px solid #FF0000';
        console.log("validate");
        
    }
    if (email === "") {
        valid = false;        
        form.email.placeholder = "This field is reqiured";
        form.email.style.border = '2px solid #FF0000';
        console.log("validate");
    }
    if (email !== "" && !/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
        form.email.style.border = '2px solid #FF0000';
        alert("Improper email format. \nFormat: example@domain.com");
        valid = false;
    }
    if (password === "") {
        valid = false;
        form.password.placeholder = "Password is reqiured";
        form.password.style.border = '2px solid #FF0000';
        console.log("validate");
    }
    if (bio === "") {
        valid = false;
        form.bio.placeholder = "This field is reqiured";
        form.bio.style.border = '2px solid #FF0000';
        console.log("validate");
    }
    
    return valid;
}