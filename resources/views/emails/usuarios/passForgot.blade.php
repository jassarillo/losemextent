@component('mail::message')
# E-mail de cambio de contraseña

**La Secretaría de Administración y Finanzas** !

Estimado Usuario, Hemos recibido una solicitud de cambio de contraseña para el acceso al sistema, 
si no solicitaste el cambio de contraseña puedes ignorar este correo electronico.

El enlace solo estara activo 14 horas.

@component('mail::button', [ 'url' => $url,'color' => 'green' ])
 Generar nueva contraseña 
@endcomponent

Saludos!!!
@endcomponent
