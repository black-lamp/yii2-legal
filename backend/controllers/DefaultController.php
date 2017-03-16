<?php
/**
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @copyright Copyright (c) 2016 Vladimir Kuprienko
 * @license GNU Public License
 */

namespace bl\legalAgreement\backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

use bl\legalAgreement\backend\Module as LegalModule;
use bl\legalAgreement\backend\providers\LanguageProviderInterface;
use bl\legalAgreement\common\entities\Legal;
use bl\legalAgreement\backend\models\forms\CreateForm;
use bl\legalAgreement\backend\models\forms\EditForm;

/**
 * Default controller for Legal backend module
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class DefaultController extends Controller
{
    /**
     * @var LegalModule
     */
    public $module;
    /**
     * @inheritdoc
     */
    public $defaultAction = 'list';


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => [
                    'list',
                    'create',
                    'toggle-display',
                    'edit',
                    'delete',
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'list',
                            'create',
                            'toggle-display',
                            'edit',
                            'delete',
                        ],
                        'roles' => ['manageLegalAgreement']
                    ]
                ]
            ],
        ];
    }

    /**
     * Action display list of legal agreements
     *
     * @return string
     */
    public function actionList()
    {
        $agreements = Legal::find()->all();

        $viewName = 'list';
        $viewParams = ['agreements' => $agreements];

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax($viewName, $viewParams);
        }

        return $this->render($viewName, $viewParams);
    }

    /**
     * Action for creation of legal agreement
     *
     * @param null|integer $languageId
     * @return string
     */
    public function actionCreate($languageId = null)
    {
        $language = (is_null($languageId)) ?
            key(Yii::$container->get(LanguageProviderInterface::class)->getDefault()) :
            $languageId;

        $model = new CreateForm(['langId' => $language]);

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());

            if ($model->save()) {
                return $this->redirect('list');
            }
        }

        return $this->render('create', [
            'model' => $model,
            'languageId' => $languageId
        ]);
    }

    /**
     * Toggle of the legal agreement displaying
     *
     * @param integer $legalId
     * @return string
     */
    public function actionToggleDisplay($legalId)
    {
        $agreement = Legal::findOne($legalId);
        $agreement->show = ($agreement->show) ? false : true;
        $agreement->update();

        return $this->actionList();
    }

    /**
     * Action for editing of the legal agreement
     *
     * @param integer $legalId
     * @param null|integer $languageId
     * @return string|\yii\web\Response
     */
    public function actionEdit($legalId, $languageId = null)
    {
        $language = (is_null($languageId)) ?
            key(Yii::$container->get(LanguageProviderInterface::class)->getDefault()) :
            $languageId;

        $model = new EditForm($legalId, $language);

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());

            if ($model->save()) {
                return $this->redirect('list');
            }
        }

        return $this->render('edit', [
            'model' => $model,
            'languageId' => $languageId
        ]);
    }

    /**
     * Action for removing of the legal agreement from database
     *
     * @param integer $legalId
     * @return \yii\web\Response
     */
    public function actionDelete($legalId)
    {
        if ($agreement = Legal::findOne($legalId)) {
            $agreement->delete();
        }

        return $this->redirect('list');
    }
}