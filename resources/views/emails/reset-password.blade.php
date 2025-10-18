<x-mail::message>
# Reset Password

Halo,

Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.

<x-mail::button :url="$resetUrl">
Reset Password
</x-mail::button>

Link ini akan kadaluarsa dalam 60 menit.

Jika Anda tidak meminta reset password, abaikan email ini.

Terima kasih,  
{{ config('app.name') }}
</x-mail::message>
