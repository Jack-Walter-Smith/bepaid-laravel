<?php

/**
 * This file is part of bepaid-laravel package.
 *
 * @package  BePaid Laravel
 * @category BePaid Laravel
 * @author   Nikita Kim <n.a.kim@yandex.ru>
 * @link     https://github.com/Jack-Walter-Smith/bepaid-laravel
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace JackWalterSmith\BePaidLaravel;


use BeGateway\PaymentOperation;
use BeGateway\Response;
use BeGateway\ResponseBase;
use Illuminate\Support\Str;
use JackWalterSmith\BePaidLaravel\Contracts\IGateway;
use JackWalterSmith\BePaidLaravel\Dtos\PaymentDto;

class Payment extends GatewayAbstract
{
    /** @var \BeGateway\PaymentOperation */
    public $transaction;

    public function __construct(PaymentOperation $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * @param PaymentDto $data
     *
     * @return \BeGateway\Response
     * @throws \Exception
     */
    public function submit($data = null): ResponseBase
    {
        return parent::submit($data);
    }

    /**
     * @param PaymentDto                                                                                   $data
     * @param null|\BeGateway\Money|\BeGateway\AdditionalData|\BeGateway\Customer|\BeGateway\GetPaymentToken $object
     *
     * @return \JackWalterSmith\BePaidLaravel\Contracts\IGateway
     */
    public function fill($data, $object = null): IGateway
    {
        if ($data instanceof PaymentDto && empty($data->tracking_id)) {
            $data->tracking_id = Str::uuid();
        }

        return parent::fill($data, $object);
    }
}