document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('form');

    const campos = [
        {
            id: 'matricula',
            regra: (valor) => valor.length == 8,
            mensagem: 'É preciso ter no mínimo 8 números',
            numeric: true,
            max: 8
        },

        {
            id: 'cpf',
            regra: (valor) => valor.length == 11,
            mensagem: 'CPF inválido.',
            numeric: true,
            max: 11
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
            id: 'email',
            regra: (valor) => /^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})$/.test(valor),
            mensagem: 'Insira um email válido'
        },

        {
            id: 'senha',
            regra: (valor) => /^(?=.*[A-Z])(?=.*\d).{8,}$/.test(valor),
            mensagem: 'A senha precisa ter pelo menos uma letra maiúscula e um número'
        },

        {
            id: 'status',
            regra: (valor) => valor !== "",
            mensagem: 'Selecione pelo menos uma opção'
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

        {
            id: 'cep',
            regra: (valor) => /^\d{5}-?\d{3}$/.test(valor),
            mensagem: 'CEP Inválido. Digite um valor válido',
            numeric: true,
            max: 8
        },

        {
            id: 'rua',
            regra: (valor) => valor !== "",
            mensagem: 'Digite o nome de uma rua'
        },

        {
            id: 'numero',
            regra: (valor) => /^\d+$/.test(valor),
            mensagem: 'Digite um número residencial',
            numeric: true
        },

        {
            id: 'bairro',
            regra: (valor) => valor !== "",
            mensagem: 'Digite um bairro'
        },

        {
            id: 'cidade',
            regra: (valor) => valor !== "",
            mensagem: 'Digite uma cidade'
        },

        {
            id: 'estado',
            regra: (valor) => valor !== "",
            mensagem: 'Selecione um estado',
            max: 2
        },
    ]

    campos.forEach(campo => {
        validateCampo(campo);
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

function validateCampo(config) {

    const campo = document.getElementById(config.id)
    const input = campo.querySelector('input, select');

    function validar() {

        let valor = input.value

        if (config.numeric) {
            valor = valor.replace(/\D/g, '')
        }

        if (config.max) {
            valor = valor.slice(0, config.max)
        }

        input.value = valor;

        const valorFinal = valor.trim();

        if (!config.regra(valorFinal)) {
            setErro(campo, config.mensagem);
        } else {
            removeErro(campo);
        }

    }

    if (input.tagName === "SELECT") {
        input.addEventListener("change", validar);
    } else {
        input.addEventListener("input", validar);
    }

}

// Cadastro de selects
const selectMenu = document.querySelectorAll(".select-menu");

selectMenu.forEach(menu => {

    const select = menu.querySelector('select');
    const input = menu.querySelector('input');
    const btn = menu.querySelector('.toggle-btn');

    let inputmode = false;

    if (btn) {
        btn.addEventListener('click', () => {

            if (!inputmode) {
                select.required = false;
                select.style.display = 'none';
                input.style.display = 'block';
                btn.textContent = '←';

            } else {

                const newOption = input.value.trim();

                if (newOption.length !== 0) {

                    const option = document.createElement('option');
                    option.value = newOption.replace(/\s+/g, ' ');
                    option.textContent = newOption;

                    select.appendChild(option);

                    select.value = newOption;

                    input.value = '';
                }

                select.required = true;
                select.style.display = 'block';
                input.style.display = 'none';
                btn.textContent = '+';
            }

            inputmode = !inputmode;
        });
    }
});

//Seleção de Estados

const estados = [
    "AC", "AL", "AM", "AP", "BA", "CE", "DF", "ES",
    "GO", "MA", "MG", "MS", "MT", "PA", "PB", "PE",
    "PI", "PR", "RJ", "RN", "RO", "RR", "RS", "SC",
    "SE", "SP", "TO"
];

const select = document.querySelector("#select-estado");

estados.forEach(estado => {
    const option = document.createElement("option");
    option.value = estado;
    option.textContent = estado;
    select.appendChild(option);
});
