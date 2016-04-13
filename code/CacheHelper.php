<?php

/**
 * Simple helper for the Silverstripe cache system.
 * @author Christian Blank <c.blank@notthatbad.net>
 */
class CacheHelper {

    /**
     * Returns a key, which can be used inside the cache
     *
     * @param string $str the key which should be used for caching
     * @return string the formatted key
     */
    public static function to_key($str) {
        return preg_replace('/[^a-zA-Z0-9_]/', '_', $str);
    }

    /**
     * Cache function results based on their arguments. This is only useful for pure functions.
     *
     * Usage:
     *
     * ```
     * $result = CacheHelper::cache_function('FooBar::heavy_calculation', $arg1, $arg2, $arg3);
     * ```
     *
     * @param callable $fn the function which should be cached
     * @return mixed the result of the function with the given arguments
     */
    public static function cache_function($fn) {
        $args = array_slice(func_get_args(), 1);
        $cache = self::get_cache();
        $data = $cache->call($fn, $args);
        // return result
        return $data;
    }

    /**
     * @return ICacheFrontend the current configured cache
     */
    public static function get_cache($frontend='Function') {
        $localCacheName = Config::inst()->get('CacheHelper', 'LocalCache');
        return SS_Cache::factory($localCacheName, $frontend);
    }

    /**
     * @return ICacheFrontend the current configured cache
     */
    public static function get_local_cache() {
        $localCacheName = Config::inst()->get('CacheHelper', 'LocalCache');
        return SS_Cache::factory($localCacheName);
    }

    /**
     * @return ICacheFrontend the current configured cache
     */
    public static function get_global_cache() {
        $globalCacheName = Config::inst()->get('CacheHelper', 'GlobalCache');
        return SS_Cache::factory($globalCacheName);
    }

    /**
     * @return ICacheSerializer
     * @throws Exception
     */
    public static function get_serializer() {
        return Injector::inst()->create('CacheSerializer');
    }
}
