<?php
namespace bl\legalAgreement\controllers;

use yii;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\db\ActiveRecord;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

use bl\legalAgreement\entities\Legal;
use bl\legalAgreement\entities\LegalType;
use bl\legalAgreement\entities\LegalTranslation;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class AgreementController extends Controller
{
    public $defaultAction = 'list';

    /**
     * Action for render list of the legal agreements
     *
     * @return string
     */
    public function actionList()
    {
        $legals = Legal::find()
            ->with(['legalTranslations', 'type.legalTypeTranslations']);

        $provider = new ActiveDataProvider([
            'query' => $legals,
            'pagination' => [
                'pageSize' => 10
            ],
            'sort' => [
                'defaultOrder' => [
                    'type_id' => SORT_DESC,
                    'version' => SORT_DESC
                ]
            ]
        ]);

        $viewName = 'agreement_list';
        $renderData = [
            'provider' => $provider
        ];

        if(Yii::$app->request->isAjax) {
            return $this->renderAjax($viewName, $renderData);
        }

        return $this->render($viewName, $renderData);
    }

    /**
     * Action for removing the legal agreement
     *
     * @param integer $legalId
     * @return string
     * @see AgreementController::actionList()
     */
    public function actionDelete($legalId)
    {
        /** @var Legal $legal */
        $legal = Legal::findOne($legalId);
        $legal->delete();

        return $this->actionList();
    }

    /**
     * Action for editing the legal agreement
     *
     * @param integer $legalId
     * @return string
     * @see AgreementController::actionList()
     */
    public function actionEdit($legalId)
    {
        // legal types
        $types = LegalType::find()->all();

        // languages
        /** @var ActiveRecord $languageModelName */
        $languageModelName = $this->module->languageEntity['class'];
        $languageIdField = $this->module->languageEntity['idField'];
        $languageNameField = $this->module->languageEntity['nameField'];

        $languages = $languageModelName::find()
            ->select([$languageIdField, $languageNameField])
            ->all();

        // legal agreements
        $legal = Legal::find()
            ->where(['id' => $legalId])
            ->with('legalTranslations')
            ->one();

        // legal translations
        $lagalTranslations = LegalTranslation::findAll(['legal_id' => $legalId]);
        $lagalTranslations = ArrayHelper::index($lagalTranslations, 'language_id');

        return $this->render('edit', [
            'legal' => $legal,
            'legalTrans' => $lagalTranslations,
            'types' => $types,

            'languages' => $languages,
            'languageIdField' => $languageIdField,
            'languageNameField' => $languageNameField
        ]);
    }

    /**
     * Method for save legal agreement translation
     *
     * @return Response
     * @throws NotFoundHttpException
     * @see AgreementController::actionEdit()
     */
    public function actionSaveTranslation()
    {
        if(Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();

            $legalTranslation = new LegalTranslation();
            $legalTranslation->legal_id = $data['legal-id'];
            $legalTranslation->language_id = $data['lang-id'];
            $legalTranslation->text = $data['text'];

            if($legalTranslation->validate() && $legalTranslation->save()) {
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        throw new NotFoundHttpException("Page not found!");
    }

    /**
     * Method for save method agreement data
     *
     * @return Response
     * @throws NotFoundHttpException
     * @see AgreementController::actionEdit()
     */
    public function actionSave()
    {
        if(Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();

            /** @var Legal $legal */
            $legal = Legal::findOne($data['legal-id']);

            if($legal->type_id != $data['type']) {
                $legal->type_id = $data['type'];
            }

            if($legal->version != $data['version']) {
                $legal->version = $data['version'];
            }

            if($legal->validate() && $legal->save()) {
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        throw new NotFoundHttpException("Page not found!");
    }

    /**
     * Method for show legal agreement in the frontend
     *
     * @param integer $legalId
     * @return string
     * @see AgreementController::actionList()
     */
    public function actionShow($legalId, $typeId)
    {
        /** @var Legal $activeLegal */
        $activeLegal = Legal::find()
            ->where([
                'type_id' => $typeId,
                'show' => true
            ])
            ->one();
        if($activeLegal != null) {
            $activeLegal->show = false;
            $activeLegal->save(false);
        }

        /** @var Legal $legal */
        $legal = Legal::findOne($legalId);
        $legal->show = true;
        $legal->save(false);

        return $this->actionList();
    }

    /**
     * Method for hide legal agreement in the frontend
     *
     * @param integer $legalId
     * @return string
     * @see AgreementController::actionList()
     */
    public function actionHide($legalId)
    {
        /** @var Legal $legal */
        $legal = Legal::findOne($legalId);
        $legal->show = false;
        $legal->save(false);

        return $this->actionList();
    }
}