<?php

/**
 *  Tests for CachedDataList
 */
class CachedDataListTest extends SapphireTest {

    public function setUp() {
        parent::setUp();
        // clear cache
        SS_Cache::factory('local_cache')->clean(Zend_Cache::CLEANING_MODE_ALL);
        Member::add_extension('CacheableExtension');
    }

    public function testCacheFunction() {
        $call = CacheHelper::cache_function('CachedDataListTest::expensiveFunction');
        $cache = CacheHelper::cache_function('CachedDataListTest::expensiveFunction');
        $this->assertEquals($call, $cache);
    }

    public function testCacheFunctionWithVariousParameter() {
        $call = CacheHelper::cache_function('CachedDataListTest::helperFunction', 1, 'string');
        $cache = CacheHelper::cache_function('CachedDataListTest::helperFunction', 2, 'string');
        $this->assertNotEquals($call, $cache);
    }

    public function testCacheData() {
        $serializer = CacheHelper::get_serializer();
        $users = CachedDataList::create('Member');
        $user = $users->byID(1);
        $loaded = CacheHelper::get_cache()->load('Member_1');
        $this->assertEquals($user, $serializer->deserialize($loaded));
    }

    public static function expensiveFunction() {
        $result = time();
        sleep(2);
        return $result;
    }

    public static function helperFunction($int, $string) {
        $result = $int.$string;
        return $result;
    }
}
