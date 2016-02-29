<?php

/**
 * Simple marker interface for better support of code completion in IDE.
 */
interface ICacheFrontend {
    /**
     * @param string $data
     * @param string $key
     */
    public function save($data, $key);

    /**
     * @param string $key
     */
    public function remove($key);

    /**
     * @param string $key
     * @return mixed
     */
    public function load($key);
}