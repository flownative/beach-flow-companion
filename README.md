[![MIT license](http://img.shields.io/badge/license-MIT-brightgreen.svg)](http://opensource.org/licenses/MIT)
[![Packagist](https://img.shields.io/packagist/v/flownative/beach-flow-companion.svg)](https://packagist.org/packages/flownative/beach-flow-companion)
[![Maintenance level: Love](https://img.shields.io/badge/maintenance-%E2%99%A1%E2%99%A1%E2%99%A1-ff69b4.svg)](https://www.flownative.com/en/products/open-source.html)

# Flownative Beach Flow Companion

This package provides convenient configuration and additional tools for Flow applications which are hosted on
[Flownative Beach](https://www.flownative.com/en/products/beach.html).

In this early version it provides the following functionality:

- configure the encryption key to be stored in the database (using the PDO cache backend)
- automatically create the caching table in the database on `flow:cache:warmup`

## Installation

If you are using this package in a Flownative Beach project, there's nothing specific you need to do: this package
is automatically installed via `composer require` when the Docker image of your project is built.

If you want to try out this companion in your development setup, simply require it yourself:

```bash
    $ composer require 'flownative/beach-flow-companion:1.*'
```

In case you are using Flow 3.*, you need to include a version with legacy support:

```bash
    $ composer require 'flownative/beach-flow-companion:0.*'
```
