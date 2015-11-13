<?php

class CacheHelperTest extends SapphireTest {
    public function testToKey() {
        $data = [
            'local_cacheNtb\User.1' => 'local_cacheNtb_User_1',
            'local_cacheNtb\\User.1' => 'local_cacheNtb_User_1',
            'local_cacheNtb-User-1' => 'local_cacheNtb_User_1'
        ];
        foreach($data as $input => $expected) {
            $this->assertEquals($expected, CacheHelper::to_key($input));
        }
    }
}