<?php
    $inicio = ($pagina>0) ? (($pagina*$registros)-$registros) : 0;
    $tabla="";

    if(isset($busca) && $busca!=""){
        $consulta_dados="SELECT * FROM prog WHERE bet_resultado = 'BACK FORA' and (eq_casa LIKE '%$busca%' OR eq_fora LIKE '%$busca%') AND data >= CURDATE() ORDER BY data ASC,league LIMIT $inicio,$registros";

        $consulta_total="SELECT count(id) FROM prog WHERE bet_resultado = 'BACK FORA' and (eq_casa LIKE '%$busca%' OR eq_fora LIKE '%$busca%') AND data >= CURDATE()";
    }else{
        $consulta_dados="SELECT * FROM prog WHERE bet_resultado = 'BACK FORA' and data >= CURDATE() ORDER BY data ASC,league LIMIT $inicio,$registros";

        $consulta_total="SELECT count(id) FROM prog WHERE bet_resultado = 'BACK FORA' and data >= CURDATE()";
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
                    <th>Odd 1</th>
                    <th>Odd X</th>
                    <th>Odd 2</th>
                    <th colspan="2">Acções</th>
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
                    <td>'.$rows['eq_fora'].'</td>';
                    if ($rows['pos_eq_fora']<=$rows['pos_eq_casa']-5){
                        $tabla.='<td><span class="tag is-success" style="background-color:#2E8B57;color:white;">'.$rows['pos_eq_fora'].'º</span></td>';
                    } elseif  ($rows['pos_eq_fora']<$rows['pos_eq_casa']){
                        $tabla.='<td><span class="tag is-success" style="background-color:#90EE90;color:black;">'.$rows['pos_eq_fora'].'º</span></td>';
                    }else {
                        $tabla.='<td>'.$rows['pos_eq_fora'].'º</td>';
                    }                              
            $tabla.='
                    <td>'.$rows['pos_eq_casa_home'].'º</td>';
                    if ($rows['pos_eq_fora_away']<=5)
                    {
                        $tabla.='<td><span class="tag is-success" style="background-color:#C0C0C0;color:black;">'.$rows['pos_eq_fora_away'].'º</span></td>';
                    } else {
                        $tabla.='<td>'.$rows['pos_eq_fora_away'].'º</td>';
                    }
                    
                    $tabla.='<td>'.$rows['eq_home_EXP'].'</td>';
                    
                    if ($rows['eq_away_EXP']>$rows['eq_home_EXP'])
                    {
                        $tabla.='<td><span class="tag is-success" style="background-color:#C0C0C0;color:black;">'.$rows['eq_away_EXP'].'</span></td>';
                    } else {
                        $tabla.='<td>'.$rows['eq_away_EXP'].'</td>';
                    }
                    
                    $tabla.='<td>'.$rows['prob_1'].'%</td>
                    <td>'.$rows['prob_x'].'%</td> 
                    ';
                    if ($rows['prob_2']>=50 && $rows['prob_2']<70){
                        $tabla.='<td><span class="tag is-success" style="background-color:#00FF00;color:black;">'.$rows['prob_2'].'%</span></td>';
                    }
                    if ($rows['prob_2']>=70 && $rows['prob_2']<90){
                        $tabla.='<td><span class="tag is-success" style="background-color:#32CD32;">'.$rows['prob_2'].'%</span></td>';
                    }
                    if ($rows['prob_2']>=90 && $rows['prob_2']<=100){
                        $tabla.='<td><span class="tag is-success" style="background-color:#006400;">'.$rows['prob_2'].'%</span></td>';
                    }
                          
                    $consulta_odd="select Odd_H,Odd_D,Odd_A from jogos where Home = (select team_fs from equipas where team_ss = '".$rows['eq_casa']."') and Away = (select team_fs from equipas where team_ss = '".$rows['eq_fora']."')";                    
                    $connection_v2=connection_v2();                    
                    $odds=$connection_v2->query($consulta_odd);
                    $odds=$odds->fetch();
                    $tabla.='<td>'.$odds['Odd_H'].'</td><td>'.$odds['Odd_D'].'</td><td>'.$odds['Odd_A'].'</td>';
            $tabla.='            
                    <td>
                        <a href="index.php?vista=back_fora_bet&id_up='.$rows['id'].'" class="button is-success is-rounded is-small">Apostar</a>
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