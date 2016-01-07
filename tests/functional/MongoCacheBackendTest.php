<?php

/**
 * Tests the Zend Cache Backend with a Mongo driver against the MongoClient.
 */
class MongodbBackendTest extends SapphireTest {

    private static $cache_opts = [
        'host' => '127.0.0.1',
        'port' => 27017,
        'dbname' => 'ss_cache',
        'collection' => 'cache'
    ];
    /**
     * @var MongoCollection
     */
    private $collection;
    private static $backend_name = 'test_mongo_cache';
    private static $cache_name = 'test_mongo_cache';

    public function setUp() {
        parent::setUp();
        // set client
        $opts = self::$cache_opts;
        $con = new \MongoClient("mongodb://{$opts['host']}:{$opts['port']}");
        $db = $con->{$opts['dbname']};
        $this->collection = $db->selectCollection($opts['collection']);
    }

    public function setUpOnce() {
        parent::setUpOnce();
        // set backend
        SS_Cache::add_backend(self::$backend_name, new MongodbBackend(self::$cache_opts));
        SS_Cache::pick_backend(self::$backend_name, self::$cache_name, 100);
    }

    public function tearDown() {
        parent::tearDown();
        // clear mongo db
        $this->collection->drop();
    }

    public function testExistence() {
        $cache = SS_Cache::factory(self::$cache_name);
        $this->assertNotNull($cache);
    }

    public function testWrite() {
        $id = "somekey";
        $value = "Foo";
        $this->assertEquals(null, $this->collection->findOne());
        $cache = SS_Cache::factory(self::$cache_name);
        /** @var ICacheFrontend$cache */
        $cache->save($value, $id);
        $this->assertEquals(1, $this->collection->find()->count());
        $this->assertEquals($value, $this->collection->find()->getNext()['content']);
    }

    public function testRead() {
        $id = "somekey";
        $value = "Foo";
        $cache = SS_Cache::factory(self::$cache_name);
        /** @var ICacheFrontend$cache */
        $cache->save($value, $id);
        $this->assertEquals($value, $cache->load($id));
    }
}
