<x-mail::message>
    # Parabéns, {{ $userName }}!

    A sua instituição **{{ $institutionName }}** foi aprovada com sucesso na plataforma SocialHelp.

    Agora você pode aceder ao painel de controlo e começar a gerir as suas atividades.

    <x-mail::button :url="$loginUrl">
        Aceder ao Painel
    </x-mail::button>

    Obrigado,<br>
    {{ config('app.name') }}
</x-mail::message>