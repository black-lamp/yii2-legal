<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\db\ActiveRecord;

use bl\legalAgreement\common\entities\Legal;
use bl\legalAgreement\common\entities\LegalType;
use bl\legalAgreement\common\entities\LegalTranslation;
use bl\legalAgreement\backend\LegalModule;

/**
 * View file for Agreement controller
 * @see \bl\legalAgreement\backend\controllers\AgreementController
 *
 * @var yii\web\View $this
 * @var Legal $legal
 * @var LegalTranslation[] $legalTrans
 * @var LegalType[] $types
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
            <?= LegalModule::t('agreement.edit', 'Edit legal agreement') ?>
        </h1>

        <div class="col-md-8 col-md-offset-2">
            <h4>
                <?= LegalModule::t('agreement.edit', 'Edit text') ?>
            </h4>
            <?php foreach($languages as $id => $name): ?>
                <?php $class =
                    ($legalTrans[$id]->text != null)
                        ? 'label-success' : 'label-danger';
                    $tooltipText =
                        ($legalTrans[$id]->text != null)
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
            <hr>
            <?php ActiveForm::begin([
                'action' => ['save']
            ]) ?>
            <div class="form-group">
                <?= Html::hiddenInput('legal-id', $legal->id) ?>
                <label for="legal-type-list">
                    <?= LegalModule::t('agreement.edit', 'Legal agreement type') ?>
                </label>
                <select class="form-control" name="type" id="legal-type-list">
                    <?php foreach($types as $type): ?>
                        <?php
                        $params =
                            ($legal->type_id == $type->id) ? ['value' => $type->id, 'selected' => '']
                                : ['value' => $type->id];
                        ?>
                        <?= Html::tag('option', $type->legalTypeTranslations[0]->title, $params) ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="version">
                    <?= LegalModule::t('agreement.edit', 'Version') ?>
                </label>
                <?= Html::input('number', 'version', $legal->version, [
                    'id' => 'agreement-version',
                    'class' => 'form-control',
                    'min' => 1
                ]) ?>
            </div>
            <div class="form-group">
                <?= Html::input('submit', 'save', LegalModule::t('agreement.edit', 'Save'), [
                    'class' => 'btn btn-success pull-right'
                ]) ?>
                <div class="clearfix"></div>
            </div>
            <?php ActiveForm::end() ?>
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
                        <?= LegalModule::t('agreement.edit', 'Edit legal agreement text') ?>
                    </h4>
                </div>
                <?php ActiveForm::begin([
                    'action' => 'save-translation'
                ]) ?>
                    <?= Html::hiddenInput('legal-id', $legal->id) ?>
                    <?= Html::hiddenInput('lang-id', $id) ?>
                    <div class="modal-body">
                        <?= Html::textarea('text', $legalTrans[$id]->text, [
                            'class' => 'form-control',
                            'cols' => 10,
                            'rows' => 20
                        ]) ?>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">
                            <?= LegalModule::t('agreement.edit', 'Save changes') ?>
                        </button>
                    </div>
                <?php ActiveForm::end() ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>

