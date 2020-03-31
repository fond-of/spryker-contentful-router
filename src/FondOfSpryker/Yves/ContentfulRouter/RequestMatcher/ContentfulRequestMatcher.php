<?php

namespace FondOfSpryker\Yves\ContentfulRouter\RequestMatcher;

use FondOfSpryker\Yves\ContentfulRouter\Dependency\Client\ContentfulRouterToContentfulClientInterface;
use Spryker\Service\Container\Container;
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
     * @var \Spryker\Service\Container\Container
     */
    protected $application;

    /**
     * ContentfulRequestMatcher constructor.
     *
     * @param  \FondOfSpryker\Yves\ContentfulRouter\Dependency\Client\ContentfulRouterToContentfulClientInterface  $contentfulClient
     * @param  \Spryker\Service\Container\Container  $application
     */
    public function __construct(
        ContentfulRouterToContentfulClientInterface $contentfulClient,
        Container $application
    ) {
        $this->contentfulClient = $contentfulClient;
        $this->application = $application;
    }

    /**
     * @param  \Symfony\Component\HttpFoundation\Request  $request
     *
     * @return array
     * @throws \Symfony\Component\Routing\Exception\ResourceNotFoundException
     *
     */
    public function matchRequest(Request $request): array
    {
        $pathInfo = $request->getPathInfo();

        // remove trailing slash at the end (added from nginx, removed to match key)
        if ($pathInfo !== '/' && substr($pathInfo, -1) === '/') {
            $pathInfo = substr($pathInfo, 0, -1);
        }

        $data = $this->contentfulClient->matchUrl($pathInfo, $this->application['locale']);
        if (!empty($data)) {
            return $data;
        }

        throw new ResourceNotFoundException(sprintf('Contentful route %s not found!', $pathInfo));
    }
}
