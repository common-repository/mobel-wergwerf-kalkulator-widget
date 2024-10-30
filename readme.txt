=== Möbel Wegwerf Kalkulator - Widget ===
Tags: widget, möbel, moebel, gebraucht, gebrauchtmöbel, gebrauchtmoebel, sperrmüll, sperrmuell, altmöbel, altmoebel, abfall
Donate link: https://www.paypal.com/donate/?token=YWilFyNamlCmdtZQqaoSGeOPvZeu_sBt8OAImCbewdL7-504a_byvci_1XFPuofx3h-YqW&country.x=DE&locale.x=DE
Requires at least: 5.0
Tested up to: 5.7.2
Requires PHP: 5.0
Stable tag: 2021.05.001
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

With this widget, you can search for the estimated amount of furniture per week which is being thrown away in a German city.

== Description ==

= Deutsch =
Mit diesem Widget kann nach der Anzahl an Möbeln pro Woche, die in einer bestimmbaren deutschen Stadt weggeworfen werden, gesucht werden.
Um die jeweilige Zahl zu erhalten, kommuniziert das Widget mit den Servern von weitergeben.org. Es werden zwei verschiedene WordPress-Funktionen aufgerufen, eine für die automatische Vervollständigung des Stadtnames in der Widget-Eingabe und die andere, um die tatsächliche Schätzung für die Stadt abzurufen.

Optionen:
* Standardstadt: Die voreingestellte Stadt für jeden Besucher.
* Stadt änderbar: Regelt ob der Benutzer das Suchfeld editieren kann.
* Link anzeigen: Regelt ob der Link nach https://weitergeben.org/wo-landen-altmoebel im Widget angezeigt wird.

Es werden keinerlei Daten gesammelt.

= English =
With this widget, you can search for the estimated amount of furniture per week which is being thrown away in a German city.
To get the estimations the widget communicates with the weitergeben.org servers. It calls two different wordpress-rest functions, one for autocompletion in the widget input and the other to get the actual estimation for a city.

Options:
* Default city: The default city for every user, showing in the searchfield.
* City changeable: Controls if the default city in the searchfield should be changeable by the user.
* Show link: Controls if the link to https://weitergeben.org/wo-landen-altmoebel is shown in the widget.

No data is being collected.

== Installation ==
This section describes how to install the plugin and get it working.

1. Upload the plugin files to the `/wp-content/plugins/plugin-name` directory, or install the plugin through the WordPress plugins screen directly.
1. Activate the plugin through the \'Plugins\' screen in WordPress.
1. Use the Appearance->Widgets secction to drag & drop the widget in your sidebar or widget-area.
1. Customize the widget through the options.

== Changelog ==

= 2021.05.001 =
* Tested newer WordPress version
* Fixed REST API call

= 2019.09.002 =
* Fixed error in the admin area options
* Made css only target widget
* Added Icon

= 2019.09.001 =
* First version
