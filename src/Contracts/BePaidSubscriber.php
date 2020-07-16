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

namespace JackWalterSmith\BePaidLaravel\Contracts;

use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;

abstract class BePaidSubscriber
{
    const EVENT_NOTIFICATION_SUCCESS = 'bepaid.notification.success';
    const EVENT_NOTIFICATION_FAIL = 'bepaid.notification.fail';

    const EVENT_SUCCESS_URL = 'bepaid.success';
    const EVENT_FAIL_URL = 'bepaid.fail';
    const EVENT_RETURN_URL = 'bepaid.return';
    const EVENT_CANCEL_URL = 'bepaid.cancel';
    const EVENT_DECLINE_URL = 'bepaid.decline';

    /**
     * This event will be fire when data received on webhook (notification url) will pass validation
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    abstract public function onNotificationSuccess(Request $request);

    /**
     * This event will be fire when data received on webhook (notification url) will NOT pass validation
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    abstract public function onNotificationFail(Request $request);

    /**
     * This event will be fire when user will be redirected to success url
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    abstract public function onSuccess(Request $request);

    /**
     * This event will be fire when user will be redirected to fail url
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    abstract public function onFail(Request $request);

    /**
     * This event will be fire when user will be redirected to return url
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    abstract public function onReturn(Request $request);

    /**
     * This event will be fire when user will be redirected to cancel url
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    abstract public function onCancel(Request $request);

    /**
     * This event will be fire when user will be redirected to decline url
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    abstract public function onDecline(Request $request);

    /**
     * Register the listeners for the subscriber.
     *
     * @param Dispatcher $dispatcher
     */
    public function subscribe(Dispatcher $dispatcher)
    {
        $dispatcher->listen(
            self::EVENT_NOTIFICATION_SUCCESS,
            static::class . '@onNotificationSuccess'
        );

        $dispatcher->listen(
            self::EVENT_NOTIFICATION_FAIL,
            static::class . '@onNotificationFail'
        );

        $dispatcher->listen(
            self::EVENT_SUCCESS_URL,
            static::class . '@onSuccess'
        );

        $dispatcher->listen(
            self::EVENT_FAIL_URL,
            static::class . '@onFail'
        );

        $dispatcher->listen(
            self::EVENT_RETURN_URL,
            static::class . '@onReturn'
        );

        $dispatcher->listen(
            self::EVENT_CANCEL_URL,
            static::class . '@onCancel'
        );

        $dispatcher->listen(
            self::EVENT_DECLINE_URL,
            static::class . '@onDecline'
        );
    }
}