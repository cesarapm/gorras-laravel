@component('mail::message')
# Activación de Cuenta

Hola {{ $customer->nombre }},

Gracias por registrarte en nuestra plataforma.

Por favor, haz clic en el botón a continuación para activar tu cuenta:

@component('mail::button', ['url' => $url])
Activar Cuenta
@endcomponent

Si no creaste esta cuenta, puedes ignorar este mensaje.

Saludos,<br>
{{ config('app.name') }}
@endcomponent
