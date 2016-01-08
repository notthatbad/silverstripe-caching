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

    public function testCacheDataObject() {
        $key = 'Member_1';
        $data = $this->cacheDataObject();
        $cache = CacheHelper::get_cache()->load($key);
        $this->assertEquals($data, CacheHelper::get_serializer()->deserialize($cache));
    }

    public function testCacheDataListWithoutCacheableExtension() {
        $key = 'Member_1';
        Member::remove_extension('CacheableExtension');
        $this->cacheDataObject();
        $cache = CacheHelper::get_cache()->load($key);
        $this->assertFalse($cache);
    }

    protected function cacheDataObject($class = 'Member', $id = 1) {
        $result = CachedDataList::create($class)->byID($id);
        return $result;
    }
}
