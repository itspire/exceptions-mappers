<?php

/*
 * Copyright (c) 2016 - 2020 Itspire.
 * This software is licensed under the BSD-3-Clause license. (see LICENSE.md for full license)
 * All Right Reserved.
 */

declare(strict_types=1);

namespace Itspire\Exception\Mapper\Test\Http;

use Itspire\Exception\ExceptionInterface;
use Itspire\Exception\Http\Definition\HttpExceptionDefinition;
use Itspire\Exception\Http\HttpException;
use Itspire\Exception\Mapper\ExceptionMapperInterface;
use Itspire\Exception\Mapper\Http\HttpExceptionMapper;
use Itspire\Http\Common\Enum\HttpResponseStatus;
use PHPUnit\Framework\TestCase;

class HttpExceptionMapperTest extends TestCase
{
    private ?ExceptionMapperInterface $exceptionMapper = null;

    protected function setUp(): void
    {
        $this->exceptionMapper = new HttpExceptionMapper();
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
                new HttpException(new HttpExceptionDefinition(HttpExceptionDefinition::HTTP_BAD_REQUEST))
            )
        );
    }

    /** @test */
    public function mapTest(): void
    {
        $exceptionDefinition = new HttpExceptionDefinition(HttpExceptionDefinition::HTTP_BAD_REQUEST);
        $exception = new HttpException($exceptionDefinition);
        /** @var HttpResponseStatus $httpResponseStatus */
        $httpResponseStatus = $this->exceptionMapper->map($exception);

        static::assertEquals(HttpExceptionDefinition::HTTP_BAD_REQUEST[0], $httpResponseStatus->getValue());
        static::assertEquals('HTTP_BAD_REQUEST', $httpResponseStatus->getCode());
        static::assertEquals('Bad Request', $httpResponseStatus->getDescription());
    }
}
