<?php
/**
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @copyright Copyright (c) 2016 Vladimir Kuprienko
 * @license GNU Public License
 */

namespace bl\legalAgreement\frontend\controllers;

use Yii;
use yii\web\Controller;

use bl\legalAgreement\frontend\Module as LegalModule;
use bl\legalAgreement\common\entities\Legal;
use bl\legalAgreement\common\entities\LegalUserTokens;

/**
 * Default controller for Legal frontend module
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


    /**
     * Render the legal agreement
     *
     * @param integer $legalId
     * @param integer $langId
     * @return string
     */
    public function actionView($legalId, $langId)
    {
        $agreement = Legal::find()
            ->where(['id' => $legalId])
            ->withTranslation($langId)
            ->one();

        $isUserAccepted = false;
        if (!Yii::$app->user->isGuest) {
            $isUserAccepted = $this->module->get('legalManager')
                ->isUserAccepted(Yii::$app->user->id, $legalId);
        }

        return $this->render('view', [
            'agreement' => $agreement,
            'isUserAccepted' => $isUserAccepted
        ]);
    }

    /**
     * Accept the legal agreement by user token
     *
     * @param integer $legalId
     * @param string $token
     * @return \yii\web\Response
     */
    public function actionAccept($legalId, $token)
    {
        $userId = LegalUserTokens::find()
            ->select('user_id')
            ->where([
                'legal_id' => $legalId,
                'token' => $token
            ])
            ->scalar();

        /** @var \bl\legalAgreement\common\components\LegalManager $legalManager */
        $legalManager = $this->module->get('legalManager');
        $legalManager->accept($userId, $legalId);

        Yii::$app->get('session')->addFlash($this->module->messageKey, $this->module->flashMessage);

        return $this->redirect($this->module->redirectRoute);
    }

    /**
     * Accept the legal agreement
     *
     * @param integer $legalId
     * @param integer $userId
     * @return \yii\web\Response
     */
    public function actionAcceptAgreement($legalId, $userId)
    {
        /** @var \bl\legalAgreement\common\components\LegalManager $legalManager */
        $legalManager = $this->module->get('legalManager');
        $legalManager->accept($userId, $legalId);

        Yii::$app->get('session')->addFlash($this->module->messageKey, $this->module->flashMessage);

        return $this->redirect($this->module->redirectRoute);
    }
}
