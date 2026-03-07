document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('form');

    const campos = [

        {
            id: 'nome',
            regra: (valor) => valor.length >= 3,
            mensagem: 'O nome precisa ter no mínimo 3 letras'
        },

        {
            id: 'cnpj',
            regra: (valor) => valor.length == 14,
            mensagem: 'CNPJ inválido.',
            numeric: true,
            max: 14
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
    const inputNome = campo.querySelector('input, select');

    function validar() {

        let valor = inputNome.value

        if (config.numeric) {
            valor = valor.replace(/\D/g, '')
        }

        if (config.max) {
            valor = valor.slice(0, config.max)
        }

        inputNome.value = valor;

        const valorFinal = valor.trim();

        if (!config.regra(valorFinal)) {
            setErro(campo, config.mensagem);
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
