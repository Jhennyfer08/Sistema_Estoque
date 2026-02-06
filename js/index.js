
// Validação do FORM

//SE O LoGiN E O CAPTCHA ESTIVER CORRETO QUE É PRA ENTRAR, ESTÁ COMO SE SOMENTE O CAPTCHA PRECISASSE ESTAR CORRETO

//CAPTCHA

let captchaId = " ";

function fetchCapcha() {
    fetch("http://localhost:3000/generate-captcha").then((response) =>
        response.json()).then((info) => {
            captchaId = info.captchaId;
            document.getElementById("captchaImage").src = info.captchaImage;
        })
        .catch((error) => console.error("Erro ao consultar o CAPTCHA:", error));
}

document.querySelector("form").addEventListener("submit", (e) => {
    e.preventDefault();

    const userInput = document.getElementById("captchaInput").value.trim();
    if (!userInput) return;

    fetch("http://localhost:3000/verify-captcha", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ userInput, captchaId }),
    }).then((response) => response.json())
        .then((result) => {
            if (result.success) {
                document.getElementById("successMessage").style.display = "block";
                document.getElementById("errorMessage").style.display = "none";
                document.getElementById("submitButton").disabled = false;
                window.location.href = "../pages/pag_selecao.html"
            } else {
                document.getElementById("successMessage").style.display = "none";
                document.getElementById("errorMessage").style.display = "block";
                alert("Código errado, tente novamente") //Possível alteração
                fetchCapcha();
            }
        })
        .catch((error) => console.error("Erro ao verificar o CAPTCHA: ", error));
})

document.getElementById("refreshButton").addEventListener("click", fetchCapcha);

document.getElementById("captchaInput").addEventListener("input", (e) => {
    document.getElementById("submitButton").disabled = e.target.value.trim().length === 0;
})

fetchCapcha();
