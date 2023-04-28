<?php
    $id_del=clean_chain($_GET['id_del']);

    //Verificar user
    $check_bet=connection();
    $check_bet=$check_bet->query("SELECT id FROM apostas WHERE id='$id_del' LIMIT 1");

    if($check_bet->rowCount()==1){
        $eliminar_bet=connection();
        $eliminar_bet=$eliminar_bet->prepare("DELETE FROM apostas 
        WHERE id=:id");

        $eliminar_bet->execute([":id"=>$id_del]);

        if($eliminar_bet->rowCount()==1){
            echo '
            <div class="notification is-info is-light">
                <strong>APOSTA ELIMINADA!</strong><br>
                Aposta eliminado com sucesso!
            </div>
            ';
        }else{
            echo '
            <div class="notification is-danger is-light">
                <strong>Ocorreu um erro inesperado!</strong><br>
                Não se pode eliminar a aposta, por favor tente novamente!
            </div>
            ';
        }

    }else{
        echo '
        <div class="notification is-danger is-light">
            <strong>Ocorreu um erro inesperado!</strong><br>
            A aposta que está a tentar eliminar não existe!
        </div>
        ';
    }
    $check_bet=null;