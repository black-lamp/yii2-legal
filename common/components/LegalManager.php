<?php
/**
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @copyright Copyright (c) 2016 Vladimir Kuprienko
 * @license GNU Public License
 */

namespace bl\legalAgreement\common\components;

use Yii;
use yii\base\Component;
use yii\mail\MailerInterface;

use bl\legalAgreement\common\events\LegalAccept;
use bl\legalAgreement\common\entities\LegalUser;
use bl\legalAgreement\common\entities\LegalUserTokens;

/**
 * Component for manipulations with users and legal agreements
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class LegalManager extends Component
{
    const EVENT_AFTER_ACCEPT = 'afterAccept';


    /**
     * @var string Id of mailer component from app config
     */
    public $mailerComponentId = 'mailer';


    /**
     * Method for accepting legal agreement by user
     *
     * @param integer $user_id
     * @param integer $legal_id
     * @return bool returns `true` if agreement was successfully accepted
     */
    public function accept($user_id, $legal_id)
    {
        $userLegal = new LegalUser([
            'legal_id' => $legal_id,
            'user_id' => $user_id
        ]);

        if ($userLegal->insert()) {
            $this->trigger(self::EVENT_AFTER_ACCEPT, new LegalAccept([
                'userId' => $user_id,
                'legalId' => $legal_id
            ]));

            return true;
        }

        return false;
    }

    /**
     * Method for verifying the user accept the license agreement
     *
     * @param integer $user_id
     * @param integer $legal_id
     * @return bool
     */
    public function isUserAccepted($user_id, $legal_id)
    {
        $userLegal = LegalUser::findOne([
            'user_id' => $user_id,
            'legal_id' => $legal_id
        ]);

        return ($userLegal != null);
    }

    /**
     * Method for sending letter to the user e-mail
     *
     * @param string $from
     * @param string $to
     * @param string $subject
     * @param string $body
     * @return bool returns `true` if letter successfully sent
     */
    public function sendToEmail($from, $to, $subject, $body)
    {
        /** @var MailerInterface $mailer */
        $mailer = Yii::$app->get($this->mailerComponentId);
        $res = $mailer->compose()
            ->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->setHtmlBody($body)
            ->send();

        return ($res);
    }

    /**
     * Generation token for user and saving to database
     *
     * @param $legal_id
     * @param $user_id
     * @return boolean|string returns token if it successfully saved to database
     */
    public function generateToken($legal_id, $user_id)
    {
        $userToken = new LegalUserTokens([
            'legal_id' => $legal_id,
            'user_id' => $user_id,
            'token' => Yii::$app->security->generateRandomString()
        ]);

        return ($userToken->insert()) ? $userToken->token : false;
    }
}