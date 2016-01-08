<?php

class CacheHelperTest extends SapphireTest {
    public function testToKey() {
        $data = [
            'local_cacheNtb\User.1' => 'local_cacheNtb_User_1',
            'local_cacheNtb\\User.1' => 'local_cacheNtb_User_1',
            'local_cacheNtb-User-1' => 'local_cacheNtb_User_1'
        ];
        foreach($data as $input => $expected) {
            $this->assertEquals($expected, CacheHelper::to_key($input));
        }
    }

    public function testGetSerializer() {
        $serializer = CacheHelper::get_serializer();
        $this->assertTrue(ClassInfo::classImplements($serializer->class, 'ICacheSerializer'));
    }

    public function testCacheFunction() {
        $call = CacheHelper::cache_function('CacheHelperTest::helperFunction', 1, 'test');
        sleep(2);
        $cache = CacheHelper::cache_function('CacheHelperTest::helperFunction', 1, 'test');
        $this->assertEquals($call, $cache);
    }

    public function testCacheFunctionWithVariousParameter() {
        $first = CacheHelper::cache_function('CacheHelperTest::helperFunction', 1, 'string');
        $second = CacheHelper::cache_function('CacheHelperTest::helperFunction', 2, 'string');
        $this->assertNotEquals($first, $second);
    }

    public static function helperFunction($int, $string) {
        $result = $int.$string.time();
        return $result;
    }

    public function testGetCache() {
        $cache = CacheHelper::get_cache();
        $this->assertEquals(ClassInfo::class_name($cache), 'Zend_Cache_Frontend_Function');
    }
}
