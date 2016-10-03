<?php
namespace bl\legalAgreement\controllers;

use yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

use bl\legalAgreement\entities\LegalType;
use bl\legalAgreement\entities\LegalTypeTranslation;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class TypeController extends Controller
{
    public $defaultAction = 'list';

    /**
     * Action for render list of the legal agreements types
     *
     * @return string
     */
    public function actionList()
    {
            $types = LegalType::find()
            ->with(['legalTypeTranslations']);

        $provider = new ActiveDataProvider([
            'query' => $types,
            'pagination' => [
                'pageSize' => 10
            ],
            'sort' => [
                'defaultOrder' => [
                    'position' => SORT_DESC
                ]
            ]
        ]);

        $viewName = 'type_list';
        $renderData = [
            'provider' => $provider
        ];

        if(Yii::$app->request->isAjax) {
            return $this->renderAjax($viewName, $renderData);
        }

        return $this->render($viewName, $renderData);
    }

    /**
     * Action for editing the legal agreement type
     *
     * @param integer $typeId
     * @return string
     */
    public function actionEdit($typeId)
    {
        // languages
        /** @var ActiveRecord $languageModelName */
        $languageModelName = $this->module->languageEntity['class'];
        $languageIdField = $this->module->languageEntity['idField'];
        $languageNameField = $this->module->languageEntity['nameField'];

        $languages = $languageModelName::find()
            ->select([$languageIdField, $languageNameField])
            ->all();

        // legal types
        $type = LegalType::findOne($typeId);

        // legal types translations
        $typeTranslations = LegalTypeTranslation::findAll(['type_id' => $typeId]);
        $typeTranslations = ArrayHelper::index($typeTranslations, 'language_id');

        return $this->render('edit', [
            'type' => $type,
            'typeTrans' => $typeTranslations,
            'model' => new LegalTypeTranslation(),

            'languages' => $languages,
            'languageIdField' => $languageIdField,
            'languageNameField' => $languageNameField
        ]);
    }

    /**
     * Method for save legal agreement type translation
     *
     * @return Response
     * @throws NotFoundHttpException
     * @see TypeController::actionEdit()
     */
    public function actionSaveTranslation()
    {
        if(Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();

            $legalTypeTrans = new LegalTypeTranslation();
            $legalTypeTrans->type_id = $data['type-id'];
            $legalTypeTrans->language_id = $data['lang-id'];
            $legalTypeTrans->title = $data['title'];

            // SEO data
            $legalTypeTrans->seoTitle = $data['seo-title'];
            $legalTypeTrans->seoDescription = $data['seo-description'];
            $legalTypeTrans->seoKeywords = $data['seo-keywords'];
            $legalTypeTrans->seoUrl = $data['seo-url'];

            if($legalTypeTrans->validate() && $legalTypeTrans->save()) {
                return $this->redirect(Yii::$app->request->referrer);
            }
        }

        throw new NotFoundHttpException("Page not found!");
    }

    /**
     * Action for removing the type of legal agreement
     *
     * @param integer $typeId
     * @return string
     * @see TypeController::actionList()
     */
    public function actionDelete($typeId)
    {
        /** @var LegalType $type */
        $type = LegalType::findOne($typeId);
        $type->delete();

        return $this->actionList();
    }

    /**
     * Method for change the legal agreement type position
     *
     * @param integer $typeId
     * @return string
     * @see TypeController::actionEdit()
     */
    public function actionMoveDown($typeId)
    {
        /** @var LegalType $type */
        if($type = LegalType::findOne($typeId)) {
            $type->movePrev();
        }

        return $this->actionList();
    }

    /**
     * Method for change the legal agreement type position
     *
     * @param integer $typeId
     * @return string
     * @see TypeController::actionEdit()
     */
    public function actionMoveUp($typeId)
    {
        /** @var LegalType $type */
        if($type = LegalType::findOne($typeId)) {
            $type->moveNext();
        }

        return $this->actionList();
    }
}