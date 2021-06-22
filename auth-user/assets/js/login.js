const loginForm = document.querySelector("#login-form");
const emailOrPhone = loginForm.querySelector("input[name='email-or-phone']");
const password = loginForm.querySelector("input[name='password']");

let isValid;
loginForm.addEventListener("submit", (e) => {
    isValid = true;

    checkLength(password, 8, 20);

    if (emailOrPhone.value.trim().length > 0) {
        if (isNaN(emailOrPhone.value.trim())) // if Email entered
            checkEmail(emailOrPhone);
        else
            checkPhone(emailOrPhone);
    }
    checkRequired([emailOrPhone, password]);

    if (isValid === false)
        e.preventDefault();
});

actionOnFocus(loginForm,[emailOrPhone, password]);

