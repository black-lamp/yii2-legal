<?php
/**
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @copyright Copyright (c) 2016 Vladimir Kuprienko
 * @license GNU Public License
 */

namespace bl\legalAgreement\common\components;

use Yii;
use yii\base\Component;
use yii\base\Exception;
use yii\mail\MailerInterface;

use bl\legalAgreement\common\events\LegalAccept;
use bl\legalAgreement\common\entities\LegalUser;
use bl\legalAgreement\common\entities\LegalUserTokens;
use bl\legalAgreement\common\entities\Legal;

/**
 * Component for manipulations with users and legal agreements
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class LegalManager extends Component
{
    // Events
    const EVENT_AFTER_ACCEPT = 'afterAccept';


    /**
     * Method for accepting legal agreement by user
     *
     * @param integer $userId
     * @param integer $legalId
     * @return bool returns `true` if agreement was successfully accepted
     * @throws Exception
     */
    public function accept($userId, $legalId)
    {
        if (!self::isUserAccepted($userId, $legalId)) {
            $userLegal = new LegalUser([
                'legal_id' => $legalId,
                'user_id' => $userId
            ]);

            try {
                if ($userLegal->insert()) {
                    $this->trigger(self::EVENT_AFTER_ACCEPT, new LegalAccept([
                        'userId' => $userId,
                        'legalId' => $legalId
                    ]));

                    return true;
                }
            }
            catch (Exception $ex) {
                throw $ex;
            }
        }

        return false;
    }

    /**
     * Method for verifying the user accept the license agreement
     *
     * @param integer $userId
     * @param integer $legalId
     * @return boolean
     */
    public function isUserAccepted($userId, $legalId)
    {
        $userLegal = LegalUser::findOne([
            'user_id' => $userId,
            'legal_id' => $legalId
        ]);

        return ($userLegal != null);
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

    /**
     * Get Legal object by key
     *
     * @param string $kexy
     * @param null|integer $languageId
     * @return Legal|null
     */
    public function getByKey($key, $languageId = null)
    {
        $agreement = Legal::find()->where(['key' => $key]);
        if (!is_null($languageId)) {
            $agreement = $agreement->withTranslation($languageId);
        }

        return $agreement->limit(1)->one();
    }
}