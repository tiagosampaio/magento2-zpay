<?php

namespace ZPay\Standard\Model\ResourceModel\Transaction;

class OrderFactory extends \ZPay\Standard\Model\AbstractFactory
{

    public function __construct(
        \Magento\Framework\ObjectManagerInterface $objectManager
    ) {
        parent::__construct($objectManager, Order::class);
    }
}
