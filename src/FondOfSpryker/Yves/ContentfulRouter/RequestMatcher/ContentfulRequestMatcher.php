<?php

namespace FondOfSpryker\Yves\ContentfulRouter\RequestMatcher;

use FondOfSpryker\Yves\ContentfulRouter\Dependency\Client\ContentfulRouterToContentfulClientInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\RequestMatcherInterface;

class ContentfulRequestMatcher implements RequestMatcherInterface
{
    /**
     * @var \FondOfSpryker\Yves\ContentfulRouter\Dependency\Client\ContentfulRouterToContentfulClientInterface
     */
    protected $contentfulClient;

    /**
     * @var string
     */
    protected $locale;

    /**
     * @param \FondOfSpryker\Yves\ContentfulRouter\Dependency\Client\ContentfulRouterToContentfulClientInterface $contentfulClient
     * @param string $locale
     */
    public function __construct(
        ContentfulRouterToContentfulClientInterface $contentfulClient,
        string $locale
    ) {
        $this->contentfulClient = $contentfulClient;
        $this->locale = $locale;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @throws \Symfony\Component\Routing\Exception\ResourceNotFoundException
     *
     * @return array
     */
    public function matchRequest(Request $request): array
    {
        $pathInfo = $request->getPathInfo();

        // remove trailing slash at the end (added from nginx, removed to match key)
        if ($pathInfo !== '/' && substr($pathInfo, -1) === '/') {
            $pathInfo = substr($pathInfo, 0, -1);
        }

        $data = $this->contentfulClient->matchUrl($pathInfo, $this->locale);
        if ($data) {
            return $data;
        }

        throw new ResourceNotFoundException(sprintf('Contentful route %s not found!', $pathInfo));
    }
}
