<?php
namespace bl\legalAgreement\common\behaviors;

use yii\base\Behavior;

use bl\legalAgreement\common\entities\LegalUser;

/**
 * Behavior for manipulations with users and legal agreements
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 */
class User extends Behavior
{
    /**
     * Method for accepting legal agreement by user
     *
     * @param integer $user_id
     * @param integer $legal_id
     * @return bool
     */
    public function accept($user_id, $legal_id)
    {
        $userLegal = new LegalUser();
        $userLegal->user_id = $user_id;
        $userLegal->legal_id = $legal_id;

        return ($userLegal->validate() && $userLegal->save());
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
}