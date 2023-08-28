# Plugin Speedtest by Ookla

This plugin allows to test internet bandwidth using [Speedtest by Ookla](https://www.speedtest.net).

## Plugin Setup

After downloading the plugin, you must activate it and install its dependencies.

## Equipment configuration

- **Equipment name**: allows you to name your equipment
- **Parent object**: allows you to indicate the parent object to which the equipment belongs
- **Category**: allows you to choose the categories of the equipment (it can belong to several categories)
- **Activate**: makes your equipment active
- **Visible**: allows you to make your equipment visible
- **Auto-refresh**: allows you to define the refresh frequency of the info commands and the list of the closest servers
- **Templates**: allows the use of templates dedicated to the plugin instead of core widgets (settings in Advanced equipment configuration => Display tab => Widget section)
- **Test server ID**: allows you to choose a specific test server (to be used only if the automatically chosen server returns incorrect values)
- **Disable errors**: allows you to disable errors when your internet connection is down
- **Equipment description**: allows you to give a description to your equipment
- **List of closest servers**: displays the list of closest servers

> **Important**
>
> The plugin automatically accepts the terms of use of the `speedtest` package:
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
> The internal IP and the external IP returned are identical if your server accesses the internet in IPv6.