const selectMenu = document.querySelector(".select-menu");
let variavelToggle = true;

selectMenu.addEventListener("click", (event) => {
    if (event.target.id === 'addBtn') {

        if (variavelToggle) {
            selectMenu.innerHTML = `
            <input type="text" id="fornecedor" name="fornecedor" placeholder="Digite o nome do fornecedor">
            <button id="addBtn" class="adicionar-btn">&#8656</button>
            `;

        } else {
            console.log("Deuu prr")
            selectMenu.innerHTML = `
                <select name="fornecedor" id="fornecedor" required>
                    <option value="">Selecione um fornecedor</option>  
                    <option value="fornecedor1">Fornecedor 1</option>
                    <option value="fornecedor2">Fornecedor 2</option>
                    <option value="fornecedor3">Fornecedor 3</option>
                </select>
                <button id="addBtn" class="adicionar-btn">&#43</button>
            `
        }
        variavelToggle = !variavelToggle;
    }
})