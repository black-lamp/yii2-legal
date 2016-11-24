<?php
namespace bl\legalAgreement\common\components;

use yii;
use yii\base\Component;
use yii\mail\MailerInterface;

use bl\legalAgreement\common\behaviors\User;
use bl\legalAgreement\common\entities\LegalUserTokens;

/**
 * Component for manipulations with users and legal agreements
 *
 * Behaviors
 * @method accept(int $user_id, int $legal_id)
 * @method isUserAccepted(int $user_id, int $legal_id)
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 */
class LegalAgreement extends Component
{
    public function behaviors()
    {
        return [
            'user' => [
                'class' => User::className()
            ]
        ];
    }

    /**
     * @var string Id of mailer component from app config
     */
    public $mailerComponentId = 'mailer';

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
     * @return boolean|string returns token if it successfully saved to database,
     * `false` if not saved
     */
    public function generateToken($legal_id, $user_id)
    {
        $bytes = openssl_random_pseudo_bytes(32);
        $token = bin2hex($bytes);

        $userToken = new LegalUserTokens();
        $userToken->legal_id = $legal_id;
        $userToken->user_id = $user_id;
        $userToken->token = $token;

        return ($userToken->validate() && $userToken->save()) ? $token : false;
    }
}