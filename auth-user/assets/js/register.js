const registerForm = document.querySelector("#register-form");
const userName = registerForm.querySelector("input[name='name']");
const email = registerForm.querySelector("input[name='email']");
const phoneNo = registerForm.querySelector("input[name='mobile-no']");
const password = registerForm.querySelector("input[name='password']");
const confirmPassword = registerForm.querySelector("input[name='confirm-password']");

const inputArr = [userName,email,phoneNo,password,confirmPassword];

let isValid;

registerForm.addEventListener("submit", (e) => {
    isValid = true;

    checkLength(password, 8, 20);
    checkLength(confirmPassword, 8, 20);
    checkPswdMatch(password,confirmPassword)
    
    checkFullName(userName, 5, 20);

    checkEmail(email);
    checkPhone(phoneNo);

    checkRequired(inputArr);

    if (isValid === false)
        e.preventDefault();
});

actionOnFocus(registerForm,inputArr);


function checkPswdMatch(password,confirmPassword){
    if(password.value.trim() != confirmPassword.value.trim())
        showErrorMsg(confirmPassword,getInputName(confirmPassword) + " doesn't match")        
}