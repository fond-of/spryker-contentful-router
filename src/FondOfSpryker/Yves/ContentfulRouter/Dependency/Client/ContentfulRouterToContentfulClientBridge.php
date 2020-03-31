<?php

namespace FondOfSpryker\Yves\ContentfulRouter\Dependency\Client;

use FondOfSpryker\Client\Contentful\ContentfulClientInterface;

class ContentfulRouterToContentfulClientBridge implements ContentfulRouterToContentfulClientInterface
{
    /**
     * @var \FondOfSpryker\Client\Contentful\ContentfulClientInterface
     */
    protected $contentfulClient;

    /**
     * ContentfulRouterToContentfulClientBridge constructor.
     *
     * @param  \FondOfSpryker\Client\Contentful\ContentfulClientInterface  $contentfulClient
     */
    public function __construct(ContentfulClientInterface $contentfulClient)
    {
        $this->contentfulClient = $contentfulClient;
    }

    /**
     * @param string $url
     * @param string $localeName
     *
     * @return string[]|null
     */
    public function matchUrl(string $url, string $localeName): ?array
    {
        return $this->contentfulClient->matchUrl($url, $localeName);
    }
}
