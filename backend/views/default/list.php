<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;

use bl\legalAgreement\backend\Module as LegalModule;

/**
 * View file for Default controller in Legal backend module
 *
 * @var \yii\web\View $this
 * @var \bl\legalAgreement\common\entities\Legal[] $agreements
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */

\yii\bootstrap\BootstrapAsset::register($this);

$this->title = LegalModule::t('list', 'List of legal agreements');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <h1 class="text-center">
            <?= $this->title ?>
        </h1>
        <hr>
        <div class="col-md-12">
            <?= Html::a(
                LegalModule::t('list', 'Add legal agreement'),
                Url::toRoute(['create']),
                ['class' => 'btn btn-sm btn-success pull-right']
            ) ?>
        </div>
        <div class="clearfix"></div>
        <hr>
        <div class="col-md-12">
            <?php $pjax = Pjax::begin([
                'enablePushState' => false,
                'linkSelector' => '#toggle-display-pjax'
            ]) ?>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>
                        <?= LegalModule::t('list', '#(id)') ?>
                    </th>
                    <th>
                        <?= LegalModule::t('list', 'Key') ?>
                    </th>
                    <th>
                        <?= LegalModule::t('list', 'Version') ?>
                    </th>
                    <th>
                        <?= LegalModule::t('list', 'Show') ?>
                    </th>
                    <th>
                        <?= LegalModule::t('list', 'Actions') ?>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($agreements as $agreement): ?>
                    <tr>
                        <td>
                            <?= $agreement->id ?>
                        </td>
                        <td>
                            <?= $agreement->key ?>
                        </td>
                        <td>
                            <?= $agreement->version ?>
                        </td>
                        <td>
                            <?= Html::a(
                                Html::tag('span', '', [
                                    'class' => ($agreement->show) ?
                                        'glyphicon glyphicon-eye-open' :
                                        'glyphicon glyphicon-eye-close'
                                ]),
                                Url::toRoute([
                                    'toggle-display',
                                    'legalId' => $agreement->id
                                ]),
                                ['id' => 'toggle-display-pjax']
                            ) ?>
                        </td>
                        <td>
                            <?= Html::a(
                                LegalModule::t('list', 'Edit'),
                                Url::toRoute([
                                    'edit',
                                    'legalId' => $agreement->id
                                ]),
                                ['class' => 'btn btn-xs btn-warning']
                            ) ?>
                            <?= Html::a(
                                LegalModule::t('list', 'Delete'),
                                Url::toRoute([
                                    'delete',
                                    'legalId' => $agreement->id
                                ]),
                                ['class' => 'btn btn-xs btn-danger']
                            ) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php $pjax->end() ?>
        </div>
    </div>
</div>
