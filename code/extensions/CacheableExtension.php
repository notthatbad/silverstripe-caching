<?php

/**
 * The cacheable data object extension
 */
class CacheableExtension extends DataExtension {

    /**
     *
     */
    public function onAfterWrite() {
        $serializer = CacheHelper::get_serializer();
        // update the cache
        CacheHelper::get_cache()->save($serializer->serialize($this->owner), $this->key());
        parent::onAfterWrite();
    }

    /**
     *
     */
    public function onBeforeDelete() {
        // delete the cache
        CacheHelper::get_cache()->remove($this->key());
        parent::onBeforeDelete();
    }

    private function key() {
        $name = $this->ownerBaseClass;
        $id = $this->Identifier();
        return CacheHelper::to_key("$name.$id");
    }

    /**
     * @return mixed
     */
    public function Identifier() {
        return property_exists($this->owner, 'URLSegment') ? $this->owner->URLSegment : $this->owner->ID;
    }
}