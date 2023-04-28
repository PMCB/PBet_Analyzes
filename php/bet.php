<?php
    require_once "../inc/session_start.php";

    require_once "main.php";

    $id=clean_chain($_POST['id']);

    //verificar o user
    $check_game=connection();
    $check_game=$check_game->query("SELECT * FROM prog WHERE id='$id'");

    if($check_game->rowCount()<=0){
        echo '
            <div class="notification is-danger is-light">
                <strong>Ocorreu um erro inesperado!</strong><br>
                O user não existe!
            </div>
        ';
        exit();
    }else{
        $dados=$check_game->fetch();
    }
    $check_game=null;

    
    # Armazenar dados #
    $team_home=$_POST['team_home'];
    $team_away=$_POST['team_away'];
    $metodo=$_POST['metodo'];
    $casa_ap=$_POST['casa_ap'];
    $odd=$_POST['odd'];

    $data=$_POST['data'];
    $tipo=$_POST['tipo'];
    $league=$_POST['league'];
    $mercado=$_POST['mercado'];
    $entrada=$_POST['entrada'];

    if ($entrada==""){
        echo '
        <div class="notification is-danger is-light">
            <strong>Ocorreu um erro inesperado!</strong><br>
            É necessário indicar a ENTRADA da aposta!
        </div>
        ';
        exit();
    }


    if ($casa_ap==""){
        echo '
        <div class="notification is-danger is-light">
            <strong>Ocorreu um erro inesperado!</strong><br>
            É necessário indicar uma CASA DE APOSTA!
        </div>
        ';
        exit();
    }

    if ($odd=="" || $odd<=1){
        echo '
        <div class="notification is-danger is-light">
            <strong>Ocorreu um erro inesperado!</strong><br>
            É necessário indicar uma ODD válida!
        </div>
        ';
        exit();
    }
    
    # Atualizar dados #
    $insert_aposta=connection();
    $insert_aposta=$insert_aposta->prepare("INSERT INTO apostas (data,tipo,league,mercado,entrada,team_home,team_away,metodo,casa_ap,odd) VALUES (:data,:tipo,:league,:mercado,:entrada,:team_home,:team_away,:metodo,:casa_ap,:odd)");

    $marcadores=[
        ":data"=>$data,
        ":tipo"=>$tipo,
        ":league"=>$league,
        ":mercado"=>$mercado,
        ":entrada"=>$entrada,
        ":team_home"=>$team_home,
        ":team_away"=>$team_away,
        ":metodo"=>$metodo,
        ":casa_ap"=>$casa_ap,
        ":odd"=>$odd
    ];

    if($insert_aposta->execute($marcadores)){
        echo '
        <div class="notification is-info is-light">
            <strong>APOSTA INSERIDA!</strong><br>
            APOSTA inserida com sucesso.
        </div>
        ';
    }else{
        echo '
        <div class="notification is-danger is-light">
            <strong>Ocorreu um erro inesperado!</strong><br>
            Não foi possivel inserie a APOSTA.
        </div>
        ';
    }
    $insert_aposta=null;