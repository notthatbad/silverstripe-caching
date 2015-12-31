<?php

/**
 * This subclass adds a caching layer to the data list implementation of Silverstripe.
 *
 */
class CachedDataList extends DataList
{

    /**
     * @param int $id the id of an data object
     * @return DataObject the data object with the given id
     */
    public function byID($id)
    {
        return $this->cache($id, function () use ($id) {return parent::byID($id);});
    }

    /**
     * Needs the DataListExtension from ntb/silverstripe-rest-api.
     *
     * @param string $url the url slug
     * @return DataObject the data object with the given url slug
     */
    public function byURL($url)
    {
        return $this->cache($url, function () use ($url) {return parent::byURL($url);});
    }

    /**
     * FixMe: Currently only db and has_one fields are cached.
     * @param string|int $identifier an identifier which will be used for key generation
     * @param callable $callback the function which can be called to fetch the data
     * @return DataObject
     */
    protected function cache($identifier, $callback)
    {
        $serializer = CacheHelper::get_serializer();
        // check for cacheable extension of data object class
        $className = $this->dataClass;
        if (Object::has_extension($className, 'CacheableExtension')) {
            // search in cache
            $cache = CacheHelper::get_cache();
            $key = CacheHelper::to_key("$className.$identifier");
            if ($data = $cache->load($key)) {
                return $serializer->deserialize($data);
            } else {
                // if not found in cache, perform callback
                $data = $callback();
                if (!$data) {
                    // if result is empty, return null
                    return null;
                }
                $cachedFunctions = array_keys($data->hasOne());
                foreach ($cachedFunctions as $fn) {
                    $data->$fn();
                }
                $cache->save($serializer->serialize($data), $key);
                // return result
                return $data;
            }
        } else {
            return $callback();
        }
    }
}
