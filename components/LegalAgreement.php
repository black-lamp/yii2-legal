<?php
namespace bl\legalAgreement\components;

use yii\base\Object;
use bl\legalAgreement\entities\LegalUser;

/**
 * Component for manipulations with users and legal agreements
 *
 * Installation
 * ```php
 * 'components' => [
 *      // ...
 *      'legalAccept' => [
 *          'class' => bl\legalAgreement\components\LegalAgreement::className()
 *      ]
 * ]
 * ```
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class LegalAgreement extends Object
{
    /**
     * Method for accepting legal agreement by user
     *
     * @param integer $userId
     * @param integer $legalId
     * @return bool
     */
    public function acceptAgreement($userId, $legalId)
    {
        $userLegal = new LegalUser();
        $userLegal->user_id = $userId;
        $userLegal->legal_id = $legalId;
        if($userLegal->validate() && $userLegal->save()) {
            return true;
        }

        return false;
    }

    /**
     * Method for verifying the user accept the license agreement
     *
     * @param integer $userId
     * @param integer $legalId
     * @return bool
     */
    public function isUserAccepted($userId, $legalId)
    {
        $userLegal = LegalUser::findOne([
            'user_id' => $userId,
            'legal_id' => $legalId
        ]);

        return ($userLegal != null) ? true : false;
    }
}