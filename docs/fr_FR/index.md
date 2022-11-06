# Plugin Speedtest by Ookla

Ce plugin permet de tester la bande passante internet à l'aide de [Speedtest by Ookla](https://www.speedtest.net).

## Configuration du plugin

Après téléchargement du plugin, il faut l'activer et installer ses dépendances.

## Configuration des équipements

- **Nom de l’équipement** : nom de votre équipement Speedtest by Ookla
- **Objet parent** : indique l’objet parent auquel appartient l’équipement
- **Catégorie** : les catégories de l’équipement (il peut appartenir à plusieurs catégories)
- **Activer** : permet de rendre votre équipement actif
- **Visible** : rend votre équipement visible sur le Dashboard
- **Auto-actualisation** : cron définissant la fréquence de rafraîchissement des commandes infos de l'équipement et de la liste des serveurs les plus proches
- **ID du serveur de test** : ID du serveur de test de la bande passante internet (à utiliser uniquement si le serveur choisi automatiquement retourne des valeurs erronées)
- **Désactiver les erreurs** : cocher cette case pour désactiver les erreurs lorsque votre connexion internet est hors service

> **IMPORTANT**
>
> Le plugin accepte automatiquement les conditions générales d'utilisation du paquet :
>
> ==============================================================================
> You may only use this Speedtest software and information generated
> from it for personal, non-commercial use, through a command line
> interface on a personal computer. Your use of this software is subject
> to the End User License Agreement, Terms of Use and Privacy Policy at
> these URLs:
> https://www.speedtest.net/about/eula
> https://www.speedtest.net/about/terms
> https://www.speedtest.net/about/privacy
> ==============================================================================
> License acceptance recorded. Continuing.
> ==============================================================================
> Ookla collects certain data through Speedtest that may be considered
> personally identifiable, such as your IP address, unique device
> identifiers or location. Ookla believes it has a legitimate interest
> to share this data with internet providers, hardware manufacturers and
> industry regulators to help them understand and create a better and
> faster internet. For further information including how the data may be
> shared, where the data may be transferred and Ookla's contact details,
> please see our Privacy Policy at:
> http://www.speedtest.net/privacy
> ==============================================================================
> License acceptance recorded. Continuing.

> **Note**
>
> L'IP interne et l'IP externe retournées sont identiques si votre serveur accède à internet en IPv6