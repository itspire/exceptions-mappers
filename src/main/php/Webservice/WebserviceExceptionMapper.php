<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Exception\Mapper\Webservice;

use Itspire\Exception\ExceptionInterface;
use Itspire\Exception\Mapper\ExceptionMapperInterface;
use Itspire\Exception\Webservice\WebserviceExceptionInterface;
use Itspire\Http\Common\Enum\HttpResponseStatus;

class WebserviceExceptionMapper implements ExceptionMapperInterface
{
    public function supports(ExceptionInterface $exception): bool
    {
        return $exception instanceof WebserviceExceptionInterface;
    }

    public function map(ExceptionInterface $exception): HttpResponseStatus
    {
        return new HttpResponseStatus(HttpResponseStatus::HTTP_INTERNAL_SERVER_ERROR);
    }
}
