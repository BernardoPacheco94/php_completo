<?php if(!class_exists('Rain\Tpl')){exit;}?><!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSS Personalizado -->
    <link rel="stylesheet" href="style/style.css">

    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/4c5a422e1b.js" crossorigin="anonymous"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="../img/favicon/favicon.png">
    <link rel="icon" type="image/svg+xml" href="../img/favicon/favicon.svg">

    <title>Bem-vindo</title>
</head>


<body>
    <header id="menu-principal">
        <nav class="navbar navbar-expand-md text-white fixed-top bg-personalizado-escuro">
            <a class="navbar-brand" href="#menu-principal"><i class="fa-solid fa-house-user fa-2x"></i></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Alterna navegação">
                <span class="navbar-toggler-icon  text-white"><i class="fa-solid fa-bars"></i></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#section-sobre-mim">Sobre mim</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#section-experiencias">Experiências</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#section-formacao">Formação</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#section-projetos">Projetos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contato">Contato</a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <section>
        <div id="container-ola" class="card-personalizado bg-personalizado-claro">
            <div id="ola" class="info-personalizada col-6">
                <h1><i class="fa-solid fa-code"></i> <?php echo htmlspecialchars( $hello, ENT_COMPAT, 'UTF-8', FALSE ); ?>,</h1>
                <br>
                <h4>Me chamo Bernardo Pacheco</h4>
                <h5>Sou desenvovedor Front-End</h5>
            </div>
        </div>
    </section>


    <section id="section-sobre-mim">
        <div id="container-sobre-mim" class="card-personalizado bg-personalizado-escuro">
            <div id="sobre-mim" class="col-xs-6 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                <h1><i class="fa-solid fa-address-card"></i> Sobre mim</h1>
                <h6>Sou natural de Santa Maria - RS</h6>
                <h6>Nascido em Dezembro/1994</h6>
                <h6>Entusiasta da tecnologia</h6>
            </div>
        </div>
    </section>


    <section id="section-experiencias">
        <div id="container-experiencias" class="card-personalizado bg-personalizado-escuro">
            <div id="experiencias" class="col-6">
                <h1 title="Experiências" class="text-truncate"><i class="fa-solid fa-headset"></i> Experiências</h1>
                <h6>Atuação na área de tecnologia, prestando suporte a softwares, pela empresa <a
                        href="https://controlecelular.com.br" target="_blank">Sistemas & Informação</a></h6>
            </div>
        </div>
    </section>

    <section id="section-formacao">
        <div id="container-formacao" class="card-personalizado bg-personalizado-claro">
            <div id="formacao" class="col-xs-6 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                <h1><i class="fa-solid fa-graduation-cap"></i> Formação</h1>
                <h6>Técnico em informátia, formado pela instituição <a href="https://www.senacrs.com.br/unidade/11"
                        target="_blank">Senac - Santa Maria</a></h6>
                <h6>Curso de desenvolvimento web pelo programa <a
                        href="https://bernardopacheco94.github.io/RSTI-front-end/html/trabalho_final_bootstrap/"
                        target="_blank">Senac RS-TI</a></h6>
            </div>
        </div>
    </section>


    <section id="section-projetos">
        <div id="container-projetos" class="container-fluid">
            <div class="row container mx-auto">
                <div class="col-12 text-center mt-5 div-titulo-projetos ">
                    <h1>PROJETOS</h1>
                </div>
            </div>
            <div class="row p-5 mt-5">
                <div class="mb-3 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4">
                    <a class="link-card" href="https://bernardopacheco94.github.io/RSTI-front-end/html/trabalho_v2/"
                        target="_blank">
                        <div class="card bg-dark text-white">
                            <img class="card-img" src="img/card-ldr.PNG" alt="Imagem do card">
                            <div class="card-body card-transparente">
                                <h5 class="card-title">Projeto Série</h5>
                                <p class="card-text">Exercício proposto em aula, para que apresentássemos uma série
                                    usando recursos HTML e CSS.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="mb-3 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4">
                    <a class="link-card" href="https://bernardopacheco94.github.io/laChapa/index.html" target="_blank">
                        <div class="card bg-dark text-white">
                            <img class="card-img" src="img/projeto.PNG" alt="Imagem do card">

                            <div class="card-body card-transparente">
                                <h5 class="card-title">Projeto Pessoal</h5>
                                <p class="card-text">Um wireframe, projetado para gerenciamento de pedidos em
                                    lanchonetes.</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="mb-3 col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4">
                    <a class="link-card" href="https://bernardopacheco94.github.io/respostas-padrao/" target="_blank">
                        <div class="card bg-dark text-white">
                            <img class="card-img" src="img/projeto-2.PNG" alt="Imagem do card">
                            <div class="card-body card-transparente">
                                <h5 class="card-title">Projeto Pessoal - 2</h5>
                                <p class="card-text">Sistema para salvar anotações que precisem ser utilizadas com
                                    frequência.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>


    </section>


    <footer id="contato">
        <div class="container-footer text-center p-5">
            <ul>
                <li><a href="https://www.linkedin.com/in/bernardo-pacheco-aa0078218/" target="_blank"><i
                            class="fa-brands fa-linkedin"></i> Linkedin</a></li>
                <li><a href="https://github.com/BernardoPacheco94" target="_blank"><i class="fa-brands fa-github"></i>
                        GitHub</a></li>
                <li><a href="https://www.instagram.com/bernardo__pacheco/" target="_blank"><i
                            class="fa-brands fa-instagram"></i> Instagram</a></li>
                <li><a href="https://wa.me/5555991484707" target="_blank"><i class="fa-brands fa-whatsapp"></i>
                        Whatsapp</a></li>
            </ul>
        </div>
    </footer>


    <!-- Scripts Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
</body>

</html>