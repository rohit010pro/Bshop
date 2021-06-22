const pswdFeildArr = document.querySelectorAll(".input-field.password");

pswdFeildArr.forEach((pswdFeild) => {
    const pswdInput = pswdFeild.querySelector('input[type="password"]');
    const eyeIcon = pswdFeild.querySelector(".eye-icon");

    eyeIcon.onclick = () => {
        if (pswdInput.type == "password") {
            pswdInput.type = "text";
            eyeIcon.className = "fas fa-eye-slash eye-icon";
        } else {
            pswdInput.type = "password"
            eyeIcon.className = "fas fa-eye eye-icon";
        }
    }
});


/* ###  Form  Validation Functions  ### */

function getInputName(inputFeild) {
    // let name = inputFeild.name.charAt(0).toUpperCase() + inputFeild.name.slice(1);
    let name = inputFeild.getAttribute("data-name");
    return name;
}

function checkRequired(inputFeildArr) {
    inputFeildArr.forEach((inputFeild) => {
        if (inputFeild.value.trim() === "") {
            showErrorMsg(inputFeild, getInputName(inputFeild) + " is required");
        }
    });
}

function checkFullName(fullNameFeild, min, max){
    const regex = /^[a-zA-Z\s]{5,20}$/;

    let fullName = fullNameFeild.value.trim();

    let length = fullName.length;
  
    if (length < min)
        showErrorMsg(fullNameFeild, getInputName(fullNameFeild) + " must be atleast " + min + " characters");
    else if (length > max)
        showErrorMsg(fullNameFeild, getInputName(fullNameFeild) + " must be less than " + max + " characters");

    else if (regex.test(fullName) === false) 
        showErrorMsg(fullNameFeild, getInputName(fullNameFeild) + " only contains alphabets and space"); 
    else
        showSuccessMsg(fullNameFeild);
}

function checkEmail(emailFeild) {
    const regex = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

    let email = emailFeild.value.trim();

    if (regex.test(email) === false) showErrorMsg(emailFeild, "Invalid Email");
    else showSuccessMsg(emailFeild);
}

function checkPhone(phoneFeild) {
    let phoneNo = phoneFeild.value.trim();
    if (phoneNo.length !== 10)
       showErrorMsg(phoneFeild, "Invalid Phone number")
}

function checkLength(passwordFeild, min, max) {
    let length = parseInt(passwordFeild.value.trim().length);

    if (length < min)
        showErrorMsg(passwordFeild, getInputName(passwordFeild) + " must be atleast " + min + " characters");
    else if (length > max)
        showErrorMsg(passwordFeild, getInputName(passwordFeild) + " must be less than " + max + " characters");
    else
        showSuccessMsg(passwordFeild);
}


function showSuccessMsg(inputFeild) {
    let parent = inputFeild.parentElement;
    parent.classList.remove("error");
}

function showErrorMsg(inputFeild, msg) {
    let parent = inputFeild.parentElement;
    parent.classList.add("error");
    let small = parent.querySelector("small");
    small.innerText = msg;

    isValid = isValid && false;
}

function actionOnFocus(loginForm, inputArr) {
    inputArr.forEach((field) => {
        field.addEventListener("focus", () => {
            let parent = field.parentElement;
            parent.classList.remove("error");

            if (loginForm.querySelector(".alert"))
                loginForm.querySelector(".alert").style.display = "none";
        });
    });
}