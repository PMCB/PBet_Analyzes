<?php
    $user_id_del=clean_chain($_GET['user_id_del']);

    //Verificar user
    $check_user=connection();
    $check_user=$check_user->query("SELECT user_id FROM users WHERE user_id='$user_id_del' LIMIT 1");

    if($check_user->rowCount()==1){
        $eliminar_user=connection();
        $eliminar_user=$eliminar_user->prepare("DELETE FROM users 
        WHERE user_id=:id");

        $eliminar_user->execute([":id"=>$user_id_del]);

        if($eliminar_user->rowCount()==1){
            echo '
            <div class="notification is-info is-light">
                <strong>User Eliminado!</strong><br>
                User eliminado com sucesso!
            </div>
            ';
        }else{
            echo '
            <div class="notification is-danger is-light">
                <strong>Ocorreu um erro inesperado!</strong><br>
                Não se pode eliminar o user, por favor tente novamente!
            </div>
            ';
        }

    }else{
        echo '
        <div class="notification is-danger is-light">
            <strong>Ocorreu um erro inesperado!</strong><br>
            O user que está a tentar eliminar não existe!
        </div>
        ';
    }
    $check_user=null;