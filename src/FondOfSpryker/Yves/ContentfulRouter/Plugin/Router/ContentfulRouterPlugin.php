<?php

namespace FondOfSpryker\Yves\ContentfulRouter\Plugin\Router;

use Spryker\Yves\Kernel\AbstractPlugin;
use Spryker\Yves\RouterExtension\Dependency\Plugin\RouterPluginInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * @method \FondOfSpryker\Yves\ContentfulRouter\ContentfulRouterFactory getFactory()
 */
class ContentfulRouterPlugin extends AbstractPlugin implements RouterPluginInterface
{
    /**
     * @return \Symfony\Component\Routing\RouterInterface
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getRouter(): RouterInterface
    {
        return $this->getFactory()->createRouter();
    }
}
