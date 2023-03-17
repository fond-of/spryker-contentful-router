<?php

namespace FondOfSpryker\Yves\ContentfulRouter\UrlGenerator;

use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RequestContext;

class ContentfulUrlGenerator implements UrlGeneratorInterface
{
    /**
     * @var \Symfony\Component\Routing\RequestContext
     */
    protected $requestContext;

    /**
     * @inheritDoc
     *
     * @throws \Symfony\Component\Routing\Exception\RouteNotFoundException
     */
    public function generate(string $name, array $parameters = [], int $referenceType = self::ABSOLUTE_PATH): string
    {
        throw new RouteNotFoundException('YET NOT IMPLEMENTED');
    }

    /**
     * @param \Symfony\Component\Routing\RequestContext $context
     *
     * @return void
     */
    public function setContext(RequestContext $context)
    {
        $this->requestContext = $context;
    }

    /**
     * @return \Symfony\Component\Routing\RequestContext
     */
    public function getContext(): RequestContext
    {
        return $this->requestContext;
    }
}
