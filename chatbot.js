(async () => {
  const toggle = document.getElementById('chat-toggle');
  const container = document.getElementById('chatbot-container');
  const chatBox = document.getElementById('chat-box');
  const input = document.getElementById('chat-input');
  const sendBtn = document.getElementById('send-btn');
  const micBtn = document.getElementById("mic-btn");
  const darkBtn = document.getElementById("dark-mode-toggle");
  const closeBtn = document.getElementById("chat-close");

  if (!toggle || !container) return;

  toggle.addEventListener("click", () => {
    container.classList.toggle("hidden");
  });
  closeBtn.addEventListener("click", () => container.classList.add("hidden"));

  function appendMessage(text, cls) {
    const div = document.createElement("div");
    div.className = cls;
    div.textContent = text;
    chatBox.appendChild(div);
    chatBox.scrollTop = chatBox.scrollHeight;
  }

  function showTyping() {
    const el = document.createElement("div");
    el.className = "bot-msg typing";
    el.innerHTML = "<span></span><span></span><span></span>";
    chatBox.appendChild(el);
    chatBox.scrollTop = chatBox.scrollHeight;
    return el;
  }
  /* ----------------------- DARK MODE ----------------------- */
  darkBtn.addEventListener("click", () => {
    document.body.classList.toggle("dark-mode");
  });
  /* ----------------------- SPEAK TEXT ----------------------- */
  function speak(text) {
    if (!("speechSynthesis" in window)) return;
    const utter = new SpeechSynthesisUtterance(text);
    utter.lang = "en-US";
    window.speechSynthesis.speak(utter);
  }

  /* ----------------------- VOICE INPUT ----------------------- */
  let recognition = null;

  if ("webkitSpeechRecognition" in window) {
    recognition = new webkitSpeechRecognition();
    recognition.lang = "en-US";
    recognition.continuous = false;
    recognition.interimResults = false;

    micBtn.addEventListener("click", () => {
      recognition.start();
      appendMessage("🎤 Listening...", "bot-msg");
    });

    recognition.onresult = function (event) {
      input.value = event.results[0][0].transcript;
      sendMessage();
    };
  } else {
    micBtn.style.display = "none"; // hide voice button if not supported
  }

  async function sendMessage() {
    const text = input.value.trim();
    if (!text) return;
    input.value = "";

    appendMessage(text, "user-msg");

    const typingEl = showTyping();

    try {
      const resp = await fetch("chatbot.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ message: text })
      });

      if (!resp.ok) throw new Error("Server error " + resp.status);

      const data = await resp.json();
      typingEl.remove();

      appendMessage(data.reply, "bot-msg");

    } catch (err) {
      typingEl.remove();
      appendMessage("Error talking to server: " + err.message, "bot-msg");
    }
  }

  sendBtn.addEventListener("click", sendMessage);
  input.addEventListener("keydown", (e) => {
    if (e.key === "Enter") sendMessage();
  });
})();
