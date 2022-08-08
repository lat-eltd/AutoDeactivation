<?php

namespace srag\Notifications4Plugin\AutoDeactivation\Sender;

use ilMail;
use ilMailbox;
use ilMimeMail;
use ilObjUser;
use srag\DIC\AutoDeactivation\DICTrait;
use srag\Notifications4Plugin\AutoDeactivation\Exception\Notifications4PluginException;
use srag\Notifications4Plugin\AutoDeactivation\Utils\Notifications4PluginTrait;

/**
 * Class vcalendarSender
 *
 * Sends the notification to an external E-Mail with calendar dates
 *
 * @package srag\Notifications4Plugin\AutoDeactivation\Sender
 */
class vcalendarSender implements Sender
{

    use DICTrait;
    use Notifications4PluginTrait;

    const METHOD_CANCEL = "CANCEL";
    const METHOD_REQUEST = "REQUEST";
    /**
     * @var array
     */
    protected $attachments = [];
    /**
     * @var string|array
     */
    protected $bcc = [];
    /**
     * @var string|array
     */
    protected $cc = [];
    /**
     * @var int
     */
    protected $endTime = 0;
    /**
     * @var string
     */
    protected $location = "";
    /**
     * @var ilMail
     */
    protected $mailer;
    /**
     * @var string
     */
    protected $message = "";
    /**
     * @var string
     */
    protected $method = self::METHOD_REQUEST;
    /**
     * @var int
     */
    protected $sequence = 0;
    /**
     * @var int
     */
    protected $startTime = 0;
    /**
     * @var string
     */
    protected $subject = "";
    /**
     * @var string|array
     */
    protected $to = "";
    /**
     * @var string
     */
    protected $uid = "";
    /**
     * User-ID or login of sender
     *
     * @var int|string
     */
    protected $user_from = 0;


    /**
     * vcalendarSender constructor
     *
     * @param int|string|ilObjUser $user_from Should be the user-ID from the sender, you can also pass the login
     * @param string|array         $to        E-Mail address or array of addresses
     * @param string               $method
     * @param string               $uid
     * @param int                  $startTime Timestamp
     * @param int                  $endTime   Timestamp
     * @param int                  $sequence
     */
    public function __construct($user_from = 0, $to = "", string $method = self::METHOD_REQUEST, string $uid = "", int $startTime = 0, int $endTime = 0, int $sequence = 0)
    {

        if ($user_from) {
            $this->setUserFrom($user_from);
        }

        $this->to = $to;

        $this->method = $method;
        $this->uid = $uid;
        $this->startTime = $startTime;
        $this->endTime = $endTime;
        $this->sequence = $sequence;
    }


    /**
     * Add an attachment
     *
     * @param string $file Full path of the file to attach
     *
     * @return $this
     */
    public function addAttachment($file)
    {
        if (is_file($file)) {
            $this->attachments[] = $file;
        }

        return $this;
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
        $this->bcc = $bcc;
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
        $this->cc = $cc;

        return $this;
    }


    /**
     * @param string $mime_boundary
     *
     * @return string
     */
    public function getIcalEvent($mime_boundary)
    {
        $iluser = new ilObjUser($this->getUserFrom());

        //Create Email Body (HTML)
        $message = "--$mime_boundary\r\n";
        $message .= "Content-Type: text/html; charset=UTF-8\n";
        $message .= "Content-Transfer-Encoding: 8bit\n\n";
        $message .= "<html>\n";
        $message .= "<body>\n";
        $message .= nl2br($this->message);
        //$message .= "<p>".$description."</p>";
        $message .= "</body>\n";
        $message .= "</html>\n";
        $message .= "--$mime_boundary\r\n";

        $status = "CONFIRMED";
        if ($this->method == self::METHOD_CANCEL) {
            $status = "CANCELLED";
        }

        $ical = 'BEGIN:VCALENDAR' . "\r\n" . 'PRODID:-//ILIAS' . "\r\n" . 'VERSION:2.0' . "\r\n" . 'METHOD:' . $this->method . "\r\n"
            . 'BEGIN:VTIMEZONE' . "\r\n" . 'TZID:Europe/Paris' . "\r\n" . 'X-LIC-LOCATION:Europe/Paris' . "\r\n" . 'BEGIN:DAYLIGHT' . "\r\n"
            . 'TZOFFSETFROM:+0100' . "\r\n" . 'TZOFFSETTO:+0200' . "\r\n" . 'TZNAME:CEST' . "\r\n" . 'DTSTART:19700329T020000' . "\r\n"
            . 'RRULE:FREQ=YEARLY;BYMONTH=3;BYDAY=-1SU' . "\r\n" . 'END:DAYLIGHT' . "\r\n" . 'BEGIN:STANDARD' . "\r\n" . 'TZOFFSETFROM:+0200' . "\r\n"
            . 'TZOFFSETTO:+0100' . "\r\n" . 'TZNAME:CET' . "\r\n" . 'DTSTART:19701025T030000' . "\r\n" . 'RRULE:FREQ=YEARLY;BYMONTH=10;BYDAY=-1SU'
            . "\r\n" . 'END:STANDARD' . "\r\n" . 'END:VTIMEZONE' . "\r\n" . 'BEGIN:VEVENT' . "\r\n" . 'UID: ' . $this->uid . "\r\n"
            . 'DESCRIPTION:Reminder' . "\r\n" . 'DTSTART;TZID=Europe/Paris:' . date("Ymd\THis", $this->startTime) . "\r\n"
            . 'DTEND;TZID=Europe/Paris:' . date("Ymd\THis", $this->endTime) . "\r\n" . 'DTSTAMP:' . date("Ymd\TGis") . "\r\n" . 'LAST-MODIFIED:'
            . date("Ymd\TGis") . "\r\n" . 'ORGANIZER;CN="' . $this->from . '":MAILTO:' . $iluser->getEmail() . "\r\n" . 'ATTENDEE;CN="' . $this->to
            . '";ROLE=REQ-PARTICIPANT;RSVP=TRUE:MAILTO:' . $this->to . "\r\n" . 'SUMMARY:' . $this->subject . "\r\n" . 'LOCATION:' . $this->location
            . "\r\n" . 'SEQUENCE:' . $this->sequence . "\r\n" . 'PRIORITY:5' . "\r\n" . 'STATUS:' . $status . "\r\n" . 'TRANSP:OPAQUE' . "\r\n"
            . 'CLASS:PUBLIC' . "\r\n" . 'BEGIN:VALARM' . "\r\n" . 'TRIGGER:-PT15M' . "\r\n" . 'ACTION:DISPLAY' . "\r\n" . 'END:VALARM' . "\r\n"
            . 'END:VEVENT' . "\r\n" . 'END:VCALENDAR' . "\r\n";
        $message .= 'Content-Type: text/calendar;name="meeting.ics";method=' . $this->method . "\n";
        $message .= "Content-Transfer-Encoding: 8bit\n\n";
        $message .= $ical;

        return $message;
    }


    /**
     * @return array|string
     */
    public function getTo()
    {
        return $this->to;
    }


    /**
     * @inheritDoc
     */
    public function setTo($to)
    {
        $this->to = $to;

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
     * @inheritDoc
     */
    public function reset()
    {
        $this->from = "";
        $this->to = "";
        $this->subject = "";
        $this->message = "";
        $this->uid = "";
        $this->method = self::METHOD_REQUEST;
        $this->sequence = 0;
        $this->startTime = 0;
        $this->endTime = 0;
        $this->attachments = [];
        $this->cc = [];
        $this->bcc = [];
        $this->mailer = new ilMimeMail();

        return $this;
    }


    /**
     * @inheritDoc
     */
    public function send() : void
    {
        $this->mailer = new ilMail($this->getUserFrom());

        $mbox = new ilMailbox($this->getUserFrom());
        $sent_folder_id = $mbox->getSentFolder();

        //Create Email Headers
        $mime_boundary = "----Meeting Booking----" . MD5(TIME());

        $this->mailer->sendInternalMail($sent_folder_id, $this->getUserFrom(), "", $this->to, "", "", "read", "email", 0, $this->subject, $this->getIcalEvent($mime_boundary), $this->getUserFrom(), 0);

        $this->mailer = new ilMail($this->getUserFrom());

        $iluser = new ilObjUser($this->getUserFrom());
        $headers = "From: " . $iluser->getEmail() . " <" . $iluser->getEmail() . ">\n";
        $headers .= "Reply-To: " . $iluser->getEmail() . " <" . $iluser->getEmail() . ">\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
        $headers .= "Content-class: urn:content-classes:calendarmessage\n";

        $result = false;
        if (!intval(self::dic()->settings()->get("prevent_smtp_globally"))) {
            $result = mail($this->to, $this->subject, $this->getIcalEvent($mime_boundary), $headers);
        }

        if (!$result) {
            throw new Notifications4PluginException("Mailer not returns true");
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
     * Set the location for the message
     *
     * @param string location
     *
     * @return $this
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
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
     * @inheritDoc
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }
}
