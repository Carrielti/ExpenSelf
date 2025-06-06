<?php
session_start();
if (!isset($_SESSION['id_usuario'])) {
    echo "<script>alert('Acesso negado. Faça login!'); window.location.href='index.html';</script>";
}
$nome = $_SESSION['nome'];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>ExpenSelf - Home</title>
  <link rel="stylesheet" href="style.css"/>
  <link rel="icon" href="/img/icone-logo.png" type="image/png">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
  <div class="top-bar">
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
          <li><a href="listar_receitas.php">Receitas</a></li><br>
          <li><a href="e_sobre.php">Sobre</a></li><br>
          <li><a href="e_contato.php">Contato</a></li><br>
      </ul>
    </nav>
    </div>

    <div class="logo-container">
      <img class="logo-img" src="/img/logo.png" alt="Logo">
    </div>

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

  <div class="circles-container">
    <?php
    $categorias = [
      "Aluguel" => "house", "Mercado" => "mercado", "Transporte" => "transporte",
      "Energia" => "energia", "Água" => "water", "Internet" => "wifi",
      "Educação" => "educacao", "Saúde" => "saude", "Lazer" => "jogos",
      "Celular" => "smartphone", "Farmácia" => "medicine", "Roupas" => "roupas"
    ];
    foreach ($categorias as $nomeCat => $img) {
      echo '
      <button class="circle" onclick="destacarCategoria(\''.htmlspecialchars($nomeCat).'\')" title="'.htmlspecialchars($nomeCat).'">
        <img src="/img/'.$img.'.png" alt="'.htmlspecialchars($nomeCat).'">
      </button>';
    }
    ?>
    <form action="listar_despesas.php" method="GET" style="display:inline;">
      <button class="circle" type="submit" title="Saiba Mais">
        <img src="/img/pontos.png" alt="Saiba Mais">
      </button>
    </form>
  </div>

  <div class="graph-section" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 40px;">
  <div>
    <h2>Gastos por Categoria</h2>
    <canvas id="graficoDespesas" width="400" height="200"></canvas>
  </div>
  <div>
    <h2>Receitas x Despesas</h2>
    <canvas id="graficoComparativo" width="400" height="200"></canvas>
  </div>
</div>

<div class="saldo-section">
  <h3>Saldo Mensal Atual</h3>
  <div id="saldo-mensal" class="caixa-saldo">Carregando saldo...</div>
</div>


  <div id="resumo-financeiro" class="caixa-saldo">
  <strong>Calculando saldo...</strong>
</div>

  <script src="script.js"></script>

  <script>
    let grafico;

    function gerarGrafico(destaque = null) {
      fetch('dados_grafico.php')
        .then(response => response.json())
        .then(dados => {
          const nomes = dados.map(item => item.nome);
          const valores = dados.map(item => item.total);

          const cores = nomes.map(nome => nome === destaque ? 'rgba(255, 99, 132, 0.7)' : 'rgba(54, 162, 235, 0.5)');
          const bordas = nomes.map(nome => nome === destaque ? 'rgba(255, 99, 132, 1)' : 'rgba(54, 162, 235, 1)');

          const ctx = document.getElementById('graficoDespesas').getContext('2d');
          if (grafico) grafico.destroy();

          grafico = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: nomes,
              datasets: [{
                label: 'Despesas (R$)',
                data: valores,
                backgroundColor: cores,
                borderColor: bordas,
                borderWidth: 1
              }]
            },
            options: {
              responsive: true,
              scales: {
                y: {
                  beginAtZero: true
                }
              }
            }
          });
        });
    }

    function destacarCategoria(categoria) {
      gerarGrafico(categoria);
    }

    document.addEventListener('DOMContentLoaded', () => {
      gerarGrafico();
    });

    function toggleUserMenu() {
      const dropdown = document.getElementById("userDropdown");
      dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
    }

    fetch('calcular_saldo.php')
  .then(res => res.json())
  .then(data => {
    const resumo = document.getElementById('resumo-financeiro');
    const saldoFormatado = data.saldo.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    const cor = data.saldo >= 0 ? 'green' : 'red';
    resumo.innerHTML = `<strong style="color: ${cor};">Saldo: ${saldoFormatado}</strong>`;
  })
  .catch(() => {
    document.getElementById('resumo-financeiro').innerText = 'Erro ao calcular saldo';
  });

function gerarGraficoComparativo() {
  fetch('dados_comparativo.php')
    .then(response => response.json())
    .then(data => {
      const ctx = document.getElementById('graficoComparativo').getContext('2d');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['Receitas', 'Despesas'],
          datasets: [{
            label: 'R$',
            data: [data.receitas, data.despesas],
            backgroundColor: ['rgba(46, 204, 113, 0.6)', 'rgba(231, 76, 60, 0.6)'],
            borderColor: ['rgba(46, 204, 113, 1)', 'rgba(231, 76, 60, 1)'],
            borderWidth: 1
          }]
        },
        options: {
          responsive: true,
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });
    });
}

document.addEventListener('DOMContentLoaded', () => {
  gerarGrafico();             // gráfico de categorias
  gerarGraficoComparativo(); // gráfico receitas vs despesas
});

// Chama API de saldo mensal
fetch("calcular_saldo_mensal.php")
  .then(res => res.json())
  .then(data => {
    document.getElementById("saldo-mensal").innerText =
      `Receitas: R$ ${data.receita} | Despesas: R$ ${data.despesa} | Saldo: R$ ${data.saldo}`;
  })
  .catch(() => {
    document.getElementById("saldo-mensal").innerText = "Erro ao calcular saldo.";
  });


  </script>

</body>

<footer>
  <hr>
  <h4>Contato:</h4>
  <ul>
    <li>
      <a href="https://api.whatsapp.com/send/?phone=5515991592555&text=Site+ExpenSelf" target="_blank">
        <img src="/img/icone-whatsaap.png" alt="WhatsApp" height="17"> WhatsApp
      </a>
    </li>
    <li>
      <a href="https://www.instagram.com/carriel_ti/" target="_blank">
        <img src="/img/icone-instagram.png" alt="Instagram" height="17"> Instagram
      </a>
    </li>
    <li>
      <a href="https://github.com/Carrielti" target="_blank">
        <img src="/img/icone-github.png" alt="GitHub" height="17"> GitHub
      </a>
    </li>
  </ul>
</footer>
</html>
