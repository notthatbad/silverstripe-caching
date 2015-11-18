<?php

/**
 * Interface ICacheSerializer
 */
interface ICacheSerializer {
    /**
     * @param mixed $data
     * @return string
     */
    function serialize($data);

    /**
     * @param string $bytes
     * @return mixed
     */
    function deserialize($bytes);
}