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

            $eq_casa_ss=$dados['eq_casa'];
            $eq_fora_ss=$dados['eq_fora'];
            $pos_eq_casa=$dados['pos_eq_casa'];
            $pos_eq_fora=$dados['pos_eq_fora'];
            $eq_home_EXP=$dados['eq_home_EXP'];
            $eq_away_EXP=$dados['eq_away_EXP'];
            $pos_eq_casa_home=$dados['pos_eq_casa_home'];
            $pos_eq_fora_home=$dados['pos_eq_fora_home'];
            $pos_eq_casa_away=$dados['pos_eq_casa_away'];
            $pos_eq_fora_away=$dados['pos_eq_fora_away'];
            $prob_1=$dados['prob_1'];
            $prob_x=$dados['prob_x'];
            $prob_2=$dados['prob_2'];
            $btts_yes=$dados['btts_yes'];
            $btts_no=$dados['btts_no'];
            $O25_home=$dados['O25_home'];
            $U25_home=$dados['U25_home'];
            $O25_away=$dados['O25_away'];
            $U25_away=$dados['U25_away'];
            $O25=$dados['O25'];
            $U25=$dados['U25'];
            $bet_resultado=$dados['bet_resultado'];
            $btts_resultado=$dados['btts_resultado'];
            $O25_resultado=$dados['O25_resultado'];

            echo "<h1 class=\"title\"> ".$pos_eq_casa."º   <b>".$eq_casa_ss."></b> VS <b>".$eq_fora_ss."   </b>".$pos_eq_fora."º</h1>";

            echo "<div class=\"columns\">";
            echo "<div class=\"column is-1\">";
            echo "<h3><b>1</b></h3>";
            echo "</div>";
            echo "<div class=\"column is-1\">";
            echo "<h3>".$prob_1."%</h3>";
            echo "</div>";

            echo "<div class=\"column is-1\">";
            echo "<h3><b>X</b></h3>";
            echo "</div>";
            echo "<div class=\"column is-1\">";
            echo "<h3>".$prob_x."%</h3>";
            echo "</div>";

            echo "<div class=\"column is-1\">";
            echo "<h3><b>2</b></h3>";
            echo "</div>";
            echo "<div class=\"column is-1\">";
            echo "<h3>".$prob_2."%</h3>";
            echo "</div>";


            echo "<div class=\"column is-1\">";
            echo "<h3><b>O2,5</b></h3>";
            echo "</div>";
            echo "<div class=\"column is-1\">";
            echo "<h3>".$O25."%</h3>";
            echo "</div>";

            echo "<div class=\"column is-1\">";
            echo "<h3><b>U2,5</b></h3>";
            echo "</div>";
            echo "<div class=\"column is-1\">";
            echo "<h3>".$U25."%</h3>";
            echo "</div>";

            echo "<div class=\"column is-1\">";
            echo "<h3><b>BTTS</b></h3>";
            echo "</div>";
            echo "<div class=\"column is-1\">";
            echo "<h3>".$btts_yes."%</h3>";
            echo "</div>";
            echo "</div>";
    
        }else{
            include "./inc/error_alert.php";
        }
        $check_game=null;
    ?>    
</div>
