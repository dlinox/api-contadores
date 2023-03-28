const emailValid = (required = true) => ({
    type: "email",
    required: required,
    message: "Correo no valido",
    trigger: ["input", "blur"],
});

const onlyAllowNumber = (value) => !value || /^\d+$/.test(value);


export {emailValid, onlyAllowNumber }