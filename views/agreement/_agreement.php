<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\db\ActiveRecord;

use bl\legalAgreement\entities\Legal;
use bl\legalAgreement\LegalModule;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * @var yii\web\View $this
 * @var Legal $model
 * @var ActiveRecord[] $languages
 * @var string $languageIdField
 * @var string $languageNameField
 */
?>


<tr>
    <td>
        <?= $model->type->legalTypeTranslations[0]->title ?>
    </td>
    <td>
        <?= $model->version ?>
    </td>
    <td>
        <a href="#">
            <?php if($model->show): ?>
                <a href="<?= Url::toRoute(['hide', 'legalId' => $model->id]) ?>" class="pjax-btn">
                    <span class="glyphicon glyphicon-eye-open"></span>
                </a>
            <?php else: ?>
                <a href="<?= Url::toRoute([
                    'show',
                    'legalId' => $model->id,
                    'typeId' => $model->type_id
                ]) ?>" class="pjax-btn">
                    <span class="glyphicon glyphicon-eye-close"></span>
                </a>
            <?php endif; ?>
        </a>
    </td>
    <td>
        <?= Html::a(LegalModule::t('agreement.list', 'Edit'),
            Url::toRoute([
                'edit',
                'legalId' => $model->id
            ]), [
                'class' => 'btn btn-sm btn-success'
            ]) ?>
        <?= Html::a(LegalModule::t('agreement.list', 'Delete'),
            Url::toRoute([
                'delete',
                'legalId' => $model->id
            ]), [
                'class' => 'btn btn-sm btn-danger pjax-btn'
            ]) ?>
    </td>
</tr>
