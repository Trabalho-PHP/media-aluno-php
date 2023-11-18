let input_nome = document.querySelector("#nome");
let input_email = document.querySelector("#email");
let input_senha = document.querySelector("#senha");
let form_data = document.querySelector("#userData");

let emailRegex = /\S+@\S+\.\S+/;

userData.addEventListener("submit", (event)=>{
    if(validar_valor_vazio(input_nome, "Informe um nome!", event)){
        return;
    }else if(validar_valor_vazio(input_email, "Informe um e-mail!", event)){
        return;
    }else if(validar_valor_vazio(input_senha, "Informe uma senha!", event)){
        return;
    }else if(!emailRegex.test(input_email.value)){
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "Informe um email válido"
        })
          event.preventDefault();
    }else if(isNaN(input_nota1.value)){
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "Informe um número válido"
        })
        event.preventDefault();
    }
});

function validar_valor_vazio(element, message, event){
    if(element.value.trim() == ""){
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: message,
          })
          event.preventDefault();
          return true;
    }
    return false;
}
