<?php
/**
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @copyright Copyright (c) 2016 Vladimir Kuprienko
 * @license GNU Public License
 */

use yii\helpers\Url;
use yii\helpers\Html;

/**
 * View for [[\bl\legalAgreement\backend\widgets\Language]] widget
 *
 * @var \yii\web\View $this
 * @var array $languages
 * @var array $currentLanguage
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
?>

<div class="dropdown pull-right">
    <button type="button"
            class="dropdown-toggle btn btn-xs btn-warning"
            id="languages-menu"
            data-toggle="dropdown"
            aria-haspopup="true"
            aria-expanded="true">
        <?= current($currentLanguage) ?>
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" aria-labelledby="languages-menu">
        <?php foreach($languages as $id => $name): ?>
            <?php if($id == key($currentLanguage)) continue; ?>
            <li>
                <?= Html::a($name, Url::current(['languageId' => $id])) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<div class="clearfix"></div>
