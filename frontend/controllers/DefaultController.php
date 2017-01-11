<?php
namespace bl\legalAgreement\frontend\controllers;

use yii\db\ActiveQuery;
use yii\web\Controller;

use bl\legalAgreement\frontend\LegalModule;
use bl\legalAgreement\common\entities\Legal;
use bl\legalAgreement\common\entities\LegalUserTokens;
use bl\legalAgreement\common\behaviors\User;

/**
 * Default controller for frontend Legal module
 *
 * @method accept(int $user_id, int $legal_id)
 * @method isUserAccepted(int $user_id, int $legal_id)
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public $defaultAction = 'view';

    public function behaviors()
    {
        return [
            'user' => [
                'class' => User::className()
            ]
        ];
    }

    public function actionView($legalId, $langId)
    {
        $agreement = Legal::find()
            ->where(['id' => $legalId])
            ->with(['translation' => function($query) use($langId) {
                /** @var ActiveQuery $query */
                $query->andWhere(['language_id' => $langId]);
            }])
            ->one();

        return $this->render('view', [
            'agreement' => $agreement
        ]);
    }

    public function actionAccept($legalId, $token)
    {
        /** @var LegalUserTokens $userToken */
        $userToken = LegalUserTokens::find()
            ->select('user_id')
            ->where([
                'legal_id' => $legalId,
                'token' => $token
            ])
        ->one();

        /** @var LegalModule $module */
        $module = $this->module;

        if(!$this->isUserAccepted($userToken->user_id, $legalId)) {
            $this->accept($userToken->user_id, $legalId);
        }

        return $this->redirect($module->redirectRoute);
    }

    public function actionAcceptAgreement($legalId, $userId)
    {
        if(!$this->isUserAccepted($userId, $legalId)) {
            $this->accept($userId, $legalId);
        }

        return $this->redirect($this->module->redirectRoute);
    }
}
