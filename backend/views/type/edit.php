<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use bl\legalAgreement\common\entities\LegalTypeTranslation;
use bl\legalAgreement\common\entities\LegalType;
use bl\legalAgreement\backend\LegalModule;

/**
 * View file for Type controller
 * @see \bl\legalAgreement\backend\controllers\TypeController
 *
 * @var yii\web\View $this
 * @var LegalType $type
 * @var LegalTypeTranslation[] $typeTrans
 * @var array $languages
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 */

\yii\bootstrap\BootstrapAsset::register($this);

$this->registerJs("$(\"[data-toggle='tooltip']\").tooltip();");
?>

<div class="container">
    <div class="row">
        <h1 class="text-center">
            <?= LegalModule::t('type.edit', 'Edit legal type') ?>
        </h1>

        <div class="col-md-8 col-md-offset-2">
            <h4>
                <?= LegalModule::t('type.edit', 'Select language') ?>
            </h4>
            <?php foreach($languages as $id => $name): ?>
                <?php $class =
                    ($typeTrans[$id]->title != null)
                        ? 'label-success' : 'label-danger';
                    $tooltipText =
                        ($typeTrans[$id]->title != null)
                            ? 'Have translation' : 'Don\'t have translation for this language';
                    $label = Html::tag('span', $name, [
                        'class' => 'label ' . $class,
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'top',
                        'data-original-title' => $tooltipText
                    ]);
                ?>
                <a href="#" data-toggle="modal" data-target="#lang-<?= $id ?>">
                    <?= $label ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php foreach($languages as $id => $name): ?>
    <div class="modal fade" id="lang-<?= $id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">
                        <?= LegalModule::t('type.edit', 'Edit legal type title') ?>
                    </h4>
                </div>
                <?php $form = ActiveForm::begin([
                    'action' => 'save-translation'
                ]) ?>
                    <?= Html::hiddenInput('type-id', $type->id) ?>
                    <?= Html::hiddenInput('lang-id', $id) ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <?= Html::label('Title', 'title') ?>
                            <?= Html::input('text', 'title', $typeTrans[$id]->title, [
                                'id' => 'title',
                                'class' => 'form-control'
                            ]) ?>
                        </div>
                        <hr>
                        <h4>
                            <?= LegalModule::t('type.edit', 'SEO Data') ?>
                        </h4>
                        <div class="form-group">
                            <?= Html::label(LegalModule::t('type.edit', 'Title'), 'seo-title') ?>
                            <?= Html::input('text', 'seo-title', $typeTrans[$id]->seoTitle, [
                                'id' => 'seo-title',
                                'class' => 'form-control'
                            ]) ?>
                        </div>
                        <div class="form-group">
                            <?= Html::label(LegalModule::t('type.edit', 'Description'), 'seo-description') ?>
                            <?= Html::input('text', 'seo-description', $typeTrans[$id]->seoDescription, [
                                'id' => 'seo-description',
                                'class' => 'form-control'
                            ]) ?>
                        </div>
                        <div class="form-group">
                            <?= Html::label(LegalModule::t('type.edit', 'Keywords'), 'seo-keywords') ?>
                            <?= Html::textarea('seo-keywords', $typeTrans[$id]->seoKeywords, [
                                'id' => 'seo-keywords',
                                'class' => 'form-control'
                            ]) ?>
                        </div>
                        <div class="form-group">
                            <?= Html::label(LegalModule::t('type.edit', 'Url'), 'seo-url') ?>
                            <?= Html::input('text', 'seo-url', $typeTrans[$id]->seoUrl, [
                                'id' => 'seo-url',
                                'class' => 'form-control'
                            ]) ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            <?= LegalModule::t('type.edit', 'Save changes') ?>
                        </button>
                    </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>

