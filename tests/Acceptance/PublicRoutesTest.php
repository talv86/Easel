<?php

namespace EaselTest\Acceptance;

use Easel\Models\User;
use EaselTest\TestCase;

/**
 * Class PublicRoutesTest.
 *
 * Test the response code for each publicly accessible route.
 */
class PublicRoutesTest extends TestCase
{
    /**
     * Test the response code for the Blog page.
     *
     * @return void
     */
    public function testBlogPageResponseCode()
    {
        factory(User::class)->make();
        $response = $this->call('GET', config('easel.blog_base_url'));
        $this->assertEquals(200, $response->status());
    }

    /**
     * Test the response code for the Login page.
     *
     * @return void
     */
    public function testLoginPageResponseCode()
    {
        $response = $this->call('GET', '/login');
        $this->assertEquals(200, $response->status());
    }
}
