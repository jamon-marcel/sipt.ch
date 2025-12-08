<div x-data="chatbot()" class="faq-chatbot is-ai">
  <button @click="open = !open" x-show="!open" class="faq-chatbot__toggle">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z" />
    </svg>
    <span>Chatbot (AI)</span>
  </button>

  <div x-show="open" x-transition class="faq-chatbot__panel">
    <div class="faq-chatbot__header">
      <div>
        <p class="faq-chatbot__title">SIPT Assistent</p>
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
            <template x-for="suggestion in suggestions" :key="suggestion">
              <button @click="askSuggestion(suggestion)" class="faq-chatbot__topic-btn" x-text="suggestion"></button>
            </template>
          </div>
        </div>
      </template>

      <template x-for="m in messages" :key="m.id">
        <div class="faq-chatbot__message" :class="'faq-chatbot__message--' + m.role">
          <div class="faq-chatbot__message-bubble">
            <div x-html="m.html"></div>
            <template x-if="m.sources && m.sources.length > 0">
              <ul class="faq-chatbot__sources">
                <template x-for="source in m.sources" :key="source.title">
                  <li x-show="source.url">
                    <a :href="source.url" x-text="source.title"></a>
                  </li>
                </template>
              </ul>
            </template>
          </div>
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
      <input 
        x-model="question" 
        type="text" 
        class="faq-chatbot__input" 
        placeholder="Ihre Frage..."
        :disabled="loading"
      >
      <button class="faq-chatbot__submit" :disabled="loading || !question.trim()">Senden</button>
    </form>

    {{-- <div class="faq-chatbot__disclaimer">
      <span>KI-generierte Antworten. Angaben ohne Gewähr.</span>
    </div> --}}

  </div>
</div>

<script>
function chatbot() {
  return {
    open: false,
    question: '',
    messages: [],
    history: [],
    loading: false,
    suggestions: [
      'Was kostet eine Weiterbildung?',
      'Wie melde ich mich an?',
      'Was ist der CAS Abschluss?',
      'Welche Kurse gibt es?'
    ],

    push(role, html, sources = []) {
      // Map 'assistant' to 'bot' for CSS class compatibility
      const cssRole = role === 'assistant' ? 'bot' : role;
      const msg = { 
        id: crypto.randomUUID(), 
        role: cssRole, 
        html,
        sources 
      };
      this.messages.push(msg);
      
      // Add to history for context
      this.history.push({
        role: role === 'user' ? 'user' : 'assistant',
        content: html.replace(/<[^>]*>/g, '') // Strip HTML for history
      });
      
      // Keep history manageable
      if (this.history.length > 10) {
        this.history = this.history.slice(-10);
      }

      this.$nextTick(() => {
        if (cssRole === 'bot') {
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

    askSuggestion(text) {
      this.question = text;
      this.send();
    },

    reset() {
      this.open = false;
      this.messages = [];
      this.history = [];
      this.question = '';
      this.loading = false;
    },

    async send() {
      const q = this.question.trim();
      if (!q || this.loading) return;

      this.push('user', this.escapeHtml(q));
      this.question = '';
      this.loading = true;
      this.$nextTick(() => this.scrollToBottom());

      try {
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const res = await fetch('/api/chatbot', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
          },
          body: JSON.stringify({ 
            question: q,
            history: this.history.slice(0, -1)
          })
        });

        const data = await res.json();
        this.loading = false;

        if (data.status === 'ok' || data.status === 'fallback') {
          this.push('assistant', this.formatAnswer(data.answer), data.sources || []);
        } else {
          this.push('assistant', 'Entschuldigung, etwas ist schief gelaufen. Bitte versuchen Sie es erneut.');
        }
      } catch (e) {
        this.loading = false;
        this.push('assistant', 'Entschuldigung, die Verbindung ist fehlgeschlagen.');
        console.error('Chatbot error:', e);
      }
    },

    escapeHtml(text) {
      const div = document.createElement('div');
      div.textContent = text;
      return div.innerHTML;
    },

    formatAnswer(text) {
      // Convert markdown-like formatting to HTML
      return text
        .replace(/\n\n/g, '</p><p>')
        .replace(/\n/g, '<br>')
        .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
        .replace(/\*(.*?)\*/g, '<em>$1</em>')
        .replace(/^/, '<p>')
        .replace(/$/, '</p>');
    }
  }
}
</script>
