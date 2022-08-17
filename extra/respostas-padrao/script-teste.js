const respostas = []

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


//Create
function criaResposta() {//verificar se possivel exclusao logica
    let btn_fechar = document.querySelector('button#fechar_modal')
    let input_titulo = document.querySelector('input#input_titulo')
    let input_conteudo = document.querySelector('textarea#textarea_modal')

    respostas.push({
        id: respostas.length +1,
        titulo: String(input_titulo.value),
        conteudo: String(input_conteudo.value)
    }
    )

    localStorage.setItem('respostas', JSON.stringify(respostas)
    )
    btn_fechar.click()
    exibeRespostas()
}



//console.log(respostasPadrao.resposta.length)

//read
function exibeRespostas() {
    let section = document.getElementById('section')
    const objeto_js = JSON.parse(localStorage.getItem('respostas'))//converte o JSON em objeto javascript de volta
    
    objeto_js.map((resposta) => {//mapeia o objeto javascript e executa a função para cada resposta
    let div = document.createElement('div')
    div.innerHTML=`
            <div class="div_txt">
            <h3 class="meu_h3">${resposta.titulo}</h3>
            <textarea class="minha_textarea" id="${resposta.id}">${resposta.conteudo}
            </textarea>
            <button onclick="copiar('${resposta.id}')">Copiar</button>
            <nav id="nav_resposta">
                        <button>Editar</button>
                        <button>Excluir</button>
                    </nav>
            </div>
    `
    section.appendChild(div)
    })
}

/*

//delete
function deleteResposta (id){
    novaListadeResposta = respostasPadrao.resposta.filter(
        (resposta) => resposta.id !== id
    )

    respostasPadrao.resposta = novaListadeResposta
}



//update
function updateResposta (id, novo_titulo, novo_conteudo){
    antigaResposta = respostasPadrao.resposta.find(
        (resposta) => resposta.id === id
    )
    antigaResposta.titulo = novo_titulo
    antigaResposta.conteudo = novo_conteudo

}

updateResposta(2, 'titulo atualizado', 'conteudo atualizado')
*/