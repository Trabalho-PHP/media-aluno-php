let button = document.querySelector("#Cadastrar");
let cadastroaluno = document.querySelector("#cadastroaluno");

cadastroaluno.addEventListener("submit", (event)=>{
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
    }
});