# fond-of-spryker/contentful-router
![build](https://github.com/fond-of/spryker-contentful-router/actions/workflows/main.yml/badge.svg)
[![license](https://img.shields.io/github/license/mashape/apistatus.svg)](https://packagist.org/packages/fond-of-spryker/contentful-router)

## Description

Handles the routing for FondOfSpryker/Contentful package.
* Added support for the new routing is spryker.
* No support for Silex routing!

## Install

```
composer require fond-of-spryker/contentful-router
```

## Configuration

Register ContentfulRouterPlugin in RouterDependencyProvider
```
    protected function getRouterPlugins(): array
    {
        return [
            ...
            new ContentfulRouterPlugin(),
        ];
    }
```

## Changelog

2020-03-31
* extracted the routing stuff from fond-of-spryker/contentful package and moved it into the new routing format
