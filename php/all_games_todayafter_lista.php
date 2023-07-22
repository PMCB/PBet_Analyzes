<?php
    $inicio = ($pagina>0) ? (($pagina*$registros)-$registros) : 0;
    $tabla="";

    if(isset($busca) && $busca!=""){
        $consulta_dados="SELECT * FROM prog WHERE (eq_casa LIKE '%$busca%' OR eq_fora LIKE '%$busca%') AND data >= CURDATE() ORDER BY data ASC,league LIMIT $inicio,$registros";

        $consulta_total="SELECT count(id) FROM prog WHERE (eq_casa LIKE '%$busca%' OR eq_fora LIKE '%$busca%') AND data >= CURDATE()";
    }else{
        $consulta_dados="SELECT * FROM prog WHERE data >= CURDATE() ORDER BY data ASC,league LIMIT $inicio,$registros";

        $consulta_total="SELECT count(id) FROM prog WHERE bdata >= CURDATE()";
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
                    <th>Odd Yes</th>
                    <th>Odd No</th>
                    <th>1</th>
                    <th>X</th>
                    <th>2</th>
                    <th>Odd 1</th>
                    <th>Odd X</th>
                    <th>Odd 2</th>
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
                    <td>'.$rows['eq_home_EXP'].'</span></td>
                    <td>'.$rows['eq_away_EXP'].'</span></td>
                    <td>'.$rows['btts_yes'].'%</span></td>';
 
                    //
                    $consulta_odd="select Odd_BTTS_Yes,Odd_BTTS_No from jogos where Home = (select team_fs from equipas where team_ss = '".$rows['eq_casa']."') and Away = (select team_fs from equipas where team_ss = '".$rows['eq_fora']."')";                    
                    $connection_v2=connection_v2();                    
                    $odds=$connection_v2->query($consulta_odd);
                    $odds=$odds->fetch();
                    $tabla.='<td>'.$odds['Odd_BTTS_Yes'].'</td><td>'.$odds['Odd_BTTS_No'].'</td>';

                    $tabla.='<td>'.$rows['prob_1'].'%</span></td>
                    <td>'.$rows['prob_x'].'%</td> 
                    <td>'.$rows['prob_2'].'%</td>';
                    $tabla.='<td>'.$odds['Odd_H'].'</td><td>'.$odds['Odd_D'].'</td><td>'.$odds['Odd_A'].'</td>';

                               
            $tabla.='             
                    <td>
                        <a href="index.php?vista=btts_m_bet&id_up='.$rows['id'].'" class="button is-success is-rounded is-small">Apostar</a>
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