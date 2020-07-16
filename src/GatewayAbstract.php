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

use BeGateway\{AuthorizationOperation, CardToken, GetPaymentToken, PaymentOperation, ResponseBase};
use Illuminate\Support\Str;
use JackWalterSmith\BePaidLaravel\Contracts\IGateway;
use JackWalterSmith\BePaidLaravel\Dtos\{AuthorizationDto,
    CardTokenDto,
    PaymentDto,
    PaymentTokenDto,
    ProductDto,
    RefundDto
};

abstract class GatewayAbstract implements IGateway
{
    /** @var AuthorizationOperation|CardToken|GetPaymentToken|PaymentOperation */
    public $transaction;

    /**
     * @param AuthorizationDto|CardTokenDto|PaymentDto|PaymentTokenDto|ProductDto|RefundDto $data
     *
     * @return \BeGateway\ResponseBase
     * @throws \Exception
     */
    public function submit($data = null): ResponseBase
    {
        if ($data) $this->fill($data);

        return $this->transaction->submit();
    }

    /**
     * @param AuthorizationDto|CardTokenDto|PaymentDto|PaymentTokenDto|ProductDto|RefundDto $data
     * @param null                                                                          $object
     *
     * @return \JackWalterSmith\BePaidLaravel\Contracts\IGateway
     */
    public function fill($data, $object = null): IGateway
    {
        $obj = $object ?? $this->transaction;

        foreach ($data as $property => $value) {
            if ($value !== null) {
                if (is_object($value)) {
                    $snakeCaseProp = Str::snake($property);
                    $this->fill($value, $obj->{$snakeCaseProp});
                } else {
                    $formattedProperty = strtolower(str_replace('_', '', $property));
                    $method = "set{$formattedProperty}";
                    if (method_exists($obj, $method)) {
                        $obj->{$method}($value);
                    }
                }
            }
        }

        return $this;
    }
}