<?php
namespace bl\legalAgreement\controllers;

use yii;
use yii\web\Controller;

use bl\legalAgreement\entities\Legal;
use bl\legalAgreement\entities\LegalTranslation;
use bl\legalAgreement\entities\LegalType;
use bl\legalAgreement\entities\LegalTypeTranslation;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class CreateController extends Controller
{
    /**
     * @var string
     */
    public $defaultAction = 'create';

    /**
     * Method for generation the version for legal agreement
     *
     * @param integer $typeId
     * @return integer
     * @see CreateController::actionCreate()
     */
    protected function generateVersion($typeId)
    {
        $version = Legal::find()
            ->where(['type_id' => $typeId])
            ->max('version');

        return ($version == null) ? 1 : $version + 1;
    }

    /**
     * Action for create new legal agreement
     * and legal agreement type
     *
     * @return string
     */
    public function actionCreate()
    {
        if(Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();

            $typeId = null;

            if($data['new-type'] == '') {
                /** @var LegalType $type */
                $type = LegalType::findOne($data['type']);
                $typeId = $type->id;
            }
            else {
                /** @var LegalType $type */
                $type = new LegalType();
                $type->save(false);

                /** @var LegalTypeTranslation $typeTranslation */
                $typeTranslation = new LegalTypeTranslation();
                $typeTranslation->type_id = $type->id;
                $typeTranslation->language_id = $data['language'];
                $typeTranslation->title = $data['new-type'];

                $typeTranslation->seoTitle = $data['seo-title'];
                $typeTranslation->seoDescription = $data['seo-description'];
                $typeTranslation->seoKeywords = $data['seo-keywords'];
                $typeTranslation->seoUrl = $data['seo-url'];

                if($typeTranslation->validate() && $typeTranslation->save()) {
                    $typeId = $type->id;
                }
            }

            /** @var Legal $legal */
            if($typeId != null) {
                $legal = new Legal();
                $legal->type_id = $typeId;
                $legal->version = $this->generateVersion($type->id);

                if($legal->validate() && $legal->save()) {
                    /** @var LegalTranslation $legalTranslation */
                    $legalTranslation = new LegalTranslation();
                    $legalTranslation->legal_id = $legal->id;
                    $legalTranslation->language_id = $data['language'];
                    $legalTranslation->text = $data['text'];

                    if($legalTranslation->validate() && $legalTranslation->save()) {
                        return $this->redirect(Yii::$app->request->referrer);
                    }
                }
            }
        }

        $types = LegalType::find()
            ->with('legalTypeTranslations')
            ->all();

        return $this->render('create', [
            'types' => $types
        ]);
    }
}