<?php
    $inicio = ($pagina>0) ? (($pagina*$registros)-$registros) : 0;
    $tabla="";

    if(isset($busca) && $busca!=""){
        $consulta_dados="SELECT * FROM prog WHERE (eq_casa LIKE '%$busca%' OR eq_fora LIKE '%$busca%') AND data >= CURDATE() AND pos_eq_casa < pos_eq_fora-5 ORDER BY data ASC,league LIMIT $inicio,$registros";

        $consulta_total="SELECT count(id) FROM prog WHERE (eq_casa LIKE '%$busca%' OR eq_fora LIKE '%$busca%') AND data >= CURDATE() AND pos_eq_casa < pos_eq_fora-5";
    }else{
        $consulta_dados="SELECT * FROM prog WHERE data >= CURDATE() AND pos_eq_casa < pos_eq_fora-5 ORDER BY data ASC,league LIMIT $inicio,$registros";

        $consulta_total="SELECT count(id) FROM prog WHERE data >= CURDATE() AND pos_eq_casa < pos_eq_fora-5";
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
                    <th>% Over 2,5</th>
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
                    ';
                    if ($rows['pos_eq_casa']<=$rows['pos_eq_fora']-5){
                        $tabla.='<td><span class="tag is-success" style="background-color:#2E8B57;color:white;">'.$rows['pos_eq_casa'].'º</span></td>';
                    } elseif  ($rows['pos_eq_casa']<$rows['pos_eq_fora']){
                        $tabla.='<td><span class="tag is-success" style="background-color:#90EE90;color:black;">'.$rows['pos_eq_casa'].'º</span></td>';
                    }else {
                        $tabla.='<td>'.$rows['pos_eq_casa'].'º</td>';
                    }                              
            $tabla.='
                    <td>'.$rows['eq_casa'].'</td>
                    <td>'.$rows['eq_fora'].'</td>
                    <td>'.$rows['pos_eq_fora'].'</td>
                    <td>'.$rows['pos_eq_casa_home'].'º</td>
                    <td>'.$rows['pos_eq_fora_away'].'º</td> ';

                    if ($rows['eq_home_EXP']>$rows['eq_away_EXP']){
                        $tabla.='<td><span class="tag is-success" style="background-color:#C0C0C0;color:black;">'.$rows['eq_home_EXP'].'</span></td>';
                    } else {
                        $tabla.='<td>'.$rows['eq_home_EXP'].'</td>';
                    }



                    $tabla.='<td>'.$rows['eq_away_EXP'].'</td>';
                    if ($rows['O25']>=50 && $rows['O25']<70){
                        $tabla.='<td><span class="tag is-success" style="background-color:#00FF00;color:black;">'.$rows['O25'].'%</span></td>';
                    }
                    elseif  ($rows['O25']>=70 && $rows['O25']<90){
                        $tabla.='<td><span class="tag is-success" style="background-color:#32CD32;">'.$rows['O25'].'%</span></td>';
                    }
                    elseif  ($rows['O25']>=90 && $rows['O25']<=100){
                        $tabla.='<td><span class="tag is-success" style="background-color:#006400;">'.$rows['O25'].'%</span></td>';
                    } else {
                        $tabla.='<td>'.$rows['O25'].'%</td>';
                    }
                               
            $tabla.='            
                    <td>
                        <a href="index.php?vista=best_casa_bet&id_up='.$rows['id'].'" class="button is-success is-rounded is-small">Apostar</a>
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
                <td colspan="11">
                    <a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
                    Clique aqui para recarregar a lista
                    </a>
                </td>
            </tr>
            ';
        }else{
            $tabla.='
            <tr class="has-text-centered" >
                <td colspan="11">
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