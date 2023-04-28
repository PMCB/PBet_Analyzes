<?php
    require_once "./php/main.php";

    $id=(isset($_GET['id_up'])) ? $_GET['id_up'] : 0;
    $id=clean_chain($id);
?>
<div class="container is-fluid mb-6">
        <h1 class="title">Aposta</h1>        
</div>

<div class="container pb-6 pt-6">
    <?php
        include "./inc/btn_back.php";

        $check_game=connection();
        $check_game=$check_game->query("SELECT * FROM prog WHERE id='$id'");

        if ($check_game->rowCount()>0){ 
            $dados=$check_game->fetch();

    ?>
	<div class="form-rest mb-6 mt-6"></div>

	<form action="./php/bet.php" method="POST" class="FormularioAjax" autocomplete="off" >

		<input type="hidden" value="<?php echo $dados['id']; ?>" name="id" required >
		<input type="hidden" value="<?php echo $dados['data']; ?>" name="data" required >
		<input type="hidden" value="PRE LIVE" name="tipo" required >
		<input type="hidden" value="<?php echo $dados['league']; ?>" name="league" required >
		<input type="hidden" value="DNB" name="mercado" required >
					
		
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Equipa Casa</label>
				  	<input class="input" type="text" name="team_home" value="<?php echo $dados['eq_casa']; ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" readonly="readonly" required>
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Equipa Casa</label>
				  	<input class="input" type="text" name="team_away" value="<?php echo $dados['eq_fora']; ?>" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" readonly="readonly" >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Método</label>
				  	<input class="input" type="text" name="metodo" value="Casa/Empate" pattern="[a-zA-Z0-9]{4,20}" readonly="readonly" >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Casa</label>
					<br>
					<select id="casa_ap" name="casa_ap">
						<option value="">---</option>
						<option value="Betano">Betano</option>
						<option value="BetClic">BetClic</option>
						<option value="EscOnline">EscOnline</option>
					</select>
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
				<label><strong>Entrada</strong></label>
				<br>
					<select id="entrada" name="entrada">
						<option value="">---</option>
						<option value="DNB 1">DNB 1</option>
						<option value="DNB 2">DNB 2</option>
					</select>
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Odd</label>
					<input class="input" name="odd" type="number" min=1 step=0.01 >					
				</div>
		  	</div>
		</div>
		<br><br>		
		<p class="has-text-centered">
			<button type="submit" class="button is-success is-rounded">Apostar</button>
		</p>
	</form>
    <?php
        }else{
            include "./inc/error_alert.php";
        }
        $check_game=null;
    ?>
</div>