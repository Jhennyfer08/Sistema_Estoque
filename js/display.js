function toggleSecao() {
    // Apagando o conteúdo da outra página
    const navBar = document.querySelector(".nav-bar");

    navBar.addEventListener('click', (event) => {

        const lista = event.target.closest('#lista');
        const secao = event.target.closest('#container');

        if (lista) {

            navBar.querySelector("span").style.left = "0px";
            document.getElementById("listaTable").style.display = "block";
            document.getElementById("containerSecao").style.display = "none";

        } else if (secao) {

            navBar.querySelector("span").style.left = "50%";
            document.getElementById("containerSecao").style.display = "block";
            document.getElementById("listaTable").style.display = "none";
        }
    })


    // Função para atualizar visibilidade do menu de selecionar todos
    function atualizarMenu() {
        const checkboxes = document.querySelectorAll(".checkbox");
        const selectedCb = Array.from(checkboxes).some(cb => cb.checked)

        if (selectedCb) {
            document.getElementById("buttonConfirmar").style.display = "block";
        } else {
            document.getElementById("buttonConfirmar").style.display = "none";
        }
    }

    // Evento para selecionar/deselecionar todos os checkboxes
    const selecionarTodos = document.getElementById("selecionar-todos");
    selecionarTodos.addEventListener("click", () => {

        const checkboxes = document.querySelectorAll(".checkbox");
        const allCbSelected = Array.from(checkboxes).every(cb => cb.checked);

        checkboxes.forEach(checkbox => {
            if (allCbSelected) {
                checkbox.checked = false;
            } else {
                checkbox.checked = true;
            }
        });
        atualizarMenu();
    })

    // Evento para atualizar o menu  cada mudança de ação num checkbox

    const checkboxes = document.querySelectorAll(".checkbox");
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener("change", atualizarMenu);
    })

    atualizarMenu();
}

document.addEventListener('DOMContentLoaded', () => {
    toggleSecao();
})


//TALVEZ SEJA MELHOR NÃO POIS NO MOMENTO DE CADASTRAR OS DADOS DARIA UM PROBLEMINHA
function paginaDeInput() {

    const btn = document.querySelector('.submit-btn');
    let paginaAtual = window.location.pathname;

    switch (paginaAtual) {
        case '/retornoTotal.html' || '/pages/retornoTotal.html':
            btn.addEventListener('click', () => {


            });

            break;
        case '/transferencia.html' || '/pages/transferencia.html':

            break;
        case '/contigencia.html' || '/pages/contigencia.html':


            break;
        default:
            break;
    }
}


