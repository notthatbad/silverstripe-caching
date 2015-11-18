<?php

/**
 * Simple marker interface for better support of code completion in IDE.
 */
interface ICacheFrontend {
    /**
     * @param string $data
     * @param string $key
     */
    function save($data, $key);

    /**
     * @param string $key
     */
    function remove($key);

    /**
     * @param string $key
     * @return mixed
     */
    function load($key);
}