<?php
	
	# Database connection #
	function connection(){
		$pdo = new PDO('mysql:host=localhost;dbname=pmcb_bet', 'pmcb', 'lp^2Ay]UEwX-');
		return $pdo;
	}


	# verify data #
	function verify_data($filter,$chain){
		if(preg_match("/^".$filter."$/", $chain)){
			return false;
        }else{
            return true;
        }
	}


	# Clear text strings #
	function clean_chain($chain){
		$chain=trim($chain);
		$chain=stripslashes($chain);
		$chain=str_ireplace("<script>", "", $chain);
		$chain=str_ireplace("</script>", "", $chain);
		$chain=str_ireplace("<script src", "", $chain);
		$chain=str_ireplace("<script type=", "", $chain);
		$chain=str_ireplace("SELECT * FROM", "", $chain);
		$chain=str_ireplace("DELETE FROM", "", $chain);
		$chain=str_ireplace("INSERT INTO", "", $chain);
		$chain=str_ireplace("DROP TABLE", "", $chain);
		$chain=str_ireplace("DROP DATABASE", "", $chain);
		$chain=str_ireplace("TRUNCATE TABLE", "", $chain);
		$chain=str_ireplace("SHOW TABLES;", "", $chain);
		$chain=str_ireplace("SHOW DATABASES;", "", $chain);
		$chain=str_ireplace("<?php", "", $chain);
		$chain=str_ireplace("?>", "", $chain);
		$chain=str_ireplace("--", "", $chain);
		$chain=str_ireplace("^", "", $chain);
		$chain=str_ireplace("<", "", $chain);
		$chain=str_ireplace("[", "", $chain);
		$chain=str_ireplace("]", "", $chain);
		$chain=str_ireplace("==", "", $chain);
		$chain=str_ireplace(";", "", $chain);
		$chain=str_ireplace("::", "", $chain);
		$chain=trim($chain);
		$chain=stripslashes($chain);
		return $chain;
	}


	# Function rename photos #
	function rename_photos($name){
		$name=str_ireplace(" ", "_", $name);
		$name=str_ireplace("/", "_", $name);
		$name=str_ireplace("#", "_", $name);
		$name=str_ireplace("-", "_", $name);
		$name=str_ireplace("$", "_", $name);
		$name=str_ireplace(".", "_", $name);
		$name=str_ireplace(",", "_", $name);
		$name=$name."_".rand(0,100);
		return $name;
	}


	# Table pager function #
	function table_pager($page,$Npages,$url,$buttons){
		$table='<nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">';

		if($page<=1){
			$table.='
			<a class="pagination-previous is-disabled" disabled >Anterior</a>
			<ul class="pagination-list">';
		}else{
			$table.='
			<a class="pagination-previous" href="'.$url.($page-1).'" >Anterior</a>
			<ul class="pagination-list">
				<li><a class="pagination-link" href="'.$url.'1">1</a></li>
				<li><span class="pagination-ellipsis">&hellip;</span></li>
			';
		}

		$ci=0;
		for($i=$page; $i<=$Npages; $i++){
			if($ci>=$buttons){
				break;
			}
			if($page==$i){
				$table.='<li><a class="pagination-link is-current" href="'.$url.$i.'">'.$i.'</a></li>';
			}else{
				$table.='<li><a class="pagination-link" href="'.$url.$i.'">'.$i.'</a></li>';
			}
			$ci++;
		}

		if($page==$Npages){
			$table.='
			</ul>
			<a class="pagination-next is-disabled" disabled >Seguinte</a>
			';
		}else{
			$table.='
				<li><span class="pagination-ellipsis">&hellip;</span></li>
				<li><a class="pagination-link" href="'.$url.$Npages.'">'.$Npages.'</a></li>
			</ul>
			<a class="pagination-next" href="'.$url.($page+1).'" >Seguinte</a>
			';
		}

		$table.='</nav>';
		return $table;
	}