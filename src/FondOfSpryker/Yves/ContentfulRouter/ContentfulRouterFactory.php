<?php

namespace FondOfSpryker\Yves\ContentfulRouter;

use FondOfSpryker\Yves\ContentfulRouter\Dependency\Client\ContentfulRouterToContentfulClientInterface;
use FondOfSpryker\Yves\ContentfulRouter\RouteEnhancer\ControllerRouteEnhancer;
use FondOfSpryker\Yves\ContentfulRouter\Router\ContentfulRouter;
use FondOfSpryker\Yves\ContentfulRouter\RequestMatcher\ContentfulRequestMatcher;
use FondOfSpryker\Yves\ContentfulRouter\UrlGenerator\ContentfulUrlGenerator;
use Spryker\Service\Container\Container;
use Spryker\Yves\Kernel\AbstractFactory;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Matcher\RequestMatcherInterface;
use Symfony\Component\Routing\RouterInterface;

class ContentfulRouterFactory extends AbstractFactory
{

    /**
     * @return \Symfony\Component\Routing\RouterInterface
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function createRouter(): RouterInterface
    {
        return new ContentfulRouter(
            $this->createRequestMatcher(),
            $this->createUrlGenerator(),
            $this->createRouteEnhancer()
        );
    }

    /**
     * @return \Symfony\Cmf\Component\Routing\Enhancer\RouteEnhancerInterface[]
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function createRouteEnhancer(): array
    {
        return [
            new ControllerRouteEnhancer($this->getResourceCreatorPlugins()),
        ];
    }

    /**
     * @return \Symfony\Component\Routing\Matcher\RequestMatcherInterface
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function createRequestMatcher(): RequestMatcherInterface
    {
        return new ContentfulRequestMatcher(
            $this->getContentfulClient(),
            $this->getLocale()
        );
    }

    /**
     * @return \Symfony\Component\Routing\Generator\UrlGeneratorInterface
     */
    public function createUrlGenerator(): UrlGeneratorInterface
    {
        return new ContentfulUrlGenerator();
    }

    /**
     * @return \FondOfSpryker\Yves\ContentfulRouter\Dependency\Client\ContentfulRouterToContentfulClientInterface
     *
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getContentfulClient(): ContentfulRouterToContentfulClientInterface
    {
        return $this->getProvidedDependency(ContentfulRouterDependencyProvider::CLIENT_CONTENTFUL);
    }

    /**
     * @return \FondOfSpryker\Yves\ContentfulRouter\Plugin\ResourceCreator\ResourceCreatorPluginInterface[]
     *
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getResourceCreatorPlugins(): array
    {
        return $this->getProvidedDependency(ContentfulRouterDependencyProvider::PLUGIN_RESOURCE_CREATORS_CONTENTFUL);
    }

    /**
     * @return string
     */
    protected function getLocale(): string
    {
        return $this->getProvidedDependency(ContentfulRouterDependencyProvider::SERVICE_LOCALE);
    }
}
