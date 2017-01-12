<?php
namespace bl\legalAgreement\common\events;

use yii\base\Event;

/**
 * Event for LegalManager component
 *
 * @author Vladimir Kuprienko <vldmr.kuprienko@gmail.com>
 */
class LegalAccept extends Event
{
    /**
     * @var integer
     */
    public $legalId;
    /**
     * @var integer
     */
    public $userId;
}