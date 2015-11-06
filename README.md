Silverstripe Caching
====================

Add ability to cache data objects in a transparent way.

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

When requesting a data object, the di