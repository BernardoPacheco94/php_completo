<form method="post">
    <input type="text" name="busca" id="">
    <button type="submit">Enviar</button>
</form>

<?php
    if(isset($_POST['busca']))
    {
        //echo strip_tags( $_POST['busca'],'<strong>');//segundo parametro sao as tags permitidas
        
        
        echo htmlentities($_POST['busca']);//escreve o <> como texto
    }
?>