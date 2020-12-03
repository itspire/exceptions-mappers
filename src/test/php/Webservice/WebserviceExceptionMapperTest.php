<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Exception\Mapper\Test\Webservice;

use Itspire\Exception\ExceptionInterface;
use Itspire\Exception\Mapper\ExceptionMapperInterface;
use Itspire\Exception\Mapper\Webservice\WebserviceExceptionMapper;
use Itspire\Exception\Webservice\Definition\WebserviceExceptionDefinition;
use Itspire\Exception\Webservice\WebserviceException;
use Itspire\Http\Common\Enum\HttpResponseStatus;
use PHPUnit\Framework\TestCase;

class WebserviceExceptionMapperTest extends TestCase
{
    private ?ExceptionMapperInterface $exceptionMapper = null;

    protected function setUp(): void
    {
        $this->exceptionMapper = new WebserviceExceptionMapper();
    }

    /** @test */
    public function supportsFalseTest(): void
    {
        static::assertFalse(
            $this->exceptionMapper->supports(
                $this->getMockBuilder(ExceptionInterface::class)->getMock()
            )
        );
    }

    /** @test */
    public function supportsTest(): void
    {
        static::assertTrue(
            $this->exceptionMapper->supports(
                new WebserviceException(
                    new WebserviceExceptionDefinition(WebserviceExceptionDefinition::TRANSFORMATION_ERROR)
                )
            )
        );
    }

    /** @test */
    public function mapTest(): void
    {
        $exceptionDefinition = new WebserviceExceptionDefinition(WebserviceExceptionDefinition::TRANSFORMATION_ERROR);
        $exception = new WebserviceException($exceptionDefinition);
        /** @var HttpResponseStatus $httpResponseStatus */
        $httpResponseStatus = $this->exceptionMapper->map($exception);

        static::assertEquals(HttpResponseStatus::HTTP_INTERNAL_SERVER_ERROR[0], $httpResponseStatus->getValue());
        static::assertEquals('HTTP_INTERNAL_SERVER_ERROR', $httpResponseStatus->getCode());
        static::assertEquals('Internal Server Error', $httpResponseStatus->getDescription());
    }
}
