<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SphinxSearch extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSphinxIndex()
    {
        $sphinx = new \sngrl\SphinxSearch\SphinxSearch();
        $result = $sphinx->search('roman', 'test1')->query();

        $this->assertEquals(
            '', $result['error']
        );
    }
}
