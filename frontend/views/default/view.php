<?php
use yii\helpers\Html;
use yii\helpers\Url;

use bl\legalAgreement\frontend\Module as LegalModule;
use bl\legalAgreement\common\entities\Legal;

/**
 * View file for Default controller in Legal frontend module
 * 
 * @var \yii\web\View $this
 * @var Legal $agreement
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 */

\yii\bootstrap\BootstrapAsset::register($this);
?>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div>
            <?= $agreement->translation->text ?>
        </div>
        <div class="text-center">
            <?= Html::a(
                LegalModule::t('frontend', 'Accept agreement'),
                Url::toRoute([
                    'accept-agreement',
                    'legalId' => $agreement->id,
                    'userId' => Yii::$app->user->id
                ]),
                ['class' => 'btn btn-success']
            ) ?>
        </div>
    </div>
</div>
