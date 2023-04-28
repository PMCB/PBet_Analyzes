<?php
    require_once "main.php";

    # Armazenar dados #
    $name=clean_chain($_POST['user_name']);
    $apelido=clean_chain($_POST['user_apelido']);
    $user=clean_chain($_POST['user']);
    $email=clean_chain($_POST['email']);
    $senha_1=clean_chain($_POST['senha_1']);
    $senha_2=clean_chain($_POST['senha_2']);

    # Verificar Campos Obrigatorios #
    if($name=="" || $apelido=="" || $user=="" || $senha_1=="" ||$senha_2==""){
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

    if(verify_data("[a-zA-Z0-9$@.-]{7,100}",$senha_1) || verify_data("[a-zA-Z0-9$@.-]{7,100}",$senha_2)){
        echo '
            <div class="notification is-danger is-light">
                <strong>Ocorreu um erro inesperado!</strong><br>
                As SENHAS não coincide com o fomrato solicitado.
            </div>
        ';
    exit();
    }

    # Verificar Email #
    if ($email!="") {
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

    # Verificar Senhas #
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

    # Guardar dados #
    $save_user=connection();
    
    #$save_user=$save_user->query("INSERT INTO users (nome,apelido,user,senha,email) VALUES('$name','$apelido','$user','$senha','$email')");
    
    $save_user=$save_user->prepare("INSERT INTO users (nome,apelido,user,senha,email) VALUES(:name,:apelido,:user,:senha,:email)");

    $marcadores=[
        ":name"=>$name,
        ":apelido"=>$apelido,
        ":user"=>$user,
        ":senha"=>$senha,
        ":email"=>$email
    ];

    $save_user->execute($marcadores);

    if($save_user->rowCount()==1){
        echo '
        <div class="notification is-danger is-light">
            <strong>User registado</strong><br>
            O user foi registado com sucesso
        </div>
    ';
    }else{
        echo '
        <div class="notification is-danger is-light">
            <strong>Ocorreu um erro inesperado!</strong><br>
            Não se pode registar o user.
        </div>
    ';
    }
    $save_user=null;