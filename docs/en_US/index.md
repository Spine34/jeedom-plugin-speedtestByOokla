# Speedtest by Ookla plugin

This plugin allows you to test the Internet bandwidth using [Speedtest by Ookla](https://www.speedtest.net).

## Plugin configuration

After downloading the plugin, you have to activate it and install its dependencies.

## Equipment configuration

- **Equipment name** : allows you to give a name of your equipment
- **Parent object** : makes it possible to indicate the parent object to which the equipment belongs
- **Category** : allows you to choose the categories of the equipment (it can belong to several categories)
- **Activate** : allows you to make your equipment active
- **Visible** : allows you to make your equipment visible
- **Self-actualization** : allows you to define the refresh frequency of info commands and the closest server list
- **Templates** : allows you to use the templates dedicated to the plugin instead of the core widgets (settings in Advanced equipment configuration => Display tab => Widget section)
- **Test server ID** : allows you to choose a specific test server (to be used only if the server chosen automatically returns erroneous values)
- **Deactivate errors** : allows you to deactivate errors when your Internet connection is out of service
- **Equipment description** : allows you to describe your equipment
- **Closest servers list** : allows you to display the closest server list

> **Important**
>
> The plugin automatically accepts the general conditions of use of the `speedtest` package :
> ```
> ==============================================================================
> 
> You may only use this Speedtest software and information generated
> from it for personal, non-commercial use, through a command line
> interface on a personal computer. Your use of this software is subject
> to the End User License Agreement, Terms of Use and Privacy Policy at
> these URLs:
> 
>         https://www.speedtest.net/about/eula
>         https://www.speedtest.net/about/terms
>         https://www.speedtest.net/about/privacy
> 
> ==============================================================================
> 
> License acceptance recorded. Continuing.
> 
> ==============================================================================
> 
> Ookla collects certain data through Speedtest that may be considered
> personally identifiable, such as your IP address, unique device
> identifiers or location. Ookla believes it has a legitimate interest
> to share this data with internet providers, hardware manufacturers and
> industry regulators to help them understand and create a better and
> faster internet. For further information including how the data may be
> shared, where the data may be transferred and Ookla's contact details,
> please see our Privacy Policy at:
> 
>        http://www.speedtest.net/privacy
> 
> ==============================================================================
> 
> License acceptance recorded. Continuing.
> ```

> **Note**
>
> The internal IP and the returned external IP are identical if your server accesses the internet in IPv6.