<?php
    require_once "./php/main.php";
?>

<div class="container pb-6 pt-6">
    <?php
        $lucro_dia=connection();
        $lucro_dia=$lucro_dia->query("SELECT data,sum(lucro) lucro FROM `apostas` group by data order by data DESC");

        $lucro_league=connection();
        $lucro_league=$lucro_league->query("SELECT league,sum(lucro) lucro FROM `apostas` group by league order by lucro DESC;");
        if ($lucro_league->rowCount()>0){ 
            $lucro_league=$lucro_league->fetchAll();
        }

        $lucro_entrada=connection();
        $lucro_entrada=$lucro_entrada->query("SELECT entrada,sum(lucro) lucro FROM `apostas` group by entrada order by lucro DESC;");
        if ($lucro_entrada->rowCount()>0){ 
            $lucro_entrada=$lucro_entrada->fetchAll();
        }

        $lucro_league_entrada=connection();
        $lucro_league_entrada=$lucro_league_entrada->query("SELECT league,entrada,count(entrada) n_ent,sum(lucro) lucro FROM `apostas` group by league,entrada order by lucro DESC;");
        if ($lucro_league_entrada->rowCount()>0){ 
            $lucro_league_entrada=$lucro_league_entrada->fetchAll();
        }

        $lucro_month=connection();
        $lucro_month=$lucro_month->query("SELECT MONTH(data) AS month,sum(lucro) lucro FROM `apostas` group by month order by month ASC,lucro DESC;");
        if ($lucro_month->rowCount()>0){ 
            $lucro_month=$lucro_month->fetchAll();
        }

        $lucro_casa=connection();
        $lucro_casa=$lucro_casa->query("SELECT casa_ap,sum(lucro) lucro FROM `apostas` group by casa_ap order by lucro DESC;");
        if ($lucro_casa->rowCount()>0){ 
            $lucro_casa=$lucro_casa->fetchAll();
        }

        if ($lucro_dia->rowCount()>0){ 
            $lucro_dia=$lucro_dia->fetchAll();
    ?>

    <div class="columns">
    <div class="column">
            <div class="control">
            <div class="table-container">
                    <table class="table is-striped is-narrow">
                        <thead>
                            <tr>
                                <th><span class="tag is-link is-medium">Liga</span></th>
                                <th><span class="tag is-link is-medium">Lucro</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($lucro_league as $rows){
                                echo '<tr>';
                                echo '<td>'.$rows['league'].'</td>';
                                if ($rows['lucro']>0){
                                    echo '<td><span class="tag is-success">'.$rows['lucro'].'</span></td>';
                                } elseif ($rows['lucro']<0){
                                    echo '<td><span class="tag is-danger">'.$rows['lucro'].'</span></td>';
                                } else {
                                    echo '<td>'.$rows['lucro'].'</td>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="control">
                <div class="table-container">
                    <table class="table is-striped is-narrow">
                        <thead>
                            <tr>
                                <th><span class="tag is-link is-medium">Data</span></th>
                                <th><span class="tag is-link is-medium">Lucro</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($lucro_dia as $rows){
                                echo '<tr>';
                                echo '<td>'.$rows['data'].'</td>';
                                if ($rows['lucro']>0){
                                    echo '<td><span class="tag is-success">'.$rows['lucro'].'</span></td>';
                                } elseif ($rows['lucro']<0){
                                    echo '<td><span class="tag is-danger">'.$rows['lucro'].'</span></td>';
                                } else {
                                    echo '<td>'.$rows['lucro'].'</td>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <table class="table is-striped is-narrow">
                        <thead>
                            <tr>
                                <th><span class="tag is-link is-medium">Mês</span></th>
                                <th><span class="tag is-link is-medium">Lucro</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($lucro_month as $rows){
                                echo '<tr>';
                                echo '<td>'.$rows['month'].'</td>';
                                if ($rows['lucro']>0){
                                    echo '<td><span class="tag is-success">'.$rows['lucro'].'</span></td>';
                                } elseif ($rows['lucro']<0){
                                    echo '<td><span class="tag is-danger">'.$rows['lucro'].'</span></td>';
                                } else {
                                    echo '<td>'.$rows['lucro'].'</td>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="column">
            <div class="control">
            <div class="table-container">
                    <table class="table is-striped is-narrow">
                        <thead>
                            <tr>
                                <th><span class="tag is-link is-medium">Entrada</span></th>
                                <th><span class="tag is-link is-medium">Lucro</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($lucro_entrada as $rows){
                                echo '<tr>';
                                echo '<td>'.$rows['entrada'].'</td>';
                                if ($rows['lucro']>0){
                                    echo '<td><span class="tag is-success">'.$rows['lucro'].'</span></td>';
                                } elseif ($rows['lucro']<0){
                                    echo '<td><span class="tag is-danger">'.$rows['lucro'].'</span></td>';
                                } else {
                                    echo '<td>'.$rows['lucro'].'</td>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <table class="table is-striped is-narrow">
                        <thead>
                            <tr>
                                <th><span class="tag is-link is-medium">Casa</span></th>
                                <th><span class="tag is-link is-medium">Lucro</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($lucro_casa as $rows){
                                echo '<tr>';
                                echo '<td>'.$rows['casa_ap'].'</td>';
                                if ($rows['lucro']>0){
                                    echo '<td><span class="tag is-success">'.$rows['lucro'].'</span></td>';
                                } elseif ($rows['lucro']<0){
                                    echo '<td><span class="tag is-danger">'.$rows['lucro'].'</span></td>';
                                } else {
                                    echo '<td>'.$rows['lucro'].'</td>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="control">
            <div class="table-container">
                    <table class="table is-striped is-narrow">
                        <thead>
                            <tr>
                                <th><span class="tag is-link is-medium">Liga</span></th>
                                <th><span class="tag is-link is-medium">Entrada</span></th>
                                <th><span class="tag is-link is-medium">Nº Entradas</span></th>
                                <th><span class="tag is-link is-medium">Lucro</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach($lucro_league_entrada as $rows){
                                echo '<tr>';
                                echo '<td>'.$rows['league'].'</td>';
                                echo '<td>'.$rows['entrada'].'</td>';
                                echo '<td>'.$rows['n_ent'].'</td>';
                                if ($rows['lucro']>0){
                                    echo '<td><span class="tag is-success">'.$rows['lucro'].'</span></td>';
                                } elseif ($rows['lucro']<0){
                                    echo '<td><span class="tag is-danger">'.$rows['lucro'].'</span></td>';
                                } else {
                                    echo '<td>'.$rows['lucro'].'</td>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
        </div>
    </div>
    <?php
        }else{
            include "./inc/error_alert.php";
        }
        $lucro_dia=null;
    ?>
</div>