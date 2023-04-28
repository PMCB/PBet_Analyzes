<?php
    require_once "../inc/session_start.php";

    require_once "main.php";

    $id=clean_chain($_POST['user_id']);

    //verificar o user
    $check_user=connection();
    $check_user=$check_user->query("SELECT * FROM users WHERE user_id='$id'");

    if($check_user->rowCount()<=0){
        echo '
            <div class="notification is-danger is-light">
                <strong>Ocorreu um erro inesperado!</strong><br>
                O user não existe!
            </div>
        ';
        exit();
    }else{
        $dados=$check_user->fetch();
    }
    $check_user=null;

    $admin_user=clean_chain($_POST['administrador_usuario']);
    $admin_clave=clean_chain($_POST['administrador_clave']);


    if($admin_user=="" || $admin_clave==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>Ocorreu um erro inesperado!</strong><br>
                Não preencheu todos os campos obrigatórios, que correspondam ao seu USER e SENHA!
            </div>
            ';
        exit();
    }

    # Verificar integridade dos dados #
    if(verify_data("[a-zA-Z0-9]{4,20}",$admin_user)){
        echo '
            <div class="notification is-danger is-light">
                <strong>Ocorreu um erro inesperado!</strong><br>
                O USER não coincide com o fomrato solicitado.
            </div>
        ';
        exit();
    }

    if(verify_data("[a-zA-Z0-9$@.-]{7,100}",$admin_clave)){
        echo '
            <div class="notification is-danger is-light">
                <strong>Ocorreu um erro inesperado!</strong><br>
                A sua SENHA não coincide com o fomrato solicitado.
            </div>
        ';
        exit();
    }

    #Verificar Admin
    $check_admin=connection();
    $check_admin=$check_admin->query("SELECT user,senha FROM users WHERE user='$admin_user' AND user_id='".$_SESSION['id']."'");

    if($check_admin->rowCount()==1){
        $check_admin=$check_admin->fetch();
        if($check_admin['user']!=$admin_user || !password_verify($admin_clave,$check_admin['senha'])){
            echo '
            <div class="notification is-danger is-light">
                <strong>Ocorreu um erro inesperado!</strong><br>
                USER ou SENHA de administrador incorretos.
            </div>
        ';
        exit();
        }
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>Ocorreu um erro inesperado!</strong><br>
                USER ou SENHA de administrador incorretos.
            </div>
        ';
        exit();
    }
    $check_admin=null;

    # Armazenar dados #
    $name=clean_chain($_POST['user_name']);
    $apelido=clean_chain($_POST['user_apelido']);
    $user=clean_chain($_POST['user']);
    $email=clean_chain($_POST['email']);
    $senha_1=clean_chain($_POST['senha_1']);
    $senha_2=clean_chain($_POST['senha_2']);

    # Verificar Campos Obrigatorios #
    if($name=="" || $apelido=="" || $user==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>Ocorreu um erro inesperado!</strong><br>
                Não preencheu todos os campos obrigatórios!
            </div>
            ';
        exit();
    }

    # Verificar integridade dos dados #
    if(verify_data("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$name)){
        echo '
        <div class="notification is-danger is-light">
            <strong>Ocorreu um erro inesperado!</strong><br>
            O NOME não coincide com o fomrato solicitado.
        </div>
        ';
    exit();
    }

    if(verify_data("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apelido)){
        echo '
        <div class="notification is-danger is-light">
            <strong>Ocorreu um erro inesperado!</strong><br>
            O APELIDO não coincide com o fomrato solicitado.
        </div>
        ';
    exit();
    }

    if(verify_data("[a-zA-Z0-9]{4,20}",$user)){
        echo '
        <div class="notification is-danger is-light">
            <strong>Ocorreu um erro inesperado!</strong><br>
            O USER não coincide com o fomrato solicitado.
        </div>
        ';
    exit();
    }

    # Verificar Email #
    if ($email!="" && $email!=$dados['email']) {
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $check_email=connection();
            $check_email=$check_email->query("SELECT email FROM users WHERE email='$email'");
            if($check_email->rowCount()>0){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>Ocorreu um erro inesperado!</strong><br>
                        O EMAIL já se encontra registado, por favor insira um novo email.
                    </div>
                ';
            exit();
            }
            $check_email=null;
        }else{
            echo '
                <div class="notification is-danger is-light">
                    <strong>Ocorreu um erro inesperado!</strong><br>
                    O EMAIL não é válido
                </div>
            ';
            exit();
        }
    }

    # Verificar User #
    if ($user!=$dados['user']){
        $check_user=connection();
        $check_user=$check_user->query("SELECT user FROM users WHERE user='$user'");
        if($check_user->rowCount()>0){
            echo '
                <div class="notification is-danger is-light">
                    <strong>Ocorreu um erro inesperado!</strong><br>
                    O USER já se encontra registado, por favor insira um novo user.
                </div>
            ';
            exit();
        }
        $check_user=null;
    }

    # Verificar Senhas #
    if($senha_1!="" || $senha_2!=""){
        if(verify_data("[a-zA-Z0-9$@.-]{7,100}",$senha_1) || verify_data("[a-zA-Z0-9$@.-]{7,100}",$senha_2)){
            echo '
                <div class="notification is-danger is-light">
                    <strong>Ocorreu um erro inesperado!</strong><br>
                    As SENHAS não coincide com o fomrato solicitado.
                </div>
            ';
        exit();
        } else {
            if($senha_1!=$senha_2){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>Ocorreu um erro inesperado!</strong><br>
                        As SENHAS não coincidem.
                    </div>
                ';
            exit();
            }else{
                $senha=password_hash($senha_1,PASSWORD_BCRYPT,["cost"=>10]);
            }    
        }
    }else{
        $senha=$dados['senha'];
    }

    # Atualizar dados #
    $atualizar_user=connection();
    $atualizar_user=$atualizar_user->prepare("UPDATE users SET nome=:name,apelido=:apelido,user=:user,senha=:senha,email=:email WHERE user_id=:id");

    $marcadores=[
        ":name"=>$name,
        ":apelido"=>$apelido,
        ":user"=>$user,
        ":senha"=>$senha,
        ":email"=>$email,
        "id"=>$id
    ];

    if($atualizar_user->execute($marcadores)){
        echo '
        <div class="notification is-info is-light">
            <strong>USER ATUALIZADO!</strong><br>
            USER atualizado com sucesso.
        </div>
        ';
    }else{
        echo '
        <div class="notification is-danger is-light">
            <strong>Ocorreu um erro inesperado!</strong><br>
            Não foi possivel atualizar o USER.
        </div>
        ';
    }