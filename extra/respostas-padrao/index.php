<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title>Respostas Padrão</title>
</head>


<body class="meu_body">

    <header class="minha_header">
        <img src="logo.png" alt="logo">
        <button type="button" data-toggle="modal" data-target="#modal_cadastrar_resposta">Incluir</button>
        <a href="logout.php"><button type="button">Sair</button></a>
    </header>

    <section id="section" class="minha_section">
        <h1 class="meu_h1">ANOTAÇÕES</h1>

    </section>
    <?php
    session_start();
    require_once "config.php";

    $anotacoes = new Anotacao;
    
    $list = Anotacao::exibeAnotacoes();
    foreach ($list as $key => $value) {
        ?>
        <div class="div_txt text-center">
            <h3 class="meu_h3"><?php echo $value['titulo'] ?></h3>
            <textarea class="minha_textarea" id="${<?php echo $key; ?>}"><?php echo $value['conteudo'] ?></textarea>
            <button onclick="copiar('${<?php echo $key; ?>}')">Copiar</button>
            <nav id="nav_resposta">
                <br>
                <button type="button" data-toggle="modal" data-target="#modal_editar_resposta<?php echo $key; ?>">Editar</button>
                <button>Excluir</button>
                
            </nav>
        </div>
        <?php 
        
        
        ?>
        <!-- Modal modal_editar_resposta-->
        <div class="modal fade" id="modal_editar_resposta<?php echo $key; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="editaResposta.php" class="form" method="POST">
                        <div class="modal-header">
                            <input type="text" name="input_titulo" id="input_titulo" value="<?php echo $value['titulo'] ?>">
                            <button type="button" data-dismiss="modal" aria-label="Fechar">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <textarea class="minha_textarea" name="textarea_modal" id="textarea_modal" cols="30" rows="10" placeholder="Nova Resposta"><?php echo $value['conteudo'] ?></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" data-dismiss="modal" id="fechar_modal">Fechar</button>
                            <button type="submit" onclick="" name="btn_salvar">Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <?php
    }

    ?>

    <!-- Modal modal_cadastrar_resposta-->
    <div class="modal fade" id="modal_cadastrar_resposta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="salvaResposta.php" class="form" method="POST">
                    <div class="modal-header">
                        <input type="text" name="input_titulo" id="input_titulo" placeholder="Título">
                        <button type="button" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <textarea class="minha_textarea" name="textarea_modal" id="textarea_modal" cols="30" rows="10" placeholder="Nova Resposta"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" id="fechar_modal">Fechar</button>
                        <button type="submit" onclick="" name="btn_salvar">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <footer>

    </footer>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="script.js"></script>
    <script src="script-teste.js"></script>
</body>

</html>