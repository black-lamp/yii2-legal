<?php
namespace bl\legalAgreement\frontend\behaviors;

use Yii;
use yii\base\Behavior;
use yii\web\Controller;

use bl\legalAgreement\common\components\LegalManager;

/**
 * Redirect user to page with legal agreement
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class RedirectBehavior extends Behavior
{
    /**
     * @var string Legal agreement controller name
     */
    public $legalController = 'bl\legalAgreement\frontend\controllers\DefaultController';
    /**
     * @var string Action with legal agreement
     */
    public $legalAction = 'view';
    /**
     * @var integer ID of the legal agreement
     */
    public $legalId;
    /**
     * @var string|callable Route to page with legal agreement
     */
    public $legalPageRoute;


    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction'
        ];
    }

    /**
     * Checking if user is not accepted the legal agreement
     * this method redirect his to page with legal agreement
     *
     * @param \yii\base\ActionEvent $event
     * @return bool|\yii\web\Response
     */
    public function beforeAction($event)
    {
        $user = Yii::$app->getUser();
        if (!$user->getIsGuest()) {
            $action = $event->action;
            if ($action->controller instanceof $this->legalController &&
                $action->id === $this->legalAction) {
                return true;
            }

            /** @var LegalManager $legalManager */
            $legalManager = Yii::createObject(LegalManager::class);
            if (!$legalManager->isUserAccepted($user->getId(), $this->legalId)) {
                $route = (is_callable($this->legalPageRoute)) ?
                    call_user_func($this->legalPageRoute) :
                    $this->legalPageRoute;

                return Yii::$app->getResponse()->redirect($route);
            }
        }

        return true;
    }
}