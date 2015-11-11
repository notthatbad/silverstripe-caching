<?php

/**
 * The cacheable data object extension
 */
class CacheableExtension extends DataExtension {

<<<<<<< HEAD
    /**
     *
     */
    public function onAfterWrite() {
        // update the cache
        CacheHelper::get_cache()->save(serialize($this->owner), $this->key());
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
        return "$name.$id";
    }

    /**
     * @return mixed
     */
    public function Identifier() {
        return property_exists($this->owner, 'URLSegment') ? $this->owner->URLSegment : $this->owner->ID;
    }
=======
>>>>>>> da8a888a7ed8879b404906383d8ac7d22387b475
}