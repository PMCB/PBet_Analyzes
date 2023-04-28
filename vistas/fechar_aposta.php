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

			$data=$dados['data'];
			$eq_casa=$dados['team_home'];
			$eq_fora=$dados['team_away'];

			$check_goals=connection();
			$check_goals=$check_goals->query("SELECT * FROM prog WHERE data ='$data' and eq_casa='$eq_casa' and eq_fora='$eq_fora'");	

			if ($check_goals->rowCount()>0){ 
				$goals=$check_goals->fetch();
			}

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
			<?php
			if ($goals['resultado']!="") { ?>
			  	<div class="column">
		    		<div class="control">			  	
                    	<h2 class="title"><?php echo $goals['golos_casa'] ." - ".$goals['golos_fora']; ?></h2>
					</div>
		  		</div>
			<?php } ?>
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
            <div class="column">
		    	<div class="control">
                    <h2><strong>Entrada</strong></h2>
                    <label><?php echo $dados['entrada'];?></label>
				</div>                
		  	</div>
            <div class="column">
		    	<div class="control">
                    <h2><strong>Casa</strong></h2>
                    <label><?php echo $dados['casa_ap'];?></label>
				</div>                
		  	</div>



		</div>
		<div class="columns">
            <div class="column">
		    	<div class="control">
                    <h2><strong>Odd</strong></h2>
                    <label><?php echo $dados['odd'];?></label>
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
						<option value="">---</option>
						<option value="green">GREEN</option>						
						<option value="void">VOID</option>
						<option value="red">RED</option>
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