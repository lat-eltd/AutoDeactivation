<?php

namespace srag\Notifications4Plugin\AutoDeactivation\Sender;

use ilMail;
use ilMailError;
use ilMailException;
use ilObjUser;
use srag\DIC\AutoDeactivation\DICTrait;
use srag\Notifications4Plugin\AutoDeactivation\Exception\Notifications4PluginException;
use srag\Notifications4Plugin\AutoDeactivation\Utils\Notifications4PluginTrait;
use Throwable;

/**
 * Class InternalMailSender
 *
 * Sends the notification internal in ILIAS. Based on the settings, the mail is also forwarded to the users external e-mail address
 *
 * @package srag\Notifications4Plugin\AutoDeactivation\Sender
 */
class InternalMailSender implements Sender
{

    use DICTrait;
    use Notifications4PluginTrait;

    /**
     * User-ID or login of bcc
     *
     * @var string|int
     */
    protected $bcc = "";
    /**
     * User-ID or login of cc
     *
     * @var string|int
     */
    protected $cc = "";
    /**
     * @var ilMail
     */
    protected $mailer;
    /**
     * @var string
     */
    protected $message = "";
    /**
     * Store the mail in the sent box of the sender
     *
     * @var bool
     */
    protected $save_in_sent_box = true;
    /**
     * @var string
     */
    protected $subject = "";
    /**
     * User-ID or login of sender
     *
     * @var int|string
     */
    protected $user_from = 0;
    /**
     * User-ID or login of receiver
     *
     * @var int|string
     */
    protected $user_to = "";


    /**
     * InternalMailSender constructor
     *
     * @param int|string|ilObjUser $user_from Should be the user-ID from the sender, you can also pass the login
     * @param int|string|ilObjUser $user_to   Should be the login of the receiver, you can also pass a user-ID
     */
    public function __construct($user_from = 0, $user_to = "")
    {
        if ($user_from) {
            $this->setUserFrom($user_from);
        }
        if ($user_to) {
            $this->setUserTo($user_to);
        }
    }


    /**
     * @return array|string
     */
    public function getBcc()
    {
        return $this->bcc;
    }


    /**
     * @inheritDoc
     */
    public function setBcc($bcc)
    {
        $this->bcc = $this->idOrUser2login($bcc);

        return $this;
    }


    /**
     * @return array|string
     */
    public function getCc()
    {
        return $this->cc;
    }


    /**
     * @inheritDoc
     */
    public function setCc($cc)
    {
        $this->cc = $this->idOrUser2login($cc);

        return $this;
    }


    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }


    /**
     * @inheritDoc
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }


    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }


    /**
     * @inheritDoc
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }


    /**
     * @return int|string
     */
    public function getUserFrom()
    {
        return $this->user_from;
    }


    /**
     * @param int|string|ilObjUser $user_from
     *
     * @return $this
     */
    public function setUserFrom($user_from)
    {
        if ($user_from instanceof ilObjUser) {
            $user_from = $user_from->getId();
        } else {
            if (is_string($user_from) && !is_numeric($user_from)) {
                // Need user-ID
                $user_from = ilObjUser::_lookupId($user_from);
            }
        }
        $this->user_from = intval($user_from);

        return $this;
    }


    /**
     * @return int|string
     */
    public function getUserTo()
    {
        return $this->user_to;
    }


    /**
     * @param int|string|ilObjUser $user_to
     *
     * @return $this
     */
    public function setUserTo($user_to)
    {
        $this->user_to = $this->idOrUser2login($user_to);

        return $this;
    }


    /**
     * @return boolean
     */
    public function isSaveInSentBox()
    {
        return $this->save_in_sent_box;
    }


    /**
     * Save email in sent box of sender?
     *
     * @param bool $state
     */
    public function setSaveInSentBox($state)
    {
        $this->save_in_sent_box = $state;
    }


    /**
     * @inheritDoc
     */
    public function reset()
    {
        $this->message = "";
        $this->subject = "";
        $this->user_from = 0;
        $this->user_to = "";
        $this->bcc = "";
        $this->bcc = "";
        $this->save_in_sent_box = true;
        $this->mailer = null;

        return $this;
    }


    /**
     * @inheritDoc
     * @throws ilMailException
     * @throws Throwable
     * @throws Notifications4PluginException
     */
    public function send() : void
    {
        $this->mailer = new ilMail($this->getUserFrom());

        $this->mailer->setSaveInSentbox($this->isSaveInSentBox());

        $errors = $this->mailer->sendMail($this->getUserTo(), $this->getCc(), $this->getBcc(), $this->getSubject(), $this->getMessage(), [], false);

        if (!empty($errors)) {
            $error = $errors[0];
            if ($error instanceof ilMailError) {
                throw new ilMailException(self::dic()->language()->txt($error->getLanguageVariable()));
            } else {
                if ($error instanceof Throwable) {
                    throw $error;
                } else {
                    if (is_string($error)) {
                        throw new Notifications4PluginException($error);
                    } else {
                        throw new Notifications4PluginException('Unknown exception when sending mail.');
                    }
                }
            }
        }
    }


    /**
     * @inheritDoc
     */
    public function setFrom($from)
    {
        $this->setUserFrom($from);

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function setTo($to)
    {
        $this->setUserTo($to);

        return $this;
    }


    /**
     * Convert User-ID to login
     *
     * @param int|string|ilObjUser $id_or_user
     *
     * @return mixed
     */
    protected function idOrUser2login($id_or_user)
    {
        if ($id_or_user instanceof ilObjUser) {
            return $id_or_user->getLogin();
        } else {
            if (is_numeric($id_or_user)) {
                // Need login
                $data = ilObjUser::_lookupName($id_or_user);

                return $data["login"];
            }
        }

        return $id_or_user;
    }
}
