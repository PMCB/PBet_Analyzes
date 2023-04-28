<?php
    $modulo_buscador=clean_chain($_POST['modulo_buscador']);

    $modulos=["user","categoria","produto"];

    if(in_array($modulo_buscador,$modulos)){
        
    }else{
        echo '
        <div class="notification is-danger is-light">
            <strong>Ocorreu um erro inesperado!</strong><br>
            Não é possivel efetuar a pesquisa!
        </div>
        ';
    }