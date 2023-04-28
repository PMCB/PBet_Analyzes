<?php
    $inicio = ($pagina>0) ? (($pagina*$registros)-$registros) : 0;

    $tabla="";

    if(isset($busca) && $busca!=""){
        $consulta_dados="SELECT * FROM users WHERE ((user_id != '".$_SESSION['id']."') AND (nome LIKE '%$busca%' OR apelido LIKE '%$busca%' OR user LIKE '%$busca%' OR email LIKE '%$busca%')) ORDER BY nome ASC LIMIT $inicio,$registros";

        $consulta_total="SELECT count(user_id) FROM users WHERE ((user_id != '".$_SESSION['id']."') AND (nome LIKE '%$busca%' OR apelido LIKE '%$busca%' OR user LIKE '%$busca%' OR email LIKE '%$busca%'))";
    }else{
        $consulta_dados="SELECT * FROM users WHERE user_id != '".$_SESSION['id']."' ORDER BY nome ASC LIMIT $inicio,$registros";

        $consulta_total="SELECT count(user_id) FROM users WHERE user_id != '".$_SESSION['id']."'";
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
                    <th>#</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th colspan="2">Opciones</th>
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
					<td>'.$contador.'</td>
                    <td>'.$rows['nome'].'</td>
                    <td>'.$rows['apelido'].'</td>
                    <td>'.$rows['user'].'</td>
                    <td>'.$rows['email'].'</td>
                    <td>
                        <a href="index.php?vista=user_update&user_id_up='.$rows['user_id'].'" class="button is-success is-rounded is-small">Actualizar</a>
                    </td>
                    <td>
                        <a href="'.$url.$pagina.'&user_id_del='.$rows['user_id'].'" class="button is-danger is-rounded is-small">Eliminar</a>
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
                <td colspan="7">
                    <a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
                        Haga clic acá para recargar el listado
                    </a>
                </td>
            </tr>
            ';
        }else{
            $tabla.='
            <tr class="has-text-centered" >
                <td colspan="7">
                    No hay registros en el sistema
                </td>
            </tr>
            ';
        }
     }

     
     $tabla.='</tbody></table></div>';
     if($total>=1 && $pagina<=$Npaginas){
        $tabla.='<p class="has-text-right">Mostrando usuarios <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
     }
     

     $connection=null;
     echo $tabla;

     if($total>=1 && $pagina<=$Npaginas){
        echo table_pager($pagina,$Npaginas,$url,7);
     }
