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

        $check_conn=connection();
        $check_game=$check_conn->query("SELECT * FROM prog WHERE id='$id'");

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

            echo "<h1 class=\"title\"> ".$pos_eq_casa."º   <b>".$eq_casa_ss."</b> VS <b>".$eq_fora_ss."   </b>".$pos_eq_fora."º</h1>";

            echo "<div class=\"columns\">";
            echo "<div class=\"column is-1\">";
            echo "<h3 style=\"text-align: right;\"><b>1</b></h3>";
            echo "</div>";
            echo "<div class=\"column is-1\">";
            echo "<h3>".$prob_1."%</h3>";
            echo "</div>";

            echo "<div class=\"column is-1\">";
            echo "<h3 style=\"text-align: right;\"><b>X</b></h3>";
            echo "</div>";
            echo "<div class=\"column is-1\">";
            echo "<h3>".$prob_x."%</h3>";
            echo "</div>";

            echo "<div class=\"column is-1\">";
            echo "<h3 style=\"text-align: right;\"><b>2</b></h3>";
            echo "</div>";
            echo "<div class=\"column is-1\">";
            echo "<h3>".$prob_2."%</h3>";
            echo "</div>";

            echo "<div class=\"column is-1\">";
            echo "<h3 style=\"text-align: right;\"><b>O2,5</b></h3>";
            echo "</div>";
            echo "<div class=\"column is-1\">";
            echo "<h3>".$O25."%</h3>";
            echo "</div>";

            echo "<div class=\"column is-1\">";
            echo "<h3 style=\"text-align: right;\"><b>BTTS</b></h3>";
            echo "</div>";
            echo "<div class=\"column is-1\">";
            echo "<h3>".$btts_yes."%</h3>";
            echo "</div>";
            echo "</div>";

            echo "<div class=\"columns\">";
            echo "<div class=\"column is-2\">";
            echo "<h3 style=\"text-align: right;\"><b>1X2</b></h3>";
            echo "</div>";
            echo "<div class=\"column is-2\">";
            echo "<h3>".$bet_resultado."</h3>";
            echo "</div>";

            echo "<div class=\"column is-2\">";
            echo "<h3 style=\"text-align: right;\"><b>Over 2,5</b></h3>";
            echo "</div>";
            echo "<div class=\"column is-2\">";
            echo "<h3>".$O25_resultado."</h3>";
            echo "</div>";

            echo "<div class=\"column is-2\">";
            echo "<h3 style=\"text-align: right;\"><b>BTTS</b></h3>";
            echo "</div>";
            echo "<div class=\"column is-2\">";
            echo "<h3>".$btts_resultado."</h3>";
            echo "</div>";
            
            echo "</div>";
    
        }else{
            include "./inc/error_alert.php";
        }
        $check_game=null;
    ?>    

    <?php        
        $check_game=$check_conn->query("select team_fs from equipas where team_ss = '$eq_casa_ss'");

        if ($check_game->rowCount()>0){ 
            $dados=$check_game->fetch();
            $eq_casa_fs=$dados['team_fs'];
        }else{
            include "./inc/error_alert.php";
        }
        $check_game=null;

        $check_game=$check_conn->query("select team_fs from equipas where team_ss = '$eq_fora_ss'");

        if ($check_game->rowCount()>0){ 
            $dados=$check_game->fetch();
            $eq_fora_fs=$dados['team_fs'];
        }else{
            include "./inc/error_alert.php";
        }
        $check_game=null;  

        $check_game=$check_conn->query("select Odd_H,Odd_D,Odd_A,Odd_Over25,Odd_Under25,Odd_BTTS_Yes,Odd_BTTS_No from jogos where Home = (select team_fs from equipas where team_ss = '".$eq_casa_ss."') and Away = (select team_fs from equipas where team_ss = '".$eq_fora_ss."')");

        if ($check_game->rowCount()>0){ 
            $dados=$check_game->fetch();
            $Odd_H=$dados['Odd_H'];
            $Odd_D=$dados['Odd_D'];
            $Odd_A=$dados['Odd_A'];
            $Odd_Over25=$dados['Odd_Over25'];
            $Odd_Under25=$dados['Odd_Under25'];
            $Odd_BTTS_Yes=$dados['Odd_BTTS_Yes'];
            $Odd_BTTS_No=$dados['Odd_BTTS_No'];

            echo "<div class=\"columns\">";
            echo "<div class=\"column is-1\">";
            echo "<h3 style=\"text-align: right;\"><b>Home</b></h3>";
            echo "</div>";
            echo "<div class=\"column is-1\">";
            echo "<h3>".$Odd_H."</h3>";
            echo "</div>";

            echo "<div class=\"column is-1\">";
            echo "<h3 style=\"text-align: right;\"><b>Draw</b></h3>";
            echo "</div>";
            echo "<div class=\"column is-1\">";
            echo "<h3>".$Odd_D."</h3>";
            echo "</div>";

            echo "<div class=\"column is-1\">";
            echo "<h3 style=\"text-align: right;\"><b>Away</b></h3>";
            echo "</div>";
            echo "<div class=\"column is-1\">";
            echo "<h3>".$Odd_A."</h3>";
            echo "</div>";

            echo "<div class=\"column is-1\">";
            echo "<h3 style=\"text-align: right;\"><b>Over 2,5</b></h3>";
            echo "</div>";
            echo "<div class=\"column is-1\">";
            echo "<h3>".$Odd_Over25."</h3>";
            echo "</div>";

            echo "<div class=\"column is-1\">";
            echo "<h3 style=\"text-align: right;\"><b>Under 2,5</b></h3>";
            echo "</div>";
            echo "<div class=\"column is-1\">";
            echo "<h3>".$Odd_Under25."</h3>";
            echo "</div>";

            echo "<div class=\"column is-1\">";
            echo "<h3 style=\"text-align: right;\"><b>BTTS Yes</b></h3>";
            echo "</div>";
            echo "<div class=\"column is-1\">";
            echo "<h3>".$Odd_BTTS_Yes."</h3>";
            echo "</div>";

            echo "<div class=\"column is-1\">";
            echo "<h3 style=\"text-align: right;\"><b>BTTS No</b></h3>";
            echo "</div>";
            echo "<div class=\"column is-1\">";
            echo "<h3>".$Odd_BTTS_No."</h3>";
            echo "</div>";
            echo "</div>";

            echo "</div>";

        }else{
            include "./inc/error_alert.php";
        }
        $check_game=null;
    ?>
</div>

<div class="container pb-6 pt-6">
    <?php
        echo "<div class=\"columns\">";
        echo "<div class=\"column\">";
        echo "<table class=\"table is-striped\">";
        echo "<tr>";
        echo "<th></th>";
        echo "<th style=\"text-align: center;\">Geral</th>";
        echo "<th style=\"text-align: center;\">Casa</th>";
        echo "<th style=\"text-align: center;\">Fora</th>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>".$eq_casa_ss."</td>";
        echo "<td>".$pos_eq_casa."</td>";
        echo "<td>".$pos_eq_casa_home."</td>";
        echo "<td>".$pos_eq_casa_away."</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>".$eq_fora_ss."</td>";
        echo "<td>".$pos_eq_fora."</td>";
        echo "<td>".$pos_eq_fora_home."</td>";
        echo "<td>".$pos_eq_fora_away."</td>";
        echo "</tr>";
        echo "</table>";
        echo "</div>";


        echo "<div class=\"column\">";
        echo "<table class=\"table is-striped\">";
        echo "<tr>";
        echo "<th></th>";
        echo "<th colspan=\"3\" style=\"text-align: center;\">Geral</th>";
        echo "<th colspan=\"3\" style=\"text-align: center;\">Casa</th>";
        echo "<th colspan=\"3\" style=\"text-align: center;\">Fora</th>";
        echo "</tr>";
        echo "<tr>";
        echo "<th></th>";
        echo "<th style=\"text-align: center;\">V</th>";
        echo "<th style=\"text-align: center;\">E</th>";
        echo "<th style=\"text-align: center;\">D</th>";
        echo "<th style=\"text-align: center;\">V</th>";
        echo "<th style=\"text-align: center;\">E</th>";
        echo "<th style=\"text-align: center;\">D</th>";
        echo "<th style=\"text-align: center;\">V</th>";
        echo "<th style=\"text-align: center;\">E</th>";
        echo "<th style=\"text-align: center;\">D</th>";
        echo "</tr>";
        echo "<tr>";
        echo "<td>".$eq_casa_ss."</td>";        
        
        $check_game=$check_conn->query("select count(id_jogo) vitoria_casa from jogos Where (Home = (select team_fs from equipas where team_ss = '".$eq_casa_ss."') and Goal_home_FT>Goal_away_FT) or (Away = (select team_fs from equipas where team_ss = '".$eq_casa_ss."') and Goal_home_FT<Goal_away_FT);");

        if ($check_game->rowCount()>0){ 
            $dados=$check_game->fetch();
            echo "<td>".$dados['vitoria_casa']."</td>";

        }else{
            echo "<td></td>";
        }
        $check_game=null;

        $check_game=$check_conn->query("select count(id_jogo) empate_casa from jogos Where (Home = (select team_fs from equipas where team_ss = '".$eq_casa_ss."') and Goal_home_FT=Goal_away_FT) or (Away = (select team_fs from equipas where team_ss = '".$eq_casa_ss."') and Goal_home_FT=Goal_away_FT);");

        if ($check_game->rowCount()>0){ 
            $dados=$check_game->fetch();
            echo "<td>".$dados['empate_casa']."</td>";

        }else{
            echo "<td></td>";
        }
        $check_game=null;

        $check_game=$check_conn->query("select count(id_jogo) derrota_casa from jogos Where (Home = (select team_fs from equipas where team_ss = '".$eq_casa_ss."') and Goal_home_FT<Goal_away_FT) or (Away = (select team_fs from equipas where team_ss = '".$eq_casa_ss."') and Goal_home_FT>Goal_away_FT);");

        if ($check_game->rowCount()>0){ 
            $dados=$check_game->fetch();
            echo "<td>".$dados['derrota_casa']."</td>";

        }else{
            echo "<td></td>";
        }
        $check_game=null;

        $check_game=$check_conn->query("select count(id_jogo) vitoria_casa_casa from jogos Where (Home = (select team_fs from equipas where team_ss = '".$eq_casa_ss."') and Goal_home_FT>Goal_away_FT);");

        if ($check_game->rowCount()>0){ 
            $dados=$check_game->fetch();
            echo "<td>".$dados['vitoria_casa_casa']."</td>";

        }else{
            echo "<td></td>";
        }
        $check_game=null;

        $check_game=$check_conn->query("select count(id_jogo) empate_casa_casa from jogos Where (Home = (select team_fs from equipas where team_ss = '".$eq_casa_ss."') and Goal_home_FT=Goal_away_FT);");

        if ($check_game->rowCount()>0){ 
            $dados=$check_game->fetch();
            echo "<td>".$dados['empate_casa_casa']."</td>";

        }else{
            echo "<td></td>";
        }
        $check_game=null;

        $check_game=$check_conn->query("select count(id_jogo) derrota_casa_casa from jogos Where (Home = (select team_fs from equipas where team_ss = '".$eq_casa_ss."') and Goal_home_FT<Goal_away_FT);");

        if ($check_game->rowCount()>0){ 
            $dados=$check_game->fetch();
            echo "<td>".$dados['derrota_casa_casa']."</td>";

        }else{
            echo "<td></td>";
        }
        $check_game=null;


        $check_game=$check_conn->query("select count(id_jogo) vitoria_casa_fora from jogos Where (Away = (select team_fs from equipas where team_ss = '".$eq_casa_ss."') and Goal_home_FT<Goal_away_FT);");

        if ($check_game->rowCount()>0){ 
            $dados=$check_game->fetch();
            echo "<td>".$dados['vitoria_casa_fora']."</td>";

        }else{
            echo "<td></td>";
        }
        $check_game=null;

        $check_game=$check_conn->query("select count(id_jogo) empate_casa_fora from jogos Where (Away = (select team_fs from equipas where team_ss = '".$eq_casa_ss."') and Goal_home_FT=Goal_away_FT);");

        if ($check_game->rowCount()>0){ 
            $dados=$check_game->fetch();
            echo "<td>".$dados['empate_casa_fora']."</td>";

        }else{
            echo "<td></td>";
        }
        $check_game=null;

        $check_game=$check_conn->query("select count(id_jogo) derrota_casa_fora from jogos Where (Away = (select team_fs from equipas where team_ss = '".$eq_casa_ss."') and Goal_home_FT>Goal_away_FT);");

        if ($check_game->rowCount()>0){ 
            $dados=$check_game->fetch();
            echo "<td>".$dados['derrota_casa_fora']."</td>";

        }else{
            echo "<td></td>";
        }
        $check_game=null;

        echo "</tr>";
        echo "</table>";
        echo "</div>";





        echo "</div>";
    ?>
</div>