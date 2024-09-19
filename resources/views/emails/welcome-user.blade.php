<x-mail::message>
# Bienvenue

Merci, {{ $data->username }} de vous être inscris sur LaraGram avec {{ $data->email }}

Cordialement,<br>
{{ config('app.name') }}
</x-mail::message>
