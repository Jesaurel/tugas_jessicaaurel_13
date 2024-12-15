document.getElementById("open-chat").onclick = function() {
    document.getElementById("chat-container").style.display = "block";
};

document.getElementById("close-chat").onclick = function() {
    document.getElementById("chat-container").style.display = "none";
};

document.getElementById("send-message").onclick = function() {
    let userMessage = document.getElementById("chat-input").value;
    if (userMessage.trim() !== "") {
        addMessageToChat("User: " + userMessage);
        document.getElementById("chat-input").value = ""; // Clear input field

        let response = getChatbotResponse(userMessage);
        setTimeout(() => {
            addMessageToChat("Chatbot: " + response);
        }, 1000);
    }
};

// Fungsi untuk menambahkan pesan ke chat
function addMessageToChat(message) {
    const messageElement = document.createElement("div");
    messageElement.textContent = message;
    document.getElementById("chat-messages").appendChild(messageElement);
}

// Fungsi untuk mendapatkan respons dari chatbot
function getChatbotResponse(userMessage) {
    const faq = {
        "jam buka": "Kami buka setiap hari, dari pukul 09.00 hingga 18.00.",
        "alamat": "Kami berada di Jalan Raya No. 123, Jakarta.",
        "produk": "Kami menyediakan berbagai produk elektronik, termasuk smartphone, laptop, dan aksesori lainnya.",
        "layanan": "Kami menyediakan layanan pengiriman, pemasangan, dan perawatan produk.",
        "hubungi customer service": "Tunggu sebentar, saya akan menghubungkan Anda dengan customer service kami."
    };

    // Menyaring pesan pengguna dan mencari kecocokan di FAQ
    userMessage = userMessage.toLowerCase();
    for (let question in faq) {
        if (userMessage.includes(question)) {
            return faq[question];
        }
    }

    // Respons default jika tidak ada kecocokan
    return "Maaf, saya tidak mengerti. Silakan ketik 'help' untuk melihat pilihan lainnya.";
}