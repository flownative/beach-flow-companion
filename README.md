[![MIT license](http://img.shields.io/badge/license-MIT-brightgreen.svg)](http://opensource.org/licenses/MIT)
[![Packagist](https://img.shields.io/packagist/v/flownative/beach-flow-companion.svg)](https://packagist.org/packages/flownative/beach-flow-companion)
[![Maintenance level: Acquaintance](https://img.shields.io/badge/maintenance-%E2%99%A1-ff69b4.svg)](https://www.flownative.com/en/products/open-source.html)

# Flownative Beach Flow Companion

This package provides convenient configuration for Flow applications which are hosted on
[Flownative Beach](https://www.flownative.com/en/products/beach.html).

It provides the following functionality:

- configure the encryption key to be stored in the database (using the PDO cache backend)
- automatically create the caching table in the database on `flow:cache:warmup`

## DEPRECATION NOTICE

This package is easily be replaced by according configuration in Flow 5.2 and up.

You should configure your caches for use of the PDO cache backend (like shown below)
to have the encryption key stored in the database. Or any other cache that is not
flushed upon deployment. Our [guide on caching with Redis](https://www.flownative.com/en/documentation/guides/beach/how-to-use-redis-for-caching-for-neos-and-flow.html)
has more details on this.

To have the caches set up as needed,  call the `flow:cache:setupall` command in your
deployment scripts, e.g. after `flow:cache:warmup`.

## Installation

If you want to use this companion, simply require:

```bash
$ composer require 'flownative/beach-flow-companion:1.*'
```

In case you are using Flow 3.*, you need to include a version with legacy support:

```bash
$ composer require 'flownative/beach-flow-companion:0.*'
```

## Configuration

The configuration shipped with the package contains is set up so it will work on
Flownative Beach right away. If you want to use the package elsewhere, adjust
the caches configuration as needed, this is the default:

```yaml
Flow_Security_Cryptography_HashService:
  backend: Neos\Cache\Backend\PdoBackend
  backendOptions:
    dataSourceName: 'mysql:host=%env:BEACH_DATABASE_HOST%;dbname=%env:BEACH_DATABASE_NAME%'
    username: '%env:BEACH_DATABASE_USERNAME%'
    password: '%env:BEACH_DATABASE_PASSWORD%'
    defaultLifetime: 0
```

**Warning**

It is possible to use the PdoBackend from this package without configuring the DB
connection directly. It does then fall back to the Doctrine connection configuration
used for the persistence layer.

If doing so, the `Flownative\BeachFlowCompanion\Cache\PdoBackend` must only be used
for caches marked as `persistent`. If used for non-persistent caches, the lack of
injection for compile-time commands will break any such command, like, ironically,
`flow:cache:flush`.
