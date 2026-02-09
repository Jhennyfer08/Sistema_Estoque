function RealizarTr() {

    // Apagando o conteúdo da outra página
    const containerOff = document.getElementById("historicoTrTable");
    containerOff.style.display = "none";
    //

    const navBar = document.querySelector(".nav-bar");
    navBar.querySelector("span").style.left = "50%";

    // Criando o conteúdo da seção de transferências
    const container = document.querySelector(".container")

    if (!document.querySelector(".container-tr")) {

        const div = document.createElement("div");
        div.classList.add("container-tr")

        div.innerHTML = `
            <div class="menu-selecao">
                <p> Selecione os materiais a serem retornados </p >
                <p id="selecionar-todos">Selecionar todos</p>
            </div>

            <table id="materialTr">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descrição</th>
                        <th>Quantidade</th>
                        <th>...</th>
                    </tr>
                </thead>

                <tbody >
                    <tr>
                        <td>876543</td>
                        <td>P1</td>
                        <td>34U</td>
                        <td><input type="checkbox" name="selecionarCheckbox" class="checkboxTr"></td>
                    </tr>
                    <tr>
                        <td>456782</td>
                        <td>P2</td>
                        <td>2M</td>
                        <td><input type="checkbox" name="selecionarCheckbox" class="checkboxTr"></td>
                    </tr>
                    <tr>
                        <td>345679</td>
                        <td>P3</td>
                        <td>68U</td>
                        <td><input type="checkbox" name="selecionarCheckbox" class="checkboxTr"></td>
                    </tr>
                    <tr>
                        <td>987627</td>
                        <td>P4</td>
                        <td>5M</td>
                        <td><input type="checkbox" name="selecionarCheckbox" class="checkboxTr"></td>
                    </tr>
                </tbody>
            </table>

            <button type="submit" id="buttonConfirmarTr" onclick="PesquisarIdTr()">Confirmar Transferência</button>
        `

        container.appendChild(div);
        // Fim da criação do conteúdo da seção de transferências


        // Função para voltar ao histórico de transferências

        const historicoTr = document.getElementById("historicoTr")
        historicoTr.addEventListener("click", () => {
            containerOff.style.display = "block";

            div.remove();

            const navBar = document.querySelector(".nav-bar");
            navBar.querySelector("span").style.left = "0px";
        })

        // Função para atualizar visibilidade do menu de selecionar todos
        function atualizarMenu() {
            const checkboxes = document.querySelectorAll(".checkboxTr");
            const selectedCb = Array.from(checkboxes).some(cb => cb.checked)

            if (selectedCb) {
                document.getElementById("buttonConfirmarTr").style.display = "block";
            } else {
                document.getElementById("buttonConfirmarTr").style.display = "none";
            }
        }


        // Evento para selecionar/deselecionar todos os checkboxes
        const selecionarTodos = document.getElementById("selecionar-todos");
        selecionarTodos.addEventListener("click", () => {

            const checkboxes = document.querySelectorAll(".checkboxTr");
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

        const checkboxes = document.querySelectorAll(".checkboxTr");
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener("change", atualizarMenu);
        })

        atualizarMenu();
    }

}

function PesquisarIdTr() {

    window.location.href = "/pages/buscarIdFuncionario.html";
}
