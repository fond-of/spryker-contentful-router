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
    public function generate($name, $parameters = [], $referenceType = self::ABSOLUTE_PATH)
    {
        throw new RouteNotFoundException('YET NOT IMPLEMENTED');
    }

    public function setContext(RequestContext $context)
    {
        $this->requestContext = $context;
    }

    public function getContext(): RequestContext
    {
        return $this->requestContext;
    }

}
