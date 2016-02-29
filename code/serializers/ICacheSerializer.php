<?php

/**
 * Interface ICacheSerializer
 */
interface ICacheSerializer {
    /**
     * @param mixed $data
     * @return string
     */
    public function serialize($data);

    /**
     * @param string $bytes
     * @return mixed
     */
    public function deserialize($bytes);
}