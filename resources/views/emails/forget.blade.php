<x-mail::message>
    Hello {{ $user->name }}
 
    Reset your Password.
 
    <x-mail::button :url="route('reset-password', $user->remember_token)">
        Reset Your Password
    </x-mail::button>
 
    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>