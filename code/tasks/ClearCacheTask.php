<?php

class ClearCacheTask extends BuildTask {

    protected $title = 'Clear Cache Task';

    protected $description = 'This task allows an administrator to clear the cache for one or more types.';

    protected $enabled = true;

    /**
     * @param SS_HTTPRequest $request
     */
    public function run($request) {

    }
}
