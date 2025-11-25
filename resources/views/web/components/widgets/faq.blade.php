<div x-data="faqbot()" class="faq-chatbot">
  <button @click="open = !open" x-show="!open" class="faq-chatbot__toggle">
    FAQ
  </button>

  <div x-show="open" x-transition class="faq-chatbot__panel">
    <div class="faq-chatbot__header">
      <div>
        <p class="faq-chatbot__title">Fragen & Antworten</p>
        <p class="faq-chatbot__subtitle">Schnelle Antworten zu Kursen, Anmeldung, Kosten.</p>
      </div>
      <button @click="reset()" class="faq-chatbot__close">
        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <line x1="18" y1="6" x2="6" y2="18"></line>
          <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
      </button>
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

      <template x-if="loading">
        <div class="faq-chatbot__message faq-chatbot__message--bot">
          <div class="faq-chatbot__message-bubble">
            <div class="faq-chatbot__typing">
              <span></span>
              <span></span>
              <span></span>
            </div>
          </div>
        </div>
      </template>
    </div>

    <form @submit.prevent="send()" class="faq-chatbot__form">
      <input x-model="q" type="text" class="faq-chatbot__input" placeholder="Ihre Frage...">
      <button class="faq-chatbot__submit">Senden</button>
    </form>

    {{-- <div class="faq-chatbot__disclaimer">
      <span>Keine Beratung. Angaben ohne Gewähr; bitte Kursseite prüfen.</span>
    </div> --}}
  </div>
</div>

<script>
function faqbot() {
  return {
    open: false,
    q: '',
    messages: [],
    loading: false,
    defaultTopics: [
      { id: 'fees', label: 'Kosten' },
      { id: 'structure', label: 'Aufbau' },
      { id: 'cas', label: 'CAS Abschluss' },
      { id: 'comparison', label: 'SIPT im Vergleich' }
    ],
    push(role, html) {
      this.messages.push({ id: crypto.randomUUID(), role, html });
      this.$nextTick(() => {
        if (role === 'bot') {
          this.scrollToShowAnswer();
        } else {
          this.scrollToBottom();
        }
      });
    },
    scrollToShowAnswer() {
      if (this.$refs.messagesContainer) {
        const messages = this.$refs.messagesContainer.querySelectorAll('.faq-chatbot__message');
        const lastBotMessage = Array.from(messages).reverse().find(el =>
          el.classList.contains('faq-chatbot__message--bot')
        );

        if (lastBotMessage) {
          const container = this.$refs.messagesContainer;
          const messageTop = lastBotMessage.offsetTop;

          // Scroll to show the answer with 60px padding above to keep the question visible
          container.scrollTo({
            top: Math.max(0, messageTop - 220),
            behavior: 'smooth'
          });
        }
      }
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
    reset() {
      this.open = false;
      this.messages = [];
      this.q = '';
      this.loading = false;
    },
    async send() {
      const q = this.q.trim();
      if (!q) return;
      this.push('user', q);
      this.q = '';
      this.loading = true;
      this.$nextTick(() => this.scrollToBottom());

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

        // Add delay to make it feel more natural
        await new Promise(resolve => setTimeout(resolve, 1500));

        this.loading = false;

        if (data.status === 'ok') {
          let html = data.answer;
          if (data.links?.length) {
            html += '<ul>' +
              data.links.map(l => `<li><a href="${l.url}">${l.label}</a></li>`).join('') +
              '</ul>';
          }
          this.push('bot', html);
        } else {
          let html = data.message;
          if (data.escalation) {
            html += `<p class="faq-chatbot__contact-link">${data.escalation}</p>`;
          }
          this.push('bot', html);
        }
      } catch (e) {
        this.loading = false;
        this.push('bot', 'Entschuldigung, etwas ist schief gelaufen.');
      }
    }
  }
}
</script>
