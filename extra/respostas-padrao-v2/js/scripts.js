//copia a resposta
function copiar(id){
    let txt = document.getElementById(id)
    let data = new Date()
    let hora = data.getHours()
    let saudacao = null

    if(hora >= 8 && hora < 13){
        saudacao = 'Bom dia'

    }
    else{
        saudacao = 'Boa tarde'

    }
    mensagem = txt.textContent
    txt.innerHTML = `${saudacao}, ${mensagem}`
    txt.select()
    document.execCommand('copy')
    alert('COPIADO!')
    location.reload()
}

//valida se as senhas estão iguais
function passValidation(){

    var input_pass = document.getElementById('input_pass')
    var input_confirm_pass = document.getElementById('input_confirm_pass')

    if (input_pass.value !== input_confirm_pass.value){
        alert('As senhas não conferem')
        input_pass.value = ''
        input_confirm_pass.value =''
    }
}

