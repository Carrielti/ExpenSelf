<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    echo "<script>alert('Acesso negado. Faça login!'); window.location.href='index.html';</script>";
}

$nome = $_SESSION['nome']; // <- Aqui define corretamente a variável $nome
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>ExpenSelf - Home</title>
  <link rel="stylesheet" href="style.css"/>
  <link rel="icon" href="/img/icone-logo.png" type="image/png">

</head>

<body>
  <div class="top-bar">
  <!-- Menu hamburguer + navegação -->
  <div class="menu-container">
    <div class="hamburguer" id="hamburguer">
      <div class="bar"></div>
      <div class="bar"></div>
      <div class="bar"></div>
    </div>
    <nav id="nav-menu" class="nav-menu">
      <ul>
        <li><a href="e_home.php">Home</a></li><br>
        <li><a href="listar_despesas.php">Despesas</a></li><br>
        <li><a href="e_sobre.php">Sobre</a></li><br>
        <li><a href="e_contato.php">Contato</a></li><br>
      </ul>
    </nav>
  </div>

  <!-- Logo centralizada -->
  <div class="logo-container">
    <img class="logo-img" src="/img/logo.png" alt="Logo">
  </div>

  <!-- Ícone de usuário à direita -->
  <div class="user-container">
    <div class="user-circle" onclick="toggleUserMenu()" title="Ver informações">
      <img src="/img/user.png" alt="Usuário">
    </div>
    <div class="user-dropdown" id="userDropdown">
      <p><strong><?php echo htmlspecialchars($nome); ?></strong></p>
      <a href="logout.php">Logout</a>
    </div>
  </div>
</div>

  
  <!-- Círculos de categorias -->
  <div class="circles-container">
    <div class="circle" onclick="destacarDespesa('Aluguel')" title="Aluguel">
      <img src="/img/house.png" alt="Aluguel">
    </div>
    <div class="circle" onclick="destacarDespesa('Mercado')" title="Mercado">
      <img src="/img/mercado.png" alt="Aluguel">
      
    </div>
    <div class="circle" onclick="destacarDespesa('Transporte')" title="Transporte">
      <img src="/img/transporte.png" alt="Aluguel">
      
    </div>
    <div class="circle" onclick="destacarDespesa('Energia')" title="Energia">
      <img src="/img/energia.png" alt="Aluguel">
      
    </div>
    <div class="circle" onclick="destacarDespesa('Água')" title="Água">
      <img src="/img/water.png" alt="Aluguel">
      
    </div>
    <div class="circle" onclick="destacarDespesa('Internet')" title="Internet">
      <img src="/img/wifi.png" alt="Aluguel">
      
    </div>
    <div class="circle" onclick="destacarDespesa('Educação')" title="Educação">
      <img src="/img/educacao.png" alt="Aluguel">
      
    </div>
    <div class="circle" onclick="destacarDespesa('Saúde')" title="Saúde">
      
      <img src="/img/saude.png" alt="Aluguel">
    </div>
    <div class="circle" onclick="destacarDespesa('Lazer')" title="Lazer">
      
      <img src="/img/jogos.png" alt="Aluguel">
    </div>
    <div class="circle" onclick="destacarDespesa('Celular')" title="Celular">
      <img src="/img/smartphone.png" alt="Aluguel">
      
    </div>
    <div class="circle" onclick="destacarDespesa('Farmácia')" title="Farmácia">
      
      <img src="/img/medicine.png" alt="Aluguel">
    </div>
    <div class="circle" onclick="destacarDespesa('Roupas')" title="Roupas">
      <img src="/img/roupas.png" alt="Aluguel">
      
    </div>
    <div class="circle" onclick="window.location.href='listar_despesas.php'" title="Saiba Mais">
  <img src="/img/pontos.png" alt="Saiba Mais">
</div>

  </div>

  

  <!-- Gráfico -->
  <div class="graph-section">
    <h2>Resumo Visual dos Seus Gastos</h2>
    <img src="/img/grafico.png?<?php echo time(); ?>" alt="Gráfico de despesas" class="grafico-img">
    <form action="gerar_grafico.php" method="POST">
      <button type="submit" class="botao-atualizar">Atualizar Gráfico</button>
    </form>
  </div>

  <script src="script.js"></script>


</body>

<footer>
			<hr>
		<h4>Contato:</h4>
		<ul>
		   <li>
		    <a href="https://api.whatsapp.com/send/?phone=5515991592555&text=Site+ExpenSelf%0AOl%C3%A1%2C+tudo+bem%3F%0APoder%C3%ADamos+conversar%3F&type=phone_number&app_absent=0" target="_blank">
  		  <img src="/img/icone-whatsaap.png" alt="Whatsaap" height=17vh weight:17vw> Whatsaap
		    </a>
		   </li>
		   <li>
		    <a href="https://www.instagram.com/carriel_ti/" target="_blank">
  		  <img src="/img/icone-instagram.png" alt="Instagram" height=17vh weight:17vw> Instagram
		    </a>
		   </li>
		   <li>
        <div class="github">
		    <a href="https://github.com/Carrielti" target="_blank" target="_blank">
  		  <img src="/img/icone-github.png" alt="GitHub" height=17vh weight:17vw> GitHub
		    </a>
      </div>
		   </li>
		</ul>
    	</footer>

</html>
