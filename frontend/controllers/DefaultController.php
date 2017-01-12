<?php
/**
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @copyright Copyright (c) 2016 Vladimir Kuprienko
 * @license GNU Public License
 */

namespace bl\legalAgreement\frontend\controllers;

use yii\db\ActiveQuery;
use yii\web\Controller;

use bl\legalAgreement\frontend\LegalModule;
use bl\legalAgreement\common\entities\Legal;
use bl\legalAgreement\common\entities\LegalUserTokens;

/**
 * Default controller for frontend Legal module
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class DefaultController extends Controller
{
    /**
     * @inheritdoc
     */
    public $defaultAction = 'view';
    /**
     * @var LegalModule
     */
    public $module;


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

        /** @var \bl\legalAgreement\common\components\LegalManager $legalManager */
        $legalManager = $this->module->get('legalManager');

        if(!$legalManager->isUserAccepted($userToken->user_id, $legalId)) {
            $legalManager->accept($userToken->user_id, $legalId);
        }

        return $this->redirect($this->module->redirectRoute);
    }

    public function actionAcceptAgreement($legalId, $userId)
    {
        /** @var \bl\legalAgreement\common\components\LegalManager $legalManager */
        $legalManager = $this->module->get('legalManager');

        if(!$legalManager->isUserAccepted($userId, $legalId)) {
            $legalManager->accept($userId, $legalId);
        }

        return $this->redirect($this->module->redirectRoute);
    }
}
