<template>
  <div class="overlay is-visible">
    <div class="overlay__inner is-wide">
      <div>
        <a href @click.prevent="hideOverlay()" class="feather-icon">
          <x-icon size="24"></x-icon>
        </a>
        <h2>Rechnungen erstellen oder bearbeiten</h2>
        <div class="widget-invoice-type-selector">
          <div>
            <div class="sa-xs">Um eine bereits ausgestellte Rechnung anzupassen, wählen Sie Rechung bearbeiten.</div>
            <div>
              <router-link :to="{ name: 'backoffice-edit-invoice' }" class="btn-primary is-sm">Rechung bearbeiten</router-link>
            </div>
          </div>
          <div>
            <div class="sa-xs">Um eine Rechnung für Student:innen mit/ohne Buchung zu erstellen, wählen Sie «Modulrechnung».</div>
            <div>
              <router-link :to="{ name: 'backoffice-create-invoice' }" class="btn-primary is-sm">Modulrechnung erstellen</router-link>
            </div>
          </div>
          <div>
            <div class="sa-xs">Wählen Sie «manuelle Rechnung» für Rechnungen an nicht registrierte Personen und/oder Spezialfälle (wie Charta).</div>
            <router-link :to="{ name: 'backoffice-create-manual-invoice' }" class="btn-primary is-sm">Manuelle Rechnung erstellen</router-link>
          </div>
        </div>
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

