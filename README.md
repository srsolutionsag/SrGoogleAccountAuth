# SrGoogleAccountAuth ILIAS Plugin

Authenticate with Google accounts in ILIAS

This is an OpenSource project by studer + raimann ag, CH-Burgdorf (https://studer-raimann.ch)

This project is licensed under the GPL-3.0-only license

## Requirements

* ILIAS 5.4.0 - 6.999
* PHP >=7.0

## Installation

Start at your ILIAS root directory

```bash
mkdir -p Customizing/global/plugins/Services/UIComponent/UserInterfaceHook
cd Customizing/global/plugins/Services/UIComponent/UserInterfaceHook
git clone https://github.com/studer-raimann/SrGoogleAccountAuth.git SrGoogleAccountAuth
```

Update, activate and config the plugin in the ILIAS Plugin Administration

## Description

We have created an UI hook plugin because auth plugins currently not working properly

## Google web client config

TODO: Link to create google web client

You need to authenticate the follow redirect url

```
https://your-domain/login.php?target=uihk_srgoogacauth
```

For the plugin config you need the client id and the client secret

Login screen:

![Login screen](./doc/images/login_screen.png)

## Adjustment suggestions

You can report bugs or suggestions at https://plugins.studer-raimann.ch/goto.php?target=uihk_srsu_PLGOOGLEAUTH

## ILIAS Plugin SLA

We love and live the philosophy of Open Source Software! Most of our developments, which we develop on behalf of customers or on our own account, are publicly available free of charge to all interested parties at https://github.com/studer-raimann.

Do you use one of our plugins professionally? Secure the timely availability of this plugin for the upcoming ILIAS versions via SLA. Please inform yourself under https://studer-raimann.ch/produkte/ilias-plugins/plugin-sla.

Please note that we only guarantee support and release maintenance for institutions that sign a SLA.
