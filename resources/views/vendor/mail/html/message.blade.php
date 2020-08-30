@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ config('app.name') }}
@endcomponent
@endslot

![Logo de la SAF][logo]

{{-- Body --}}
{{ $slot }}

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.

[Secretaría de Administración y Finanzas][url_saf]  
Dirección General de Tecnologías y Comunicaciones

[url_saf]: {{ url('http://www.finanzas.cdmx.gob.mx/') }}
@endcomponent
@endslot

[logo]: {{ url('/assets/media/logos/').'/'.env('APP_LOGO') }}
@endcomponent