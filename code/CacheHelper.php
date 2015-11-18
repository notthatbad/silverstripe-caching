<?php

/**
 * Simple helper for the Silverstripe cache system.
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
     * TODO: Their is a Zend_Cache_Frontend for this functionality. Maybe this should be used.
     * @param callable $fn the function which should be cached
     * @return mixed the result of the function with the given arguments
     */
    public static function cache_function($fn) {
        $args = array_slice(func_get_args(), 1);
        $key = self::to_key($fn."_".serialize($args));
        $cache = self::get_cache();
        if($data = $cache->load($key)) {
            return unserialize($data);
        } else {
            // if not found call function and write result to cache
            $data = call_user_func_array($fn, $args);
            $cache->save(serialize($data), $key);
            // return result
            return $data;
        }
    }

    /**
     * @return ICacheFrontend the current configured cache
     */
    public static function get_cache() {
        return SS_Cache::factory('local_cache');
    }
}