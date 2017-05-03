<?php
/**
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @copyright Copyright (c) 2016 Vladimir Kuprienko
 * @license GNU Public License
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use bl\legalAgreement\backend\Module as LegalModule;
use bl\legalAgreement\backend\widgets\Language;

use dosamigos\tinymce\TinyMce;

/**
 * View file for Default controller in Legal backend module
 *
 * @var \yii\web\View $this
 * @var \bl\emailTemplates\models\forms\CreateForm $model
 * @var integer $languageId
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */

\yii\bootstrap\BootstrapAsset::register($this);

$this->title = LegalModule::t('create', 'Add new legal agreement');
$this->params['breadcrumbs'][] = [
    'url' => Url::toRoute(['list']),
    'label' => LegalModule::t('breadcrumbs', 'List of legal agreements')
];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h1 class="text-center">
            <?= $this->title ?>
        </h1>
        <hr>
        <?= Language::widget([
            'languageId' => $languageId
        ]) ?>
        <hr>
        <?php $form = ActiveForm::begin() ?>
            <?= $form->field($model, 'key') ?>
            <?= $form->field($model, 'text')
                    ->widget(TinyMce::class, [
                        'options' => ['rows' => 20],
                        'language' => 'en_CA',
                        'clientOptions' => [
                            'plugins' => [
                                "advlist autolink lists link charmap print preview anchor",
                                "searchreplace visualblocks code fullscreen",
                                "insertdatetime media table contextmenu paste",
                                "image"
                            ],
                            'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
                            'image_class_list' => [
                                ['title' => 'None', 'value' => ''],
                                ['title' => 'Article big', 'value' => 'article-img big'],
                                ['title' => 'Article small', 'value' => 'article-img small'],
                            ],
                            'image_advtab' => true
                        ]
                    ]) ?>
            <?= Html::submitButton(
                LegalModule::t('create', 'Add'),
                ['class' => 'btn btn-success pull-right']
            ) ?>
        <?php ActiveForm::end() ?>
    </div>
</div>
