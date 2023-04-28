<?php
    $inicio = ($pagina>0) ? (($pagina*$registros)-$registros) : 0;
    $tabla="";

    if(isset($busca) && $busca!=""){
        $consulta_dados="SELECT * FROM prog WHERE bet_resultado = 'FORA OU EMPATE' and (eq_casa LIKE '%$busca%' OR eq_fora LIKE '%$busca%') AND data >= CURDATE() ORDER BY data ASC,league LIMIT $inicio, $registros";

        $consulta_total="SELECT count(id) FROM prog WHERE bet_resultado = 'FORA OU EMPATE' and (eq_casa LIKE '%$busca%' OR eq_fora LIKE '%$busca%') AND data >= CURDATE()";
    }else{
        $consulta_dados="SELECT * FROM prog WHERE bet_resultado = 'FORA OU EMPATE' and data >= CURDATE() ORDER BY data ASC,league LIMIT $inicio, $registros";

        $consulta_total="SELECT count(id) FROM prog WHERE bet_resultado = 'FORA OU EMPATE' and data >= CURDATE()";
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
                    <th>C/C</th>
                    <th>F/F</th>
                    <th>Xg Casa</th>
                    <th>Xg Fora</th>
                    <th>1</th>
                    <th>X</th>
                    <th>2</th>
                    <th>Acções</th>
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
                    <td>'.$rows['pos_eq_casa'].'º</td>
                    <td>'.$rows['eq_casa'].'</td>
                    <td>'.$rows['eq_fora'].'</td>
                    <td>'.$rows['pos_eq_fora'].'º</td>
                    <td>'.$rows['pos_eq_casa_home'].'º</td>
                    <td>'.$rows['pos_eq_fora_away'].'º</td>                    
                    <td>'.$rows['eq_home_EXP'].'</td>
                    <td>'.$rows['eq_away_EXP'].'</td>
                    <td>'.$rows['prob_1'].'%</td>';
                    if ($rows['prob_x']>=50 && $rows['prob_x']<70){
                        $tabla.='<td><span class="tag is-success" style="background-color:#00FF00;color:black;">'.$rows['prob_x'].'%</span></td>';
                    }
                    elseif ($rows['prob_x']>=70 && $rows['prob_x']<90){
                        $tabla.='<td><span class="tag is-success" style="background-color:#32CD32;">'.$rows['prob_x'].'%</span></td>';
                    }
                    elseif ($rows['prob_x']>=90 && $rows['prob_x']<=100){
                        $tabla.='<td><span class="tag is-success" style="background-color:#006400;">'.$rows['prob_x'].'%</span></td>';
                    } else {
                        $tabla.='<td>'.$rows['prob_x'].'%</td>';
                    }

                    if ($rows['prob_2']>=50 && $rows['prob_2']<70){
                        $tabla.='<td><span class="tag is-success" style="background-color:#00FF00;color:black;">'.$rows['prob_2'].'%</span></td>';
                    }
                    elseif ($rows['prob_2']>=70 && $rows['prob_2']<90){
                        $tabla.='<td><span class="tag is-success" style="background-color:#32CD32;">'.$rows['prob_2'].'%</span></td>';
                    }
                    elseif ($rows['prob_2']>=90 && $rows['prob_2']<=100){
                        $tabla.='<td><span class="tag is-success" style="background-color:#006400;">'.$rows['prob_2'].'%</span></td>';
                    } else {
                        $tabla.='<td>'.$rows['prob_2'].'%</td>';
                    }
                               
            $tabla.='      
                    <td>                        
                        <a href="index.php?vista=fora_empate_bet&id_up='.$rows['id'].'" class="button is-success is-rounded is-small">Apostar</a>
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
                <td colspan="12">
                    <a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
                    Clique aqui para recarregar a lista
                    </a>
                </td>
            </tr>
            ';
        }else{
            $tabla.='
            <tr class="has-text-centered" >
                <td colspan="12">
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