<?php
    require_once "./php/main.php";

    $id=(isset($_GET['id_up'])) ? $_GET['id_up'] : 0;
    $id=clean_chain($id);
?>
<div class="container is-fluid mb-6">
        <h1 class="title">Análise</h1>        
</div>

<div class="container pb-6 pt-6">
    <?php
        include "./inc/btn_back.php";

        $check_game=connection();
        $check_game=$check_game->query("SELECT * FROM prog WHERE id='$id'");

        if ($check_game->rowCount()>0){ 
            $dados=$check_game->fetch();
        }
    ?>
</div>