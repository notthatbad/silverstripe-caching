Silverstripe Caching
====================

[![Build Status](https://travis-ci.org/notthatbad/silverstripe-caching.svg)](https://travis-ci.org/notthatbad/silverstripe-caching)
[![Latest Stable Version](https://poser.pugx.org/ntb/silverstripe-caching/v/stable)](https://packagist.org/packages/ntb/silverstripe-caching)
[![License](https://poser.pugx.org/ntb/silverstripe-caching/license)](https://packagist.org/packages/ntb/silverstripe-caching)

Add ability to cache data objects, function results and arbitrary data.

## Usage

Like other extensions, you can add the ability to automatically cache objects with the following code to your YAML files.

```
Member:
  extensions:
    - CacheableExtension
```

It is recommended to specify rather another cache than Silverstripe's default cache, because it is configured to use the
file cache backend. This could be much worse than the direct access to the database.

## How it works

When requesting a data object with `<ClassName>::byID` or `<ClassName>::byURL` the cached data list implementation
evaluates if the request object is flagged as cacheable. If this is true, the cache will be requested and only if
nothing is found, the database is accessed. After fetching the object, every has_one dependency is fetched and the
result is stored in a cache.

When a data object should be deleted or was modified, the cache entry will be cleared or alternated respectively.
