<?php

namespace FondOfSpryker\Yves\ContentfulRouter;

use FondOfSpryker\Yves\ContentfulRouter\Dependency\Client\ContentfulRouterToContentfulClientBridge;
use FondOfSpryker\Yves\ContentfulRouter\Plugin\ResourceCreator\BlogCategoryResourceCreatorPlugin;
use FondOfSpryker\Yves\ContentfulRouter\Plugin\ResourceCreator\BlogHomeResourceCreatorPlugin;
use FondOfSpryker\Yves\ContentfulRouter\Plugin\ResourceCreator\BlogPostResourceCreatorPlugin;
use FondOfSpryker\Yves\ContentfulRouter\Plugin\ResourceCreator\BlogTagResourceCreatorPlugin;
use FondOfSpryker\Yves\ContentfulRouter\Plugin\ResourceCreator\PageResourceCreatorPlugin;
use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;

class ContentfulRouterDependencyProvider extends AbstractBundleDependencyProvider
{

    public const CLIENT_CONTENTFUL = 'CLIENT_CONTENTFUL';
    public const PLUGIN_RESOURCE_CREATORS_CONTENTFUL = 'PLUGIN_RESOURCE_CREATORS_CONTENTFUL';

    /**
     * @var string
     */
    public const SERVICE_LOCALE = 'locale';

    /**
     * @param  \Spryker\Yves\Kernel\Container  $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = $this->addContentfulClient($container);
        $container = $this->addResourceCreatorPlugins($container);
        $container = $this->addLocale($container);

        return $container;
    }

    /**
     * @param  \Spryker\Yves\Kernel\Container  $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addContentfulClient(Container $container): Container
    {
        $container[static::CLIENT_CONTENTFUL] = function (Container $container) {
            return new ContentfulRouterToContentfulClientBridge($container->getLocator()->contentful()->client());
        };

        return $container;
    }

    /**
     * @param  \Spryker\Yves\Kernel\Container  $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addResourceCreatorPlugins(Container $container): Container
    {
        $container[static::PLUGIN_RESOURCE_CREATORS_CONTENTFUL] = function () {
            return $this->getResourceCreatorPlugins();
        };

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function addLocale(Container $container): Container
    {
        $container->set(static::SERVICE_LOCALE, function (Container $container) {
            return $container->getApplicationService(static::SERVICE_LOCALE);
        });

        return $container;
    }

    /**
     * @return \FondOfSpryker\Yves\ContentfulRouter\Plugin\ResourceCreator\ResourceCreatorPluginInterface[]
     */
    protected function getResourceCreatorPlugins()
    {
        return [
            new BlogHomeResourceCreatorPlugin(),
            new BlogCategoryResourceCreatorPlugin(),
            new BlogPostResourceCreatorPlugin(),
            new BlogTagResourceCreatorPlugin(),
            new PageResourceCreatorPlugin(true),
        ];
    }
}
