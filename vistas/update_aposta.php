<?php
    require_once "./php/main.php";

    $id=(isset($_GET['id'])) ? $_GET['id'] : 0;
    $id=clean_chain($id);
?>
<div class="container is-fluid mb-6">
        <h1 class="title">Aposta</h1>        
</div>

<div class="container pb-6 pt-6">
    <?php
        include "./inc/btn_back.php";

        $check_game=connection();
        $check_game=$check_game->query("SELECT * FROM apostas WHERE id='$id'");

        if ($check_game->rowCount()>0){ 
            $dados=$check_game->fetch();

    ?>
	<div class="form-rest mb-6 mt-6"></div>

	<form action="./php/status_aposta.php" method="POST" class="FormularioAjax" autocomplete="off" >

		<input type="hidden" value="<?php echo $dados['id']; ?>" name="id" required >
		<input type="hidden" value="<?php echo $dados['data']; ?>" name="data" required >
		<input type="hidden" value="<?php echo $dados['tipo']; ?>" name="tipo" required >
		<input type="hidden" value="<?php echo $dados['league']; ?>" name="league" required >
		<input type="hidden" value="<?php echo $dados['mercado']; ?>" name="mercado" required >
		<input type="hidden" value="<?php echo $dados['entrada']; ?>" name="entrada" required >
        <input type="hidden" value="<?php echo $dados['team_home']; ?>" name="team_home" required >
        <input type="hidden" value="<?php echo $dados['team_away']; ?>" name="team_away" required >
        <input type="hidden" value="<?php echo $dados['metodo']; ?>" name="metodo" required >
		
		<div class="columns">
		  	<div class="column">
		    	<div class="control">			  	
                    <h1 class="title"><?php echo $dados['team_home'] ." - ".$dados['team_away']; ?></h1>
				</div>
		  	</div>
		</div>



        <div class="columns">
		  	<div class="column">
		    	<div class="control">
                    <h2><strong>Data</strong></h2>
                    <label><?php echo $dados['data'];?></label>
				</div>                
		  	</div>
            <div class="column">
		    	<div class="control">
                    <h2><strong>Tipo</strong></h2>
                    <label><?php echo $dados['tipo'];?></label>
				</div>                
		  	</div>
            <div class="column">
		    	<div class="control">
                    <h2><strong>Campeonato</strong></h2>
                    <label><?php echo $dados['league'];?></label>
				</div>                
		  	</div>
		</div> 



		<div class="columns">
		  	<div class="column">
		    	<div class="control">
                    <h2><strong>Mercado</strong></h2>
                    <label><?php echo $dados['mercado'];?></label>
				</div>                
		  	</div>

            <?php
            if($dados['mercado']=="OVER FT"){
                echo '<div class="column">
		    	<div class="control">
				<label><strong>Entrada</strong></label>				
				<br>
					<select id="entrada" name="entrada">';
                    if($dados['entrada'] == ""){
                        echo '<option value="" selected="selected">---</option>';
                    }else{
                        echo '<option value="">---</option>';
                    }

                    if ($dados['entrada'] == "Over 2,5 FT"){
                        echo '<option value="Over 2,5 FT" selected="selected">Over 2,5 FT</option>';
                    }else{
                        echo '<option value="Over 2,5 FT">Over 2,5 FT</option>';
                    }
                    
                    if ($dados['entrada'] == "Under 2,5 FT"){
                        echo '<option value="Under 2,5 FT" selected="selected">Under 2,5 FT</option>';
                    }else{
                        echo '<option value="Under 2,5 FT">Under 2,5 FT</option>';
                    }
				echo'</select>
                </div>
                </div>';
            }elseif ($dados['mercado']=="BTTS"){
                echo '<div class="column">
		    	<div class="control">
					<label>Entrada</label>
					<br>
					<select id="entrada" name="entrada">';
                    if($dados['entrada'] == ""){
                        echo '<option value="" selected="selected">---</option>';
                    }else{
                        echo '<option value="">---</option>';
                    }

                    if($dados['entrada'] == "BTTS Yes"){
                        echo '<option value="BTTS Yes" selected="selected">BTTS Yes</option>';
                    }else{
                        echo '<option value="BTTS Yes">BTTS Yes</option>';
                    }

                    if($dados['entrada'] == "BTTS No"){
                        echo '<option value="BTTS No" selected="selected">BTTS No</option>';
                    }else{
                        echo '<option value="BTTS No">BTTS No</option>';
                    }
				echo '</select>
				</div>
		  	</div>';
            }else{
                echo '<div class="column">
		        <div class="control">
                    <h2><strong>Entrada</strong></h2>
                    <label>'.$dados['entrada'].'</label>
			    </div>                
		  	    </div>';
            }
            ?>

		  	<div class="column">
		    	<div class="control">
					<label><strong>Casa</strong></label>
					<br>
					<select id="casa_ap" name="casa_ap">
                    <?php 
                        if ($dados['casa_ap'] == ""){
                            echo '<option value="" selected="selected">---</option>';
                        }else{
                            echo '<option value="">---</option>';
                        }
                        if ($dados['casa_ap'] == "Betano"){
                            echo '<option value="Betano" selected="selected">Betano</option>';
                        }else{
                            echo '<option value="Betano">Betano</option>';
                        }
                        if ($dados['casa_ap'] == "BetClic"){
                            echo '<option value="BetClic" selected="selected">BetClic</option>';
                        }else{
                            echo '<option value="BetClic">BetClic</option>';
                        }
                        if ($dados['casa_ap'] == "EscOnline"){
                            echo '<option value="EscOnline" selected="selected">EscOnline</option>';
                        }else{
                            echo '<option value="EscOnline">EscOnline</option>';
                        }
                    ?>
					</select>
				</div>
		  	</div>



		</div>
		<div class="columns">
            <div class="column">
		    	<div class="control">
                    <h2><strong>Odd</strong></h2>
                    <?php
                    echo '<input class="input" value="'.$dados['odd'].'" name="odd" type="number" min=1 step=0.01 >';
                    ?>                    
				</div>                
		  	</div>
            <div class="column">
		    	<div class="control">
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
                    <h2><strong>Status</strong></h2>
					<select id="status" name="status">
                    <?php 
                        if ($dados['status'] == ""){
                            echo '<option value="" selected="selected">---</option>';
                        }else{
                            echo '<option value="">---</option>';
                        }
                        if ($dados['status'] == "green"){
                            echo '<option value="green" selected="selected">GREEN</option>';
                        }else{
                            echo '<option value="green">GREEN</option>';
                        }
                        if ($dados['status'] == "void"){
                            echo '<option value="void" selected="selected">VOID</option>';
                        }else{
                            echo '<option value="void">VOID</option>';
                        }
                        if ($dados['status'] == "red"){
                            echo '<option value="red" selected="selected">RED</option>';
                        }else{
                            echo '<option value="red">RED</option>';
                        }
                    ?>
					</select>
				</div>
		  	</div>
		</div>
		<br><br>		
		<p class="has-text-centered">
			<button type="submit" class="button is-success is-rounded">Fechar</button>
		</p>
	</form>
    <?php
        }else{
            include "./inc/error_alert.php";
        }
        $check_game=null;
    ?>
</div>