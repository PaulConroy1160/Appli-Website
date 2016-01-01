function validateLogin(form) {
    var email = form['email'].value;
    var password = form['password'].value;
    
    var valid = true;

    if (email === "") {
        valid = false;
        form.email.placeholder = "Email is required";
        form.email.style.border = '1px solid #FF0000';
        console.log("validate");
    }
    if (password === "") {
        valid = false;
        form.password.placeholder = "Password is reqiured";
        form.password.style.border = '1px solid #FF0000';
        console.log("validate");
        
    }
      return valid;
}