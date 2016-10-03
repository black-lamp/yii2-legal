<?php
use yii\helpers\Html;
use yii\helpers\Url;

use bl\legalAgreement\entities\LegalType;
use bl\legalAgreement\LegalModule;

/**
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * @var yii\web\View $this
 * @var LegalType $model
 */
?>

<tr>
    <td>
        <?= $model->legalTypeTranslations[0]->title ?>
    </td>
    <td>
        <a href="<?= Url::toRoute(['move-down', 'typeId' => $model->id]) ?>" class="pjax-btn">
            <span class="glyphicon glyphicon-triangle-bottom"></span>
        </a>
        <a href="<?= Url::toRoute(['move-up', 'typeId' => $model->id]) ?>" class="pjax-btn">
            <span class="glyphicon glyphicon-triangle-top"></span>
        </a>
    </td>
    <td>
        <?= Html::a(LegalModule::t('type.list', 'Edit'),
            Url::toRoute([
                'edit',
                'typeId' => $model->id,
            ]), [
                'class' => 'btn btn-sm btn-success'
            ]) ?>
        <?= Html::a(LegalModule::t('type.list', 'Delete'),
            Url::toRoute([
                'delete',
                'typeId' => $model->id
            ]), [
                'class' => 'btn btn-sm btn-danger pjax-btn'
            ]) ?>
    </td>
</tr>
