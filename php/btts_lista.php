<?php
    $inicio = ($pagina>0) ? (($pagina*$registros)-$registros) : 0;
    $tabla="";

    if(isset($busca) && $busca!=""){
        $consulta_dados="SELECT * FROM prog WHERE btts_resultado = 'BET' AND (eq_casa LIKE '%$busca%' OR eq_fora LIKE '%$busca%') AND data >= CURDATE() ORDER BY data ASC,league LIMIT $inicio,$registros";

        $consulta_total="SELECT count(id) FROM prog WHERE btts_resultado = 'BET' AND (eq_casa LIKE '%$busca%' OR eq_fora LIKE '%$busca%') AND data >= CURDATE()";
    }else{
        $consulta_dados="SELECT * FROM prog WHERE btts_resultado = 'BET' AND data >= CURDATE() ORDER BY data ASC,league LIMIT $inicio,$registros";

        $consulta_total="SELECT count(id) FROM prog WHERE btts_resultado = 'BET' AND data >= CURDATE()";
    }

    $connection=connection();

    $dados=$connection->query($consulta_dados);
    $dados=$dados->fetchAll();

    $total=$connection->query($consulta_total);
    $total=(int) $total-> fetchColumn();

    $Npaginas=ceil($total/$registros);

    $tabla.='
        <div class="table-container">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr class="has-text-centered">
                    <th>Data</th>
                    <th>Liga</th>
                    <th></th>
                    <th>Casa</th>
                    <th>Fora</th>
                    <th></th>
                    <th>Xg Casa</th>
                    <th>Xg Fora</th>
                    <th>% BTTS</th>
                    <th>Acções</th>
                    <th>Análise</th>
                </tr>
            </thead>
            <tbody>
    ';

    if($total>=1 && $pagina<=$Npaginas){
        $contador=$inicio+1;
        $pag_inicio=$inicio+1;
        foreach($dados as $rows){
            $tabla.='
                <tr class="has-text-centered" >
                    <td>'.$rows['data'].'</td>
                    <td>'.$rows['league'].'</td>
                    <td>'.$rows['pos_eq_casa'].'</td>
                    <td>'.$rows['eq_casa'].'</td>
                    <td>'.$rows['eq_fora'].'</td>
                    <td>'.$rows['pos_eq_fora'].'</td>
                    <td>'.$rows['eq_home_EXP'].'</td>
                    <td>'.$rows['eq_away_EXP'].'</td>
                    <td>'.$rows['btts_yes'].'%</td>             
                    <td>
                        <a href="index.php?vista=btts_bet.php&id='.$rows['id'].'" class="button is-success is-rounded is-small">Apostar</a>
                    </td>
                    <td>
                        <a href="index.php?vista=analise_jogo&id_up='.$rows['id'].'" class="button is-danger is-outlined is-small">Análise</a>
                    </td>
                </tr>
            ';
            $contador++;
        }
        $pag_final=$contador-1;
     }else{
        if($total>=1){
            $tabla.='
            <tr class="has-text-centered" >
                <td colspan="10">
                    <a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
                    Clique aqui para recarregar a lista
                    </a>
                </td>
            </tr>
            ';
        }else{
            $tabla.='
            <tr class="has-text-centered" >
                <td colspan="10">
                Não há registros no sistema
                </td>
            </tr>
            ';
        }
     }

     
     $tabla.='</tbody></table></div>';
     if($total>=1 && $pagina<=$Npaginas){
        $tabla.='<p class="has-text-right">Jogos de <strong>'.$pag_inicio.'</strong> até <strong>'.$pag_final.'</strong> de um <strong>total de '.$total.'</strong></p>';
     }
     

     $connection=null;
     echo $tabla;

     if($total>=1 && $pagina<=$Npaginas){
        echo table_pager($pagina,$Npaginas,$url,7);
     }