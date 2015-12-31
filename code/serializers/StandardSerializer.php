<?php

/**
 * Class StandardSerializer
 */
class StandardSerializer extends Object implements ICacheSerializer
{
    public function serialize($data)
    {
        return serialize($data);
    }

    public function deserialize($bytes)
    {
        return unserialize($bytes);
    }
}
