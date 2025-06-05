function toggleMenu() {
  const menu = document.getElementById('dropdown');
  menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
}

window.onclick = function (event) {
  if (!event.target.matches('.menu-icon')) {
    const dropdown = document.getElementById("dropdown");
    if (dropdown && dropdown.style.display === 'block') {
      dropdown.style.display = "none";
    }
  }
};

// Função para excluir ponto (exemplo já presente)
function excluirPonto(id) {
  if (confirm('Tem certeza que deseja excluir este ponto?')) {
    fetch(`excluir_ponto.php?id=${id}`, { method: 'GET' })
      .then(res => res.text())
      .then(msg => {
        alert(msg);
        location.reload();
      })
      .catch(err => console.error('Erro ao excluir:', err));
  }
}

// 🔥 NOVA FUNÇÃO – Gera gráfico com destaque na despesa clicada
function destacarDespesa(nome) {
  const formData = new FormData();
  formData.append("highlight", nome);

  fetch("gerar_grafico.php", {
    method: "POST",
    body: formData
  })
  .then(response => {
    if (response.ok) {
      location.reload(); // recarrega a página com gráfico novo
    } else {
      console.error("Erro ao processar destaque.");
    }
  })
  .catch(error => {
    console.error("Erro ao enviar destaque:", error);
  });
}

const hamburguer = document.getElementById("hamburguer");
// Atribui a constante 'hamburguer' o elemento 'hamburguer'
const navMenu = document.getElementById("nav-menu");
// Atribui a constante 'navMenu' o elemento 'nav-menu'

// alterna a classe 'open' no menu ao clicar no hamberguer
hamburguer.addEventListener("click", () => {
  navMenu.classList.toggle("open");
  // adiciona ou remove a classe 'open' no menu

  // ajusta a posição do menu
  if (navMenu.classList.contains("open")) {
    
    navMenu.style.position = "absolute"; // posição na página
    navMenu.style.top = "50px"; // distância do topo do head
    navMenu.style.left = "5px"; // fixa ao lado esquerdo do hamburguer
    navMenu.style.backgroundColor = "#050505"; // cor do plano de fundo
    navMenu.style.borderRadius = "5px"; // bordas arredondadas
    navMenu.style.boxShadow = "0 4px 6px rgba(0,0,0,0.1)"; // Altera o Estilo da Caixa
    navMenu.style.zIndex = "1000"; // Garante que o menu fique acima dos outros elementos
    navMenu.style.width = "200px"; // Largura do Menu

  } else {
    // remove os estilos para voltar ao estado original
    navMenu.style.position = ""; // posição na página
    navMenu.style.top = ""; // distância do topo do head
    navMenu.style.left = ""; // fixa ao lado esquerdo do hamburguer
    navMenu.style.backgroundColor = ""; // cor do plano de fundo
    navMenu.style.borderRadius = ""; // bordas arredondadas
    navMenu.style.boxShadow = ""; // Altera o Estilo da Caixa
    navMenu.style.zIndex = ""; // Garante que o menu fique acima dos outros elementos
    navMenu.style.width = ""; // Largura do Menu
  }
});
  function toggleUserMenu() {
    const dropdown = document.getElementById("userDropdown");
    if (dropdown) {
      dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
    }
  }

  // Esconde se clicar fora do menu
  window.addEventListener("click", function(e) {
    const dropdown = document.getElementById("userDropdown");
    const userCircle = document.querySelector(".user-circle");

    if (dropdown && userCircle && !userCircle.contains(e.target) && !dropdown.contains(e.target)) {
      dropdown.style.display = "none";
    }
  });
