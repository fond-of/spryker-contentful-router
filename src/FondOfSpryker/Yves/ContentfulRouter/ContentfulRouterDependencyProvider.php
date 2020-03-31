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
use Spryker\Yves\Kernel\Plugin\Pimple;

class ContentfulRouterDependencyProvider extends AbstractBundleDependencyProvider
{

    public const CLIENT_CONTENTFUL = 'CLIENT_CONTENTFUL';
    public const PLUGIN_RESOURCE_CREATORS_CONTENTFUL = 'PLUGIN_RESOURCE_CREATORS_CONTENTFUL';
    public const PLUGIN_APPLICATION = 'PLUGIN_APPLICATION';

    /**
     * @param  \Spryker\Yves\Kernel\Container  $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = $this->addContentfulClient($container);
        $container = $this->addResourceCreatorPlugins($container);
        $container = $this->provideApplication($container);

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
     * @param  \Spryker\Yves\Kernel\Container  $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function provideApplication(Container $container): Container
    {
        $container[self::PLUGIN_APPLICATION] = function () {
            $pimplePlugin = new Pimple();

            return $pimplePlugin->getApplication();
        };

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
