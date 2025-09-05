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
- Información sobre productos y categorías
- Ayuda a los clientes a decidir sobre su orden
- Preguntas frecuentes
- Recomendaciones personalizadas

Reglas clave:
1. Sé amable y profesional
2. Usa emojis moderadamente 😊
3. Respuestas claras (máximo 2 párrafos)
4. Si no sabes algo, ofrece ayuda alternativa

Estos son nuestras categorías de productos:
1. 'Pan', Productos horneados como conchas, bolillos, cuernitos, etc.
2. 'Café', Bebidas a base de café como espresso, americano, capuchino.
3. 'Dulce', Pasteles, panqués, galletas y postres variados.
4. 'Bebida', Jugos, tés, malteadas y otras bebidas no cafeinadas.
5. 'Comida', Platillos salados como chilaquiles, sandwiches, etc.'
6. Pastel, Deliciosas creaciones horneadas que combinan esponjosos bizcochos con rellenos y coberturas variadas, perfectas para celebrar momentos especiales o simplemente darte un gusto dulce.
7. Granos de café: Granos de café seleccionados y tostados para preparar la mejor bebida de café.

y estos son nuestros productos:
Vendemos Pan integral el cual es un pan saludable hecho con harina integral y semillas y cuesta 14.
Vendemos Galletas de avena el cual es una galleta crujiente con avena y pasas, perfecta para merendar y cuesta 12.
Vendemos Té verde el cual es una bebida caliente de té verde natural, antioxidante y refrescante y cuesta 13.
Vendemos Espresso Clásico el cual es un café espresso tradicional, intenso y aromático y cuesta 20.
Vendemos Espresso Doble el cual es una doble carga de espresso para un sabor más fuerte y cuesta 30.
Vendemos Espresso Macchiato el cual es un espresso con una pizca de leche espumada y cuesta 35.
Vendemos Espresso Ristretto el cual es una versión más concentrada del espresso clásico y cuesta 25.
Vendemos Capuccino Clásico el cual es un café con leche espumada, suave y equilibrado y cuesta 25.
Vendemos Capuccino Vainilla el cual es un capuccino con un toque dulce de vainilla y cuesta 25.
Vendemos Capuccino Crema el cual es un capuccino con crema batida para una textura extra y cuesta 30.
Vendemos Capuccino Chocolate el cual es un capuccino con chocolate derretido, ideal para los amantes del cacao y cuesta 35.
Vendemos Latte Clásico el cual es un café con abundante leche vaporizada, suave y cremoso y cuesta 35.
Vendemos Latte Caramelo el cual es un latte con jarabe de caramelo, dulce y reconfortante y cuesta 40.
Vendemos Latte Almendra el cual es un latte con esencia de almendra, un sabor delicado y cuesta 45.
Vendemos Latte Especiado el cual es un latte con mezcla de especias como canela y nuez moscada y cuesta 50.
Vendemos Cold Brew el cual es un café frío preparado en infusión lenta, suave y refrescante y cuesta 45.
Vendemos Frappé el cual es una bebida fría de café licuado con hielo, cremosa y dulce y cuesta 50.
Vendemos Moca Frío el cual es un café frío con chocolate y leche, delicioso y energizante y cuesta 40.
Vendemos Vainilla Frío el cual es un café frío con sabor a vainilla, refrescante y aromático y cuesta 35.
Vendemos Concha Clásica el cual es un pan dulce tradicional con cobertura azucarada y cuesta 10.
Vendemos Concha Rellena de Cajeta el cual es una concha suave rellena con dulce cajeta y cuesta 21.
Vendemos Concha Rellena de Nata el cual es una concha esponjosa rellena de nata fresca y cuesta 25.
Vendemos Concha Rellena de Nutella el cual es una concha rellena con crema de avellana y cacao y cuesta 30.
Vendemos Cuernito Natural el cual es un cuernito de pan suave sin relleno, ideal para acompañar bebidas y cuesta 10.
Vendemos Cuernito Relleno de Crema el cual es un cuernito con delicioso relleno de crema pastelera y cuesta 26.
Vendemos Cuernito Cubierto de Chocolate el cual es un cuernito bañado en chocolate, ideal para los golosos y cuesta 35.
Vendemos Dona de Chocolate el cual es una dona suave con cobertura de chocolate y cuesta 12.
Vendemos Dona de Fresa el cual es una dona con glaseado de fresa y chispas de colores y cuesta 12.
Vendemos Dona Rellena de Crema el cual es una dona esponjosa con relleno de crema pastelera y cuesta 18.
Vendemos Cupcake de Vainilla el cual es un cupcake esponjoso con sabor a vainilla y betún y cuesta 10.
Vendemos Cupcake de Chocolate el cual es un cupcake suave con cobertura de chocolate y cuesta 21.
Vendemos Cupcake Red Velvet el cual es un cupcake de cacao rojo con betún de queso crema y cuesta 25.
Vendemos Cupcake de Zanahoria el cual es un cupcake de zanahoria con nuez y betún cremoso y cuesta 25.
Vendemos Chilaquiles Rojos el cual es un platillo de totopos bañados en salsa roja o verde, acompañados de crema y queso y cuesta 65.
Vendemos Chilaquiles con Pollo el cual es un platillo de chilaquiles acompañados con pechuga de pollo deshebrada y cuesta 77.
Vendemos Chilaquiles con Huevo Estrellado el cual es un platillo de chilaquiles servidos con huevo estrellado y cuesta 70.
Vendemos Chilaquiles con Arrachera el cual es un platillo de chilaquiles acompañados de jugosa arrachera y cuesta 90.
Vendemos Molletes Clásicos el cual es un pan bolillo con frijoles refritos y queso gratinado y cuesta 50.
Vendemos Molletes con Pico de Gallo el cual es un mollete clásico con fresco pico de gallo y cuesta 55.
Vendemos Molletes con Chorizo el cual es un mollete clásico acompañado con chorizo y cuesta 60.
Vendemos Molletes con Jamón y Manchego el cual es un mollete gratinado con jamón y queso manchego y cuesta 65.
Vendemos Baguette de Jamón y Queso el cual es un pan baguette con jamón y queso fundido y cuesta 70.
Vendemos Baguette de Pollo con Chipotle el cual es un baguette con pollo y aderezo de chipotle y cuesta 80.
Vendemos Baguette Caprese el cual es un baguette con mozzarella, jitomate y albahaca fresca y cuesta 85.
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