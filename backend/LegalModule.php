<?php
namespace bl\legalAgreement\backend;

use Yii;
use yii\base\Module;
use yii\di\Container;

/**
 * Module for adding the legal agreements on site
 *
 * @property array $languageProvider
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
    public $controllerNamespace = 'bl\legalAgreement\backend\controllers';

    /**
     * @inheritdoc
     */
    public $defaultRoute = 'create';

    /**
     * @var array field of language entity
     * Example
     * ```php
     * 'languageProvider' => [
     *      'class' => bl\legalAgreement\backend\providers\DbLanguageProvider::className(),
     *      'arModel' => bl\multilang\entities\Language::className(),
     *      'idField' => 'id',
     *      'nameField' => 'name'
     * ]
     * ```
     */
    public $languageProvider;

    /**
     * @var Container with dependencies
     */
    private $_container;

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->_container;
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->_container = new Container();
        $this->registerDependencies();
    }

    private function registerDependencies()
    {
        $this->_container->set('bl\legalAgreement\providers\LanguageProviderInterface', $this->languageProvider);
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('legal.' . $category, $message, $params, $language);
    }
}
