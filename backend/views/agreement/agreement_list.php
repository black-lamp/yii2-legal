<?php
use yii\widgets\Pjax;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;

use bl\legalAgreement\backend\LegalModule;

/**
 * View file for Agreement controller
 * @see \bl\legalAgreement\backend\controllers\AgreementController
 *
 * @var yii\web\View $this
 * @var ActiveDataProvider $provider
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 */

\yii\bootstrap\BootstrapAsset::register($this);
?>

<div class="container">
    <div class="row">
        <h1 class="text-center">
            <?= LegalModule::t('agreement.list', 'Legal list') ?>
        </h1>

        <?php Pjax::begin([
            'enablePushState' => false,
            'linkSelector' => '.pjax-btn'
        ]) ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>
                            <?= LegalModule::t('agreement.list', 'Type') ?>
                        </th>
                        <th>
                            <?= LegalModule::t('agreement.list', 'Version') ?>
                        </th>
                        <th>
                            <?= LegalModule::t('agreement.list', 'Show') ?>
                        </th>
                        <th>
                            <?= LegalModule::t('agreement.list', 'Actions') ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?= ListView::widget([
                        'dataProvider' => $provider,
                        'itemView' => '_agreement'
                    ]) ?>
                </tbody>
            </table>
        <?php Pjax::end() ?>
    </div>
</div>
