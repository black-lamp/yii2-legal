<?php
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
 * @var \bl\legalAgreement\backend\models\forms\EditForm $model
 * @var integer $languageId
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */

\yii\bootstrap\BootstrapAsset::register($this);

$this->title = LegalModule::t('edit', 'Edit the legal agreement');
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
        <div class="col-md-12">
            <?= Language::widget([
                'languageId' => $languageId
            ]) ?>
        </div>
        <div class="clearfix"></div>
        <hr>
        <?php $form = ActiveForm::begin()?>
            <?= $form->field($model, 'text')
                ->widget(TinyMce::class, [
                    'options' => ['rows' => 20],
                    'language' => 'en_CA',
                    'clientOptions' => [
                        'plugins' => [
                            "advlist autolink lists link charmap print preview anchor",
                            "searchreplace visualblocks fullscreen",
                            "insertdatetime media table contextmenu paste"
                        ],
                        'toolbar' => "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
                    ]
                ]) ?>
            <?= $form->field($model, 'key') ?>
            <?= Html::submitButton(
                LegalModule::t('create', 'Add'),
                ['class' => 'btn btn-success pull-right']
            ) ?>
        <?php $form->end() ?>
    </div>
</div>
