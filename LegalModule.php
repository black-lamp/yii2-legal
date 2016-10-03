<?php
namespace bl\legalAgreement;

use Yii;

/**
 * Module for adding the legal agreements on site
 *
 * Installation
 * Add this module to application config
 * ```php
 * 'modules' => [
 *      // ...
 *      'legal-agreement' => [
 *          'class' => bl\legalAgreement\LegalModule::className(),
 *          // example
 *          'languageEntity' => [
 *               'class' => bl\multilang\entities\Language::className(),
 *               'idField' => 'id',
 *               'nameField' => 'name'
 *           ]
 *      ]
 * ]
 * ```
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 *
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 *
 * @property array $languageEntity
 */
class LegalModule extends \yii\base\Module
{
    public $controllerNamespace = 'bl\legalAgreement\controllers';
    public $defaultRoute = 'create';

    public $languageEntity = [];

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('legal.' . $category, $message, $params = [], $language = null);
    }
}
