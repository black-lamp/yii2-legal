<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use bl\legalAgreement\entities\LegalType;
use bl\legalAgreement\LegalModule;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * @var yii\web\View $this
 * @var LegalType[] $types
 */

yii\bootstrap\BootstrapAsset::register($this);
?>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1 class="text-center">
                <?= LegalModule::t('create', 'Add new legal agreement') ?>
            </h1>

            <?php $form = ActiveForm::begin() ?>
                <h2>
                    <?= LegalModule::t('create', 'Language') ?>
                </h2>
                 <hr>
                <div class="form-group">
                    <label for="select-lang">
                        <?= LegalModule::t('create', 'Select lang') ?>
                    </label>
                    <select class="form-control" name="language" id="select-lang">
                        <option value="1">English</option>
                        <option value="2">Russian</option>
                    </select>
                </div>

                <h2>
                    <?= LegalModule::t('create', 'Type') ?>
                </h2>
                <hr>
                <div class="form-group">
                    <h4>
                        <?= LegalModule::t('create', 'Select exists') ?>
                    </h4>
                    <select class="form-control" name="type" id="legal-type-list">
                        <?php foreach($types as $type): ?>
                            <?= Html::tag('option', $type->legalTypeTranslations[0]->title, ['value' => $type->id]) ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <h4>
                        <?= LegalModule::t('create', 'or add new') ?>
                    </h4>
                    <?= Html::input('text', 'new-type', '', [
                        'id' => 'legal-type-new',
                        'class' => 'form-control',
                        'placeholder' => LegalModule::t('create', 'Title')
                    ]) ?>
                </div>
                <div class="form-group">
                    <?= Html::input('text', 'seo-title', '', [
                        'id' => 'legal-type-new',
                        'class' => 'form-control',
                        'placeholder' => LegalModule::t('create', 'Seo title')
                    ]) ?>
                </div>
                <div class="form-group">
                    <?= Html::input('text', 'seo-description', '', [
                        'id' => 'legal-type-new',
                        'class' => 'form-control',
                        'placeholder' => LegalModule::t('create', 'Seo description')
                    ]) ?>
                </div>
                <div class="form-group">
                    <?= Html::input('text', 'seo-keywords', '', [
                        'id' => 'legal-type-new',
                        'class' => 'form-control',
                        'placeholder' => LegalModule::t('create', 'Seo keywords')
                    ]) ?>
                </div>
                <div class="form-group">
                    <?= Html::input('text', 'seo-url', '', [
                        'id' => 'legal-type-new',
                        'class' => 'form-control',
                        'placeholder' => LegalModule::t('create', 'Seo url')
                    ]) ?>
                </div>

                <h2>
                    <?= LegalModule::t('create', 'Text') ?>
                </h2>
                <hr>
                <div class="form-group">
                    <textarea name="text" id="legal-text" cols="10" rows="10" class="form-control"></textarea>
                </div>

                <div class="form-group">
                    <?= Html::input('submit', 'submit-btn', LegalModule::t('create', 'Save'), [
                        'class' => 'btn btn-success pull-right'
                    ]) ?>
                    <div class="clearfix"></div>
                </div>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>