<?php
/**
 * ZPay Payment Gateway
 *
 * @category ZPay
 * @package ZPay\Standard
 * @author Tiago Sampaio <tiago@tiagosampaio.com>
 * @link https://github.com/tiagosampaio
 * @link https://tiagosampaio.com
 *
 * Copyright (c) 2019.
 */

declare(strict_types = 1);

namespace ZPay\Standard\Model\Transaction;

use ZPay\Standard\Api\Data\TransactionOrderInterface;
use ZPay\Standard\Api\TransactionStatusVerification;

/**
 * Class StatusVerification
 *
 * @package ZPay\Standard\Model\Transaction
 */
class StatusVerification implements TransactionStatusVerification
{
    /**
     * @param TransactionOrderInterface|string $paymentStatus
     *
     * @return boolean
     */
    public function isPaid($paymentStatus)
    {
        return $this->compareStatus($this->getPaymentStatus($paymentStatus), self::PAYMENT_STATUS_PAID);
    }

    /**
     * @param TransactionOrderInterface|string $paymentStatus
     *
     * @return boolean
     */
    public function isUnpaid($paymentStatus)
    {
        return $this->compareStatus($this->getPaymentStatus($paymentStatus), self::PAYMENT_STATUS_UNPAID);
    }

    /**
     * @param TransactionOrderInterface|string $paymentStatus
     *
     * @return boolean
     */
    public function isOverpaid($paymentStatus)
    {
        return $this->compareStatus($this->getPaymentStatus($paymentStatus), self::PAYMENT_STATUS_OVERPAID);
    }

    /**
     * @param TransactionOrderInterface|string $paymentStatus
     *
     * @return boolean
     */
    public function isUnderpaid($paymentStatus)
    {
        return $this->compareStatus($this->getPaymentStatus($paymentStatus), self::PAYMENT_STATUS_UNDERPAID);
    }

    /**
     * @param TransactionOrderInterface|string $orderStatus
     *
     * @return boolean
     */
    public function isCompleted($orderStatus)
    {
        return $this->compareStatus($this->getOrderStatus($orderStatus), self::ORDER_STATUS_COMPLETED);
    }

    /**
     * @param TransactionOrderInterface|string $orderStatus
     *
     * @return boolean
     */
    public function isCreated($orderStatus)
    {
        return $this->compareStatus($this->getOrderStatus($orderStatus), self::ORDER_STATUS_CREATED);
    }

    /**
     * @param TransactionOrderInterface $transactionOrder
     * @param                           $orderStatus
     *
     * @return boolean
     */
    public function isFailed($orderStatus)
    {
        return $this->compareStatus($this->getOrderStatus($orderStatus), self::ORDER_STATUS_FAILED);
    }

    /**
     * @param TransactionOrderInterface|string $orderStatus
     *
     * @return boolean
     */
    public function isProcessing($orderStatus)
    {
        return $this->compareStatus($this->getOrderStatus($orderStatus), self::ORDER_STATUS_PROCESSING);
    }

    /**
     * @param TransactionOrderInterface|string $orderStatus
     *
     * @return boolean
     */
    public function isCanceled($orderStatus)
    {
        if (self::ORDER_STATUS_CANCELED == $this->getOrderStatus($orderStatus)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $status
     *
     * @return bool
     */
    public function isPaymentStatusValid($status)
    {
        $valid = [
            self::PAYMENT_STATUS_PAID,
            self::PAYMENT_STATUS_OVERPAID,
            self::PAYMENT_STATUS_UNDERPAID,
            self::PAYMENT_STATUS_UNPAID,
        ];

        if (!in_array($status, $valid)) {
            return false;
        }

        return true;
    }

    /**
     * @param string $status
     *
     * @return bool
     */
    public function isOrderStatusValid($status)
    {
        $valid = [
            self::ORDER_STATUS_CANCELED,
            self::ORDER_STATUS_COMPLETED,
            self::ORDER_STATUS_CREATED,
            self::ORDER_STATUS_FAILED,
            self::ORDER_STATUS_PROCESSING,
        ];

        if (!in_array($status, $valid)) {
            return false;
        }

        return true;
    }

    /**
     * @param string $status
     * @param string $comparedStatus
     *
     * @return bool
     */
    private function compareStatus($status, $comparedStatus)
    {
        return $status === $comparedStatus;
    }

    /**
     * @param TransactionOrderInterface|string $object
     *
     * @return string
     */
    private function getPaymentStatus($object)
    {
        if ($object instanceof TransactionOrderInterface) {
            return $object->getZpayPayoutStatus();
        }

        return (string) $object;
    }

    /**
     * @param TransactionOrderInterface|string $object
     *
     * @return string
     */
    private function getOrderStatus($object)
    {
        if ($object instanceof TransactionOrderInterface) {
            return $object->getZpayOrderStatus();
        }

        return (string) $object;
    }
}
