<div x-data="faqbot()" class="faq-chatbot">
  <button @click="open = !open" class="faq-chatbot__toggle">
    FAQ
  </button>

  <div x-show="open" x-transition class="faq-chatbot__panel">
    <div class="faq-chatbot__header">
      <p class="faq-chatbot__title">Fragen & Antworten</p>
      <p class="faq-chatbot__subtitle">Schnelle Antworten zu Kursen, Anmeldung, Kosten.</p>
    </div>

    <div class="faq-chatbot__messages" x-ref="messagesContainer">
      <template x-if="messages.length === 0">
        <div class="faq-chatbot__welcome">
          <p class="faq-chatbot__hint">Stellen Sie eine Frage oder wählen Sie ein Thema:</p>
          <div class="faq-chatbot__topics">
            <template x-for="topic in defaultTopics" :key="topic.id">
              <button @click="quick(topic.label)" class="faq-chatbot__topic-btn" x-text="topic.label"></button>
            </template>
          </div>
        </div>
      </template>

      <template x-for="m in messages" :key="m.id">
        <div class="faq-chatbot__message" :class="'faq-chatbot__message--' + m.role">
          <div class="faq-chatbot__message-bubble" x-html="m.html"></div>
        </div>
      </template>
    </div>

    <form @submit.prevent="send()" class="faq-chatbot__form">
      <input x-model="q" type="text" class="faq-chatbot__input" placeholder="z. B. 'Kosten', 'Anmeldung', 'Ort'...">
      <button class="faq-chatbot__submit">Senden</button>
    </form>

    <div class="faq-chatbot__disclaimer">
      <span>Keine Beratung. Angaben ohne Gewähr; bitte Kursseite prüfen.</span>
    </div>
  </div>
</div>

<script>
function faqbot() {
  return {
    open: false,
    q: '',
    messages: [],
    defaultTopics: [
      { id: 'fees', label: 'Kosten' },
      { id: 'registration', label: 'Anmeldung' },
      { id: 'cpd', label: 'CPD/ECTS' },
      { id: 'venue', label: 'Ort' }
    ],
    push(role, html) {
      this.messages.push({ id: crypto.randomUUID(), role, html });
      this.$nextTick(() => this.scrollToBottom());
    },
    scrollToBottom() {
      if (this.$refs.messagesContainer) {
        this.$refs.messagesContainer.scrollTop = this.$refs.messagesContainer.scrollHeight;
      }
    },
    quick(label) {
      this.q = label;
      this.send();
    },
    async send() {
      const q = this.q.trim();
      if (!q) return;
      this.push('user', q);
      this.q = '';
      try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const res = await fetch('/api/faqbot', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
          },
          body: JSON.stringify({ q })
        });
        const data = await res.json();
        if (data.status === 'ok') {
          let html = data.answer.replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');
          if (data.links?.length) {
            html += '<ul>' +
              data.links.map(l => `<li><a href="${l.url}">${l.label}</a></li>`).join('') +
              '</ul>';
          }
          this.push('bot', html);
        } else {
          let html = data.message;
          if (data.topics?.length) {
            html += '<div class="faq-chatbot__suggestion-buttons">' +
              data.topics.map(t => `<button type="button" class="faq-chatbot__suggestion-btn"
                onclick="document.querySelector('[x-data]').__x.$data.quick('${t.label}')">
                ${t.label}</button>`).join('') + '</div>';
          }
          if (data.contact) {
            html += `<p class="faq-chatbot__contact-link">${data.contact.text}
              <a href="${data.contact.url}">${data.contact.url}</a></p>`;
          }
          this.push('bot', html);
        }
      } catch (e) {
        this.push('bot', 'Entschuldigung, etwas ist schief gelaufen.');
      }
    }
  }
}
</script>
