<?php

namespace ZPay\Standard\Exception;

use Magento\Framework\Phrase;

abstract class AbstractException extends \Exception
{

    /**
     * @var \Magento\Framework\Phrase
     */
    protected $phrase;

    /**
     * @var string
     */
    protected $logMessage;


    /**
     * @param \Magento\Framework\Phrase $phrase
     * @param \Exception $cause
     * @param int $code
     */
    public function __construct(Phrase $phrase, \Exception $cause = null, $code = 0)
    {
        $this->phrase = $phrase;
        parent::__construct($phrase->render(), intval($code), $cause);
    }

}