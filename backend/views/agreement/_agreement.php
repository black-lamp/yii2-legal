<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\db\ActiveRecord;

use bl\legalAgreement\common\entities\Legal;
use bl\legalAgreement\backend\LegalModule;

/**
 * View file for Agreement controller
 * @see \bl\legalAgreement\backend\controllers\AgreementController
 *
 * @var \yii\web\View $this
 * @var Legal $model
 * @var ActiveRecord[] $languages
 * @var string $languageIdField
 * @var string $languageNameField
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
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
