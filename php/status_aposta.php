<?php
    require_once "../inc/session_start.php";

    require_once "main.php";

    $id=clean_chain($_POST['id']);

    //verificar o user
    $check_bet=connection();
    $check_bet=$check_bet->query("SELECT * FROM apostas WHERE id='$id'");

    if($check_bet->rowCount()<=0){
        echo '
            <div class="notification is-danger is-light">
                <strong>Ocorreu um erro inesperado!</strong><br>
                Asposta não existe!
            </div>
        ';
        exit();
    }else{
        $dados=$check_bet->fetch();
    }
    $check_bet=null;



    # Armazenar dados #
    $status=$_POST['status'];
    $odd=$dados['odd'];

    if ($status==""){
        echo '
        <div class="notification is-danger is-light">
            <strong>Ocorreu um erro inesperado!</strong><br>
            É necessário indicar o STATUS da aposta!
        </div>
        ';
        exit();
    }

    if($status=="green")
    {
        $lucro=$odd-1;
    }
    if($status=="void")
    {
        $lucro=0;
    }
    if($status=="red")
    {
        $lucro=-1;
    }


    
    # Atualizar dados #
    $update_status=connection();
    $update_status=$update_status->prepare("UPDATE apostas SET status=:status,lucro=:lucro WHERE id=:id");

    $marcadores=[
        ":status"=>$status,
        ":lucro"=>$lucro,
        "id"=>$id
    ];

    if($update_status->execute($marcadores)){
        echo "<script>";
        echo "alert('This is an alert from JavaScript!');";
        echo "</script>";
        echo '
        <div class="notification is-info is-light">
            <strong>APOSTA ATUALIZADA!</strong><br>
            APOSTA atualizada com sucesso.
        </div>
        '; 
    }else{
        echo '
        <div class="notification is-danger is-light">
            <strong>Ocorreu um erro inesperado!</strong><br>
            Não foi possivel atualizar a APOSTA.
        </div>
        ';
    }
    $insert_aposta=null;