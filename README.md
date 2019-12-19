This is an OpenSource project by studer + raimann ag, CH-Burgdorf (https://studer-raimann.ch)

We have created an UI hook plugin because auth plugins currently not working properly

## Google web client config
TODO: Link to create google web client

You need to authenticate the follow redirect url
```
https://your-domain/login.php?target=uihk_srgoogacauth
```

For the plugin config you need the client id and the client secret

## Installation

### Install SrGoogleAccountAuth-Plugin
Start at your ILIAS root directory
```bash
mkdir -p Customizing/global/plugins/Services/UIComponent/UserInterfaceHook
cd Customizing/global/plugins/Services/UIComponent/UserInterfaceHook
git clone https://github.com/studer-raimann/SrGoogleAccountAuth.git SrGoogleAccountAuth
```
Update and activate the plugin in the ILIAS Plugin Administration

### Some screenshots
Login screen:
![Login screen](./doc/screenshots/login_screen.png)

### Requirements
* ILIAS 5.3 or ILIAS 5.4
* PHP >=7.0

### Adjustment suggestions
* External users can report suggestions and bugs at https://plugins.studer-raimann.ch/goto.php?target=uihk_srsu_PLGOOGLEAUTH
* Adjustment suggestions by pull requests via github
* Customer of studer + raimann ag: 
	* Adjustment suggestions which are not yet worked out in detail by Jira tasks under https://jira.studer-raimann.ch/projects/PLGOOGLEAUTH
	* Bug reports under https://jira.studer-raimann.ch/projects/PLGOOGLEAUTH

### ILIAS Plugin SLA
Wir lieben und leben die Philosophie von Open Source Software! Die meisten unserer Entwicklungen, welche wir im Kundenauftrag oder in Eigenleistung entwickeln, stellen wir öffentlich allen Interessierten kostenlos unter https://github.com/studer-raimann zur Verfügung.

Setzen Sie eines unserer Plugins professionell ein? Sichern Sie sich mittels SLA die termingerechte Verfügbarkeit dieses Plugins auch für die kommenden ILIAS Versionen. Informieren Sie sich hierzu unter https://studer-raimann.ch/produkte/ilias-plugins/plugin-sla.

Bitte beachten Sie, dass wir nur Institutionen, welche ein SLA abschliessen Unterstützung und Release-Pflege garantieren.
