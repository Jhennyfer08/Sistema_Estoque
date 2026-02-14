document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('form');

    const campos = [
        {
            id: 'matricula',
            regra: (valor) => valor.length == 8,
            mensagem: 'É preciso ter no mínimo 8 números'
        },

        {
            id: 'cpf',
            regra: (valor) => valor.length == 11 && valor.replace(/[^0-9]/g, ''),
            mensagem: 'CPF inválido.'
        },

        {
            id: 'nome',
            regra: (valor) => valor.length >= 3,
            mensagem: 'O nome precisa ter no mínimo 3 letras'
        },

        {
            id: 'nasc',
            regra: (valor) => valor !== "",
            mensagem: 'Insira uma data válida'
        },

        {
            id: 'contrato',
            regra: (valor) => valor !== "",
            mensagem: 'Insira uma data válida'
        },

        {
            id: 'setor',
            regra: (valor) => valor !== "",
            mensagem: 'Selecione pelo menos uma opção'
        },

        {
            id: 'funcao',
            regra: (valor) => valor !== "",
            mensagem: 'Selecione pelo menos uma opção'
        },

    ]

    campos.forEach(campo => {
        validateCampo(campo.id, campo.regra, campo.mensagem);
    });

    form.addEventListener('submit', (e) => {
        e.preventDefault();

        let valido = true;

        campos.forEach(config => {
            const campoHTML = document.getElementById(config.id);
            const input = campoHTML.querySelector('input, select');
            const valor = input.value.trim();

            if (!config.regra(valor)) {
                setErro(campoHTML, config.mensagem);
                valido = false;
            } else {
                removeErro(campoHTML);
            }
        });

        if (valido) {
            form.submit();
        }
    });
});


function setErro(campo, mensagem) {
    const input = campo.querySelector('input, select');
    const span = campo.querySelector('span');

    input.style.border = '2px solid var(--error)';
    span.style.display = 'block';
    span.textContent = mensagem;
}

function removeErro(campo) {
    const input = campo.querySelector('input, select');
    const span = campo.querySelector('span');

    input.style.border = '';
    span.style.display = 'none';
}

function validateCampo(campoId, regra, mensagem) {

    const campo = document.getElementById(campoId)
    const inputNome = campo.querySelector('input, select');

    function validar() {
        const valor = inputNome.value.trim();

        if (!regra(valor)) {
            setErro(campo, mensagem);
        } else {
            removeErro(campo);
        }
    }

    if (inputNome.tagName === "SELECT") {
        inputNome.addEventListener("change", validar);
    } else {
        inputNome.addEventListener("input", validar);
    }

}



// Cadastro de selects
const selectMenu = document.querySelectorAll(".select-menu");

selectMenu.forEach(menu => {

    const select = menu.querySelector('select');
    const input = menu.querySelector('input');
    const btn = menu.querySelector('.toggle-btn')

    let inputmode = false;

    btn.addEventListener('click', () => {

        if (!inputmode) {
            select.style.display = 'none';
            input.style.display = 'block';
            btn.textContent = '←';

        } else {

            const newOption = input.value.trim();

            if (newOption.length !== "") {

                const option = document.createElement('option');
                option.value = newOption.replace(/\s+/g, ' ');
                option.textContent = newOption;

                select.appendChild(option);

                select.value = newOption;

                input.value = '';
            }

            select.style.display = 'block';
            input.style.display = 'none';
            btn.textContent = '+';
        }

        inputmode = !inputmode;
    });
});


function inputValidate(campoId) {

    const inputs = campoId.querySelectorAll('input');

    return Array.from(inputs).map(input => {

        if (input.type === 'text') {

            return input.value.trim();

        } else if (input.getAttribute('inputmode') === 'numeric' || input.type === 'number') {

            return input.value.replace(/[^0-9]/g, '');

        }
        else {
            return input;
        }
    });
}
