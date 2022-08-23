        <?php
        require_once "app".DIRECTORY_SEPARATOR."header.html";
        ?>

        <?php

        session_start();
        if ($_SESSION['Usuario']) {
            require_once "src".DIRECTORY_SEPARATOR."config.php";

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
                        <button data-toggle="modal" data-target="#modal_excluir_resposta<?php echo $value['idanotacao'] ?>">Excluir</button>
                    </nav>
                </div>

                <!-- Modal modal_editar_resposta-->
                <div class="modal fade" id="modal_editar_resposta<?php echo $key; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <form action="src\editaResposta.php" class="form" method="POST">
                                <div class="modal-header">
                                    <input type="text" class="w-100 mr-3 text-center" name="input_titulo" id="input_titulo" value="<?php echo $value['titulo'] ?>">
                                    <input type="text" name="input_id" id="input_id" hidden value="<?php echo $value['idanotacao'] ?>">
                                    <button type="button" data-dismiss="modal" aria-label="Fechar">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <textarea class="minha_textarea" name="textarea_modal" id="textarea_modal" cols="30" rows="10" placeholder="Nova Resposta"><?php echo $value['conteudo'] ?></textarea>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" data-dismiss="modal" id="fechar_modal">Fechar</button>
                                    <button type="submit" name="btn_salvar">Salvar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal deletar resposta -->
                <div class="modal fade text-dark" id="modal_excluir_resposta<?php echo $value['idanotacao'] ?>" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="TituloModalCentralizado">Excluir Anotação</h5>
                                <button type="button" data-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Tem certeza que deseja excluir anotação <strong><?php echo $value['titulo'] ?></strong>?
                            </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal">Manter</button>
                                <form action="src/editaResposta.php" method="POST">
                                    <input type="text" name="input_id_deletar" id="input_id_deletar" hidden value="<?php echo $value['idanotacao'] ?>">
                                    <button type="submit" name="btn_excluir" class="bg-danger">Excluir</button>
                                </form>
                            </div>
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
                        <form action="src/salvaResposta.php" class="form" method="POST">
                            <div class="modal-header">
                                <input type="text" name="input_titulo" id="input_titulo" placeholder="Título" class="w-100 mr-3 text-center" required>
                                <button type="button" data-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <textarea class="minha_textarea" name="textarea_modal" id="textarea_modal" cols="30" rows="10" placeholder="Nova Resposta" required></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal" id="fechar_modal">Fechar</button>
                                <button type="submit" onclick="" name="btn_salvar">Salvar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </section>
<?php } else {
            header('Location: src/login.php');
        } ?>

        
<?php
require_once "app".DIRECTORY_SEPARATOR."footer.html";
?>