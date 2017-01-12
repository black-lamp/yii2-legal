<?php
namespace bl\legalAgreement\frontend;

use bl\legalAgreement\common\components\LegalManager;
use Yii;
use yii\base\Module;

use bl\legalAgreement\frontend\controllers\DefaultController;

/**
 * Module for manipulation with legal agreements
 *
 * @property string $redirectRoute
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 * @link https://github.com/black-lamp/yii2-legal-agreement
 * @license https://opensource.org/licenses/GPL-3.0 GNU Public License
 */
class LegalModule extends Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'bl\legalAgreement\frontend\controllers';
    /**
     * @var string route for redirect in accept action
     * @see DefaultController::actionAccept()
     */
    public $redirectRoute = '/';
    /**
     * @var array configuration for LegalManager component
     */
    public $legalManagerComponent = [
        'class' => LegalManager::class
    ];


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->components = [
            'legalManager' => $this->legalManagerComponent
        ];
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('legal.' . $category, $message, $params, $language);
    }
}