<div class="container is-fluid mb-6">
    <h1 class="title">Banca</h1>
    <h2 class="subtitle">Análise</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once "./php/main.php";

        //Eliminar user
        if(isset($_GET['id_del'])){
            require_once "./php/bet_eliminar.php";
        }

        if(!isset($_GET['page'])){
            $pagina=1;
        }else{
            $pagina=(int) $_GET['page'];
            if($pagina<=1){
                $pagina=1;
            }
        }

        $pagina=clean_chain($pagina);
        $url="index.php?vista=banca_analise&page=";
        $registros=15;
        $busca="";

        require_once "./php/banca_analise_lista.php";
    ?>     
</div>