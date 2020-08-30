@component('mail::message')
# E-mail de bienvenida

Hola {{ $usuario }}, bienvenido a **La Secretaría de Administración y Finanzas**

Este es el primer paso para Ingresar al sistema, lo primero que debes hacer es confirmar tu correo electrónico 
haciendo clic en el siguiente enlace,

@component('mail::button', [ 'url' => $url,'color' => 'green' ])
    Clic para confirmar tu email
@endcomponent

Por favor, guarda este correo.
Si no puedes ingresar a tu cuenta en el futuro, este correo nos
permitirá ayudarte a restaurar el acceso a tu cuenta.

!Saludos!
@endcomponent
