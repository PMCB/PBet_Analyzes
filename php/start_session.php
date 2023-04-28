<?php

    # Armazenar dados #
    $user=clean_chain($_POST['login_usuario']);
    $pass=clean_chain($_POST['login_clave']);

    # Verificar campos obrigatorios #
    if($user=="" || $pass==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>Ocorreu um erro inesperado!</strong><br>
                Não preencheu todos os campos obrigatórios!
            </div>
            ';
        exit();
    }

    # Verificar integridade dos dados #
    if(verify_data("[a-zA-Z0-9]{4,20}",$user)){
        echo '
        <div class="notification is-danger is-light">
            <strong>Ocorreu um erro inesperado!</strong><br>
            O USER não coincide com o fomrato solicitado.
        </div>
        ';
    exit();
    }

    if(verify_data("[a-zA-Z0-9$@.-]{7,100}",$pass)){
        echo '
            <div class="notification is-danger is-light">
                <strong>Ocorreu um erro inesperado!</strong><br>
                A SENHA não coincide com o fomrato solicitado.
            </div>
        ';
    exit();
    }

    $check_user=connection();
    $check_user=$check_user->query("SELECT * FROM users WHERE user='$user'");

    if($check_user->rowCount()==1){
        $check_user=$check_user->fetch();
        
        if($check_user['user']==$user && password_verify($pass,$check_user['senha'])){
            $_SESSION['id']=$check_user['user_id'];
            $_SESSION['name']=$check_user['nome'];
            $_SESSION['apelido']=$check_user['apelido'];
            $_SESSION['user']=$check_user['user'];

            if(headers_sent()){
                echo "<script>window.location.href='index.php?vista=home'</script>";
            }else{
                header("Location: index.php?vista=home");
            }
        }else{
            echo '
                <div class="notification is-danger is-light">
                    <strong>Ocorreu um erro inesperado!</strong><br>
                    USER ou SENHA incorretos.
                </div>
            ';
        }
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>Ocorreu um erro inesperado!</strong><br>
                USER ou SENHA incorretos.
            </div>
        ';
    }
    $check_user=null;