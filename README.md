# AutoDeactivation

This plugin introduces a cron job which deactivates unused user accounts, sending notification mails before and when doing so. The inactivity is measured by a certain timespan since the last login, or since the creation date if no login was ever performed. All parameters are configurable.

## Getting Started

### Requirements

* ILIAS 5.3.x / 5.4.x
* PHP >=7.0

### Installing

Start at your ILIAS root directory
```bash
mkdir -p Customizing/global/plugins/Services/Cron/CronHook
cd Customizing/global/plugins/Services/Cron/CronHook
git clone https://github.com/studer-raimann/AutoDeactivation.git
```
Update, activate and config the plugin in the ILIAS Plugin Administration

## Authors

This is an OpenSource project by studer + raimann ag (https://studer-raimann.ch)

## License

This project is licensed under the GPL v3 License 

### ILIAS Plugin SLA

We love and live the philosophy of Open Source Software! Most of our developments, which we develop on behalf of customers or on our own account, are publicly available free of charge to all interested parties at https://github.com/studer-raimann.

Do you use one of our plugins professionally? Secure the timely availability of this plugin for the upcoming ILIAS versions via SLA. Please inform yourself under https://studer-raimann.ch/produkte/ilias-plugins/plugin-sla.

Please note that we only guarantee support and release maintenance for institutions that sign a SLA.