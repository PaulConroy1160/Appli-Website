function validateJobPost(form) {
    var jobTitle = form['title'].value;
    var company = form['company'].value;
    var remunPackage = form['rPackage'].value;
    var jobSummary = form['summary'].value;
    var experience = form['experience'].value;
    var responsibilities = form['responsibilities'].value;
    var location = form['location'].value;
    var contractType = form['contract'].value;

    var valid = true;

    if(jobTitle === "") {
        valid = false;
        form.title.placeholder = "Job Title is required";
        form.title.style.border = '2px solid #FF0000';
        console.log("validate");
    }
	if(company === "") {
        valid = false;
        form.company.placeholder = "";
        form.company.style.border = '2px solid #FF0000';
        console.log("validate");
    }
    if (remunPackage === "") {
        valid = false;
        form.rPackage.placeholder = "Salary and Benefit information is required";
        form.rPackage.style.border = '2px solid #FF0000';
        console.log("validate");
    }
    if (jobSummary === "") {
        valid = false;        
        form.summary.placeholder = "A Job Summary is required";
        form.summary.style.border = '2px solid #FF0000';
        console.log("validate");
    }
    if (experience === "") {
        valid = false;
        form.experience.placeholder = "Experience information is required";
        form.experience.style.border = '2px solid #FF0000';
        console.log("validate");
    }
    if (responsibilities === "") {
        valid = false;
        form.responsibilities.placeholder = "Responsibilities are required";
        form.responsibilities.style.border = '2px solid #FF0000';
        console.log("validate");
    }
    if (location === "") {
        valid = false;        
        form.location.placeholder = "Location information is required";
        form.location.style.border = '2px solid #FF0000';
        console.log("validate");
    }
    if (contractType === "") {
        valid = false;
        form.contractType.placeholder = "Contract type is required";
        form.contractType.style.border = '2px solid #FF0000';
        console.log("validate");
    }
    
    return valid;
}