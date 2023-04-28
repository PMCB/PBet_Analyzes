<div class="main-container">

    <form class="box login" action="" method="POST" autocomplete="off">
      <img src="./img/logo2.png" width="112" height="28" style="display:block;margin-left:auto;margin-right:auto;width:100%;height:100%">

		<!--<h5 class="title is-5 has-text-centered is-uppercase">PBET ANALYZES</h5>-->

		<div class="field">
			<label class="label">User</label>
			<div class="control">
			    <input class="input" type="text" name="login_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required >
			</div>
		</div>

		<div class="field">
		  	<label class="label">Senha</label>
		  	<div class="control">
		    	<input class="input" type="password" name="login_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required >
		  	</div>
		</div>

		<p class="has-text-centered mb-4 mt-3">
			<button type="submit" class="button is-info is-rounded">Iniciar Sessão 2</button>
		</p>

		<?php
			if(isset($_POST['login_usuario']) && isset($_POST['login_clave'])){
				require_once "./php/main.php";
				require_once "./php/start_session.php";
			}	
		?>

	</form>

</div>