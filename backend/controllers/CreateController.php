<?php
namespace bl\legalAgreement\backend\controllers;

use yii;
use yii\web\Controller;

use bl\legalAgreement\backend\LegalModule;
use bl\legalAgreement\backend\providers\LanguageProviderInterface;
use bl\legalAgreement\common\entities\Legal;
use bl\legalAgreement\common\entities\LegalTranslation;
use bl\legalAgreement\common\entities\LegalType;
use bl\legalAgreement\common\entities\LegalTypeTranslation;

/**
 * Create controller for backend Legal module
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 */
class CreateController extends Controller
{
    /**
     * @inheritdoc
     */
    public $defaultAction = 'create';

    /**
     * @var LanguageProviderInterface
     */
    protected $_languageProvider;

    /**
     * @inheritdoc
     */
    public function __construct($id, LegalModule $module, LanguageProviderInterface $languageProvider, $config = [])
    {
        $this->_languageProvider = $languageProvider;
        parent::__construct($id, $module, $config);
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

        $languages = $this->_languageProvider->getLanguages();

        return $this->render('create', [
            'types' => $types,
            'languages' => $languages
        ]);
    }
}