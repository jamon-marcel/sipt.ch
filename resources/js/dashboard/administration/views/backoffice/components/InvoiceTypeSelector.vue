<template>
  <div class="overlay is-visible">
    <div class="overlay__inner">
      <div>
        <a href @click.prevent="hideOverlay()" class="feather-icon">
          <x-icon size="24"></x-icon>
        </a>
        <h2>Rechnungstyp wählen</h2>
        <div class="sa-xs">Um eine Rechnung für Student:innen mit/ohne Buchung zu erstellen, wählen Sie «Modulrechnung».</div>
        <div class="sa-md">
          <router-link :to="{ name: 'backoffice-create-invoice' }" class="btn-primary is-sm">Modulrechnung</router-link>
        </div>
        <div class="sa-xs">Wählen Sie «manuelle Rechnung» für Rechnungen an nicht registrierte Personen und/oder Spezialfälle (wie Charta).</div>
        <router-link :to="{ name: 'backoffice-create-manual-invoice' }" class="btn-primary is-sm">manuelle Rechnung</router-link>
      </div>
    </div>
  </div>
</template>
<script>

// Icons
import { XIcon } from "vue-feather-icons";

export default {
  
  components: {
    XIcon
  },

  methods: {
    hideOverlay() {
      this.$parent.hideTypeSelectorOverlay();
    },
  }
}
</script>

