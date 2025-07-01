@component('mail::message')
# Bonjour {{ $technicien->prenom }} {{ $technicien->nom }},

Votre compte technicien a été créé avec succès sur notre plateforme.

**Voici vos informations de connexion :**
Email: {{ $technicien->email }}
Mot de passe temporaire: {{ $password }}

@component('mail::button', ['url' => route('login'), 'color' => 'primary'])
Se connecter
@endcomponent

**Sécurité importante :**
Nous vous recommandons de changer votre mot de passe dès votre première connexion.

Merci,
L'équipe ICAR
@endcomponent
