const chatBody = document.querySelector(".chat-body");
const messageInput = document.querySelector(".message-input");
const sendMessageButton = document.querySelector("#send-message");
const chatbotToggler = document.querySelector("#chatbot-toggler");
const CloseChatbot = document.querySelector("#close-chatbot");

// API Setup
const API_KEY = "AIzaSyCmbKoqHR-CF1ubwTJEAYLMTVZ-nAp3rMw";
const API_URL = `https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=${API_KEY}`;

// Contexto del Bot
const BOT_CONTEXT = `
Eres Capia, un asistente virtual especializado en:
- Información sobre productos y servicios
- Soporte técnico básico
- Preguntas frecuentes
- Recomendaciones personalizadas

Reglas clave:
1. Sé amable y profesional
2. Usa emojis moderadamente 😊
3. Respuestas claras (máximo 2 párrafos)
4. Si no sabes algo, ofrece ayuda alternativa

Última actualización: Mayo 2024
`.trim();

const INITIAL_BOT_MESSAGE = `¡Hola! 👋 Soy Capia. ${BOT_CONTEXT.split('\n')[0]}\n\n¿En qué puedo ayudarte hoy?`;

const userData = {
    message: null
};

// Historial inicial con contexto
const chatHistory = [
    {
        role: "model",
        parts: [{ text: INITIAL_BOT_MESSAGE }]
    }
];

const initialInputHeight = messageInput.scrollHeight;

// Funciones auxiliares
const scrollToLatestMessage = () => { 
    chatBody.scrollTo({ top: chatBody.scrollHeight, behavior: "smooth" }); 
};

const createMessageElement = (content, ...classes) => {
    const div = document.createElement("div");
    div.classList.add("message", ...classes);
    div.innerHTML = content;
    return div;
};

// Función para generar respuesta del bot
const generateBotResponse = async (incomingMessageDiv) => {
    const messageElement = incomingMessageDiv.querySelector(".message-text");

    chatHistory.push({
        role: "user",
        parts: [{ text: userData.message }]
    });

    const requestOptions = {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            contents: chatHistory,
            system_instruction: {
                parts: [{ text: BOT_CONTEXT }]
            }
        })
    };

    try {
        const response = await fetch(API_URL, requestOptions);
        const data = await response.json();
        if (!response.ok) throw new Error(data.error.message);

        const apiResponseText = data.candidates[0].content.parts[0].text
            .replace(/\*\*(.*?)\*\*/g, "$1")
            .trim();

        messageElement.innerText = apiResponseText;
        chatHistory.push({ role: "model", parts: [{ text: apiResponseText }] });

    } catch (error) {
        console.error(error);
        messageElement.innerText = "¡Vaya! Algo salió mal. Por favor, inténtalo de nuevo.";
        messageElement.style.color = "#ff0000";
    } finally {
        incomingMessageDiv.classList.remove("thinking");
        scrollToLatestMessage();
    }
};

// Manejo de mensajes salientes
const handleOutgoingMessage = (e) => {
    e.preventDefault();
    userData.message = messageInput.value.trim();
    if (!userData.message) return;
    
    messageInput.value = "";
    messageInput.dispatchEvent(new Event("input"));

    const outgoingMessageDiv = createMessageElement(
        '<div class="message-text"></div>', 
        "user-message"
    );
    outgoingMessageDiv.querySelector(".message-text").textContent = userData.message;
    chatBody.appendChild(outgoingMessageDiv);
    scrollToLatestMessage();

    setTimeout(() => {
        const incomingMessageDiv = createMessageElement(`
            <img src="Imagenes/capi.jpg" class="bot-avatar" width="50" height="50" alt="Capi Bot">
            <div class="message-text">
                <div class="thinking-indicator">
                    <div class="dot"></div>
                    <div class="dot"></div>
                    <div class="dot"></div>
                </div>
            </div>`, 
            "bot-message", "thinking"
        );
        chatBody.appendChild(incomingMessageDiv);
        scrollToLatestMessage();
        generateBotResponse(incomingMessageDiv);
    }, 600);
};

// Event listeners
messageInput.addEventListener("keydown", (e) => {
    const userMessage = e.target.value.trim();
    if (e.key === "Enter" && userMessage && !e.shiftKey && window.innerWidth > 768) {
        handleOutgoingMessage(e);
    }
});

messageInput.addEventListener("input", () => {
    messageInput.style.height = `${initialInputHeight}px`;
    messageInput.style.height = `${messageInput.scrollHeight}px`;
    document.querySelector(".chat-form").style.borderRadius = 
        messageInput.scrollHeight > initialInputHeight ? "15px" : "32px";
});

// Event listeners finales
sendMessageButton.addEventListener("click", (e) => handleOutgoingMessage(e));
chatbotToggler.addEventListener("click", () => document.body.classList.toggle("show-chatbot"));
CloseChatbot.addEventListener("click", () => document.body.classList.remove("show-chatbot"));