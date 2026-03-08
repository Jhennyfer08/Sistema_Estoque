document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('form');

    const campos = [

        {
            id: 'descricao',
            regra: (valor) => valor.length >= 3,
            mensagem: 'Informe o nome do material.'
        },

        {
            id: 'valor',
            regra: (valor) => valor.length !== "",
            mensagem: 'Informe o valor unitário do material.'
        },

        {
            id: 'quantidade',
            regra: (valor) => valor.length !== "",
            mensagem: 'Informe a quantidade total do material.'
        },

        {
            id: 'unidade',
            regra: (valor) => valor !== "",
            mensagem: 'Selecione pelo menos uma opção'
        },

        {
            id: 'modo',
            regra: (valor) => valor !== "",
            mensagem: 'Selecione pelo menos uma opção'
        },

        {
            id: 'fornecedor',
            regra: (valor) => valor !== "",
            mensagem: 'Selecione pelo menos uma opção'
        }
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
        let valor = inputNome.value;

        if (config.numeric) {
            valor = valor.replace(/\D/g, '');
        }

        if (config.max) {
            valor = valor.slice(0, config.max);
        }

        inputNome.valor = valor;

        const valorFinal = valor.trim();

        if (!regra(valorFinal)) {
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

// Cadastro de Fornecedor
const btn = document.querySelector('.toggle-btn');

if (btn) {

    btn.addEventListener('click', () => {

        window.location.href = 'cadastroFornecedor.php';
    });
};