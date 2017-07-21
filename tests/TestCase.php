<?php

namespace Tests;

use PHPUnit\Framework\Assert as PHPUnit;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    function setUp()
    {
        parent::setUp();

        // Define an assertion method to test if an
        // HTTP response has a given conten-type.
        //
        // The macro signature is as follows:
        // TestResponse assertContentType(string $contentType)
        TestResponse::macro('assertContentType', function ($contentType) {

            $utf8Formats = ['text/html', 'text/xml', 'text/csv'];

            if (in_array($contentType, $utf8Formats)) {
                $contentType .= '; charset=UTF-8';
            }

            $this->assertHeader('Content-Type', $contentType);

            // Return the instance to allow chaining.
            return $this;
        });

        // Define an assertion method to test if the body of
        // an HTTP response is identical to a given string.
        //
        // The macro signature is as follows:
        // TestResponse assertContentEquals(string $pathToContent)
        TestResponse::macro('assertContentEquals', function ($pathToContent) {

            $expectedContent = file_get_contents($pathToContent);

            PHPUnit::assertEquals(
                trim($expectedContent),
                trim($this->content()),
                'The content of the HTTP response is not the same as expected.'
            );

            // Return the instance to allow chaining.
            return $this;
        });
    }
}
