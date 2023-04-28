<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="index.php?vista=home">
      <img src="./img/logo.png" width="112" height="28">
    </a>

    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarBasicExample" class="navbar-menu">
    <div class="navbar-start">

      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">Users</a>

        <div class="navbar-dropdown">
          <a class="navbar-item" href="index.php?vista=user_new">Novo</a>          
          <a class="navbar-item" href="index.php?vista=user_list">Lista</a>     
          <a class="navbar-item" href="index.php?vista=user_search">Pesquisar</a>     
        </div>
      </div>  
      
      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">Jogos</a>

        <div class="navbar-dropdown">
          <a class="navbar-item" href="index.php?vista=total_games">Todos</a>
          <a class="navbar-item" href="index.php?vista=today_games">Hoje</a>
          <a class="navbar-item" href="index.php?vista=tomorrow_games">Amanhã</a>
          <a class="navbar-item" href="index.php?vista=after_tomorrow_games">Depois de Amanhã</a>
        </div>
      </div>

      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">Apostas</a>

        <div class="navbar-dropdown">
          <a class="navbar-item" href="index.php?vista=apostas_open">Abertas</a>
          <a class="navbar-item" href="index.php?vista=apostas_closed">Fechadas</a>
          <a class="navbar-item" href="index.php?vista=apostas_all">Todas</a>
          <a class="navbar-item" href="index.php?vista=apostas_analise">Analise</a>
        </div>
      </div> 
      
      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">Banca</a>

        <div class="navbar-dropdown">
          <a class="navbar-item" href="index.php?vista=banca_analise">Analises</a>
        </div>
      </div>      
    </div>
    </div>



    <div class="navbar-end">
      <div class="navbar-item">
        <div class="buttons">
          <a href="index.php?vista=user_update&user_id_up=<?php echo $_SESSION['id'];?>" class="button is-primary is-rounded">
            Minha Conta
          </a>
          <a href="index.php?vista=logout" class="button is-link is-rounded">
            Sair
          </a>
        </div>
      </div>
    </div>
  </div>
</nav>