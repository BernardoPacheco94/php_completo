

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




