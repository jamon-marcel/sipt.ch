@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            {{ config('app.name') }}
        @endcomponent
    @endslot

    {{-- Body --}}
    {{ $slot }}

    {{-- Subcopy --}}
    @isset($subcopy)
        @slot('subcopy')
            @component('mail::subcopy')
                {{ $subcopy }}
            @endcomponent
        @endslot
    @endisset

    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
        Adresse
        SIPT Schweizer Institut für Psychotraumatologie
        Neuwiesenstrasse 95
        CH-8400 Winterthur
        
        Fragen zur Ausbildung
        Prof. Dr. phil. habil. Rosmarie Barwinski
        Telefon: (0041) 52 – 213 41 12
        E-Mail: rb@sipt.ch
        
        Administrative Fragen
        Beatrice Roncoroni und Nadine Raue
        Telefon: (0041) 071 – 886 48 24
        E-Mail: sekretariat@sipt.ch
        
        Module online buchen
        www.sipt.ch
        @endcomponent
    @endslot
@endcomponent
