<?php
    $inicio = ($pagina>0) ? (($pagina*$registros)-$registros) : 0;
    $tabla="";

    if(isset($busca) && $busca!=""){
        $consulta_dados="SELECT * FROM apostas WHERE (team_home LIKE '%$busca%' OR team_away LIKE '%$busca%') AND status is null ORDER BY data ASC,league LIMIT $inicio,$registros";

        $consulta_total="SELECT count(id) FROM apostas WHERE (team_home LIKE '%$busca%' OR team_away LIKE '%$busca%') AND status is null";
    }else{
        $consulta_dados="SELECT * FROM apostas WHERE status is null ORDER BY data ASC,league LIMIT $inicio,$registros";

        $consulta_total="SELECT count(id) FROM apostas WHERE status is null";
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
                    <th>PRÉ / LIVE</th>
                    <th>Liga</th>
                    <th>Jogo</th>
                    <th>Mercado</th>
                    <th>Entrada</th>
                    <th>Odd</th>
                    <th>Casa de Aposta</th>
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
                    <td>'.$rows['tipo'].'</td>
                    <td>'.$rows['league'].'</td>
                    <td>'.$rows['team_home'].' - '.$rows['team_away'].'</td>
                    <td>'.$rows['mercado'].'</td>
                    <td>'.$rows['entrada'].'</td>
                    <td>'.$rows['odd'].'</td>
                    <td>'.$rows['casa_ap'].'</td>    
                    <td>
                    <a href="index.php?vista=fechar_aposta&id='.$rows['id'].'" class="button is-success is-outlined is-rounded is-small">Fechar</a>
                </td>                        
                    <td>
                        <a href="index.php?vista=update_aposta&id='.$rows['id'].'" class="button is-success is-rounded is-small">Actualizar</a>
                        <a href="'.$url.$pagina.'&id_del='.$rows['id'].'" class="button is-danger is-rounded is-small">Eliminar</a>
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
                <td colspan="9">
                    <a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
                    Clique aqui para recarregar a lista
                    </a>
                </td>
            </tr>
            ';
        }else{
            $tabla.='
            <tr class="has-text-centered" >
                <td colspan="9">
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