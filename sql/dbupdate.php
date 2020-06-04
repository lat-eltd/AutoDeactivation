<#1>
<?php
\srag\Plugins\AutoDeactivation\Repository::getInstance()->installTables();
\srag\Plugins\AutoDeactivation\Repository::getInstance()->config()->setValue(
		\srag\Plugins\AutoDeactivation\Config\ConfigFormGUI::KEY_LOCAL_USERS_ONLY,
	1
);
\srag\Plugins\AutoDeactivation\Repository::getInstance()->config()->setValue(
		\srag\Plugins\AutoDeactivation\Config\ConfigFormGUI::KEY_THRESHOLD_IN_DAYS,
	180
);
\srag\Plugins\AutoDeactivation\Repository::getInstance()->config()->setValue(
		\srag\Plugins\AutoDeactivation\Config\ConfigFormGUI::KEY_DAYS_WARNING,
	14
);
\srag\Plugins\AutoDeactivation\Notification\LastNotified::updateDB();
\srag\Notifications4Plugin\AutoDeactivation\Repository::getInstance()->installTables();

$repository = \srag\Notifications4Plugin\AutoDeactivation\Repository::getInstance()->notifications();

if (is_null($repository->getNotificationByName(ilAutoDeactivationConfigGUI::NOTIFICATION_NAME_WARNING))) {
    $notification_warning = $repository->factory()->newInstance();
    $notification_warning->setName(ilAutoDeactivationConfigGUI::NOTIFICATION_NAME_WARNING);
    $notification_warning->setTitle('Warning');
    $notification_warning->setDescription("Mail which will be sent as a warning before a user is deactivated for inactivity.");
    $notification_warning->setSubject("Account Deactivation", "default");
    $notification_warning->setSubject("Account Deactivation", "en");
    $notification_warning->setSubject("Deaktivierung Benutzeraccount", "de");
    $txt_en = "Hello {{user.getFirstname}} {{user.getLastname}}
		
		Your account {{user.getLogin}} has been inactive for {{inactive_for_days}} days. It will be deactivated on {{deactivation_date}}.
		
		To prevent your account from being deactivated, log in with your credentials:
		{{login_link}}";
    $notification_warning->setText(
        $txt_en,
        "default"
    );
    $notification_warning->setText(
        $txt_en,
        "en"
    );
    $notification_warning->setText(
        "Hallo {{user.getFirstname}} {{user.getLastname}}
		
		Ihr Benutzeraccount {{user.getLogin}} ist seit {{inactive_for_days}} Tagen inaktiv und wird am {{deactivation_date}} deaktiviert.
		
		Um dies zu verhindern, loggen Sie sich bitte auf der ILIAS-Installation ein:
		{{login_link}}",
        "de"
    );

    $repository->storeNotification($notification_warning);
}

if (is_null($repository->getNotificationByName(ilAutoDeactivationConfigGUI::NOTIFICATION_NAME_DEACTIVATION))) {
    $notification_deactivation = $repository->factory()->newInstance();
    $notification_deactivation->setName(ilAutoDeactivationConfigGUI::NOTIFICATION_NAME_DEACTIVATION);
    $notification_deactivation->setTitle('Deactivation');
    $notification_deactivation->setDescription("Mail which will be sent when a user has been deactivated for inactivity.");
    $notification_deactivation->setSubject("Account Deactivated", "default");
    $notification_deactivation->setSubject("Account Deactivated", "en");
    $notification_deactivation->setSubject("Benutzeraccount deaktiviert", "de");
    $txt_en = "Hello {{user.getFirstname}} {{user.getLastname}}
		
		Your account {{user.getLogin}} has been deactivated for inactivity. To reactivate your account, please contact an administrator.";
    $notification_deactivation->setText(
        $txt_en,
        "default"
    );
    $notification_deactivation->setText(
        $txt_en,
        "en"
    );
    $notification_deactivation->setText(
        "Hallo {{user.getFirstname}} {{user.getLastname}}
		
		Ihr Benutzeraccount {{user.getLogin}} wurde aufgrund von Inaktivität deaktiviert. Für eine Wiederaktivierung, bitte kontaktieren Sie einen Administrator.",
        "de"
    );
    $repository->storeNotification($notification_deactivation);
}
?>
