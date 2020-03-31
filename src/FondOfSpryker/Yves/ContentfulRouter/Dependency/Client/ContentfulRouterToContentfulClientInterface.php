<?php

namespace FondOfSpryker\Yves\ContentfulRouter\Dependency\Client;

interface ContentfulRouterToContentfulClientInterface
{
    /**
     * @param string $url
     * @param string $localeName
     *
     * @return string[]|null
     */
    public function matchUrl(string $url, string $localeName): ?array;
}
