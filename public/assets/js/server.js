//Bibliotecas e Frameworks

import express from "express";
import cors from "cors";
import { v4 as uuidv4 } from "uuid";
import { createCanvas } from "canvas";
const app = express();
app.use(cors());
app.use(express.json());

//B e F end


//BACK-END CAPTCHA

const captchaStore = {};

function generateCaptchaText() {
    return Math.random().toString(36).substring(2, 8).toUpperCase();
}

function getRandomColor() {
    const r = Math.floor(Math.random() * 256);
    const g = Math.floor(Math.random() * 256);
    const b = Math.floor(Math.random() * 256);
    return `rgb(${r}, ${g}, ${b})`;
}

function getRandomFont() {
    const fonts = ["Arial", "Verdana", "Courier", "Gerogia", "Times New Roman"];
    const randomFont = fonts[Math.floor(Math.random() * fonts.length)];
    const randomSize = Math.floor(Math.random() * 10) + 30;
    return `${randomSize}px ${randomFont}`;
}

function generateCaptchaImage(text) {
    const canvas = createCanvas(200, 80);
    const ctx = canvas.getContext("2d");


    //Fundo
    ctx.fillStyle = "#f8f8f8";
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    //Ruídos nas imagens
    for (let i = 0; i < 5; i++) {
        ctx.strokeStyle = `rgba(0, 0, 0, ${Math.random()})`;
        ctx.beginPath();
        ctx.moveTo(Math.random() * 200, Math.random() * 80);
        ctx.lineTo(Math.random() * 200, Math.random() * 80);
        ctx.stroke();
    }

    //Cor e Fonte do texto
    ctx.font = getRandomFont();
    ctx.fillStyle = getRandomColor();
    ctx.textAlign = "center";
    ctx.textBaseline = "middle";
    ctx.translate(canvas.width / 2, canvas.height / 2);
    ctx.rotate(Math.random() * 0.3 - 0.15);
    ctx.fillText(text, 0, 0);

    return canvas.toDataURL();
}

//API CAPTCHA

app.get("/generate-captcha", (req, res) => {
    const captchaText = generateCaptchaText();
    const captchaId = uuidv4();
    captchaStore[captchaId] = captchaText;
    const captchaImage = generateCaptchaImage(captchaText);
    res.json({ captchaId, captchaImage });
})

app.post("/verify-captcha", (req, res) => {
    const { userInput, captchaId } = req.body;

    if (!captchaId || !captchaStore[captchaId]) {
        return res
            .status(400)
            .json({ success: false, message: "CAPTCHA expirado ou não encontrado" })
    }

    const isCorrect = userInput.toUpperCase() === captchaStore[captchaId];
    delete captchaStore[captchaId];

    res.json({
        success: isCorrect,
        message: isCorrect ? "CAPTCHA correto" : "CAPTCHA incorreto",
    })
})

app.listen(3000, () => console.log("Server is running on port 3000"))

