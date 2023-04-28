<div class="container is-fluid mb-6">
    <h1 class="title">Todos os Jogos</h1>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once "./php/main.php";

        if(!isset($_GET['page'])){
            $pagina=1;
        }else{
            $pagina=(int) $_GET['page'];
            if($pagina<=1){
                $pagina=1;
            }
        }

        $pagina=clean_chain($pagina);
        $url="index.php?vista=total_games&page=";
        $registros=15;
        $busca="";

        require_once "./php/total_games_lista.php";
    ?>     
</div>