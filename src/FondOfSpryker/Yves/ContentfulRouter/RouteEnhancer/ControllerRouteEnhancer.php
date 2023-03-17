<?php

namespace FondOfSpryker\Yves\ContentfulRouter\RouteEnhancer;

use FondOfSpryker\Yves\ContentfulRouter\Exception\DefaultResourceCreatorNotSetException;
use FondOfSpryker\Yves\ContentfulRouter\Plugin\ResourceCreator\ResourceCreatorPluginInterface;
use Spryker\Yves\Kernel\BundleControllerAction;
use Spryker\Yves\Kernel\ClassResolver\Controller\ControllerResolver;
use Spryker\Yves\Kernel\Controller\BundleControllerActionRouteNameResolver;
use Symfony\Cmf\Component\Routing\Enhancer\RouteEnhancerInterface;
use Symfony\Component\HttpFoundation\Request;

class ControllerRouteEnhancer implements RouteEnhancerInterface
{
    /**
     * @var array<\FondOfSpryker\Yves\ContentfulRouter\Plugin\ResourceCreator\ResourceCreatorPluginInterface>
     */
    protected $resourceCreatorPlugins;

    /**
     * @param array<\FondOfSpryker\Yves\ContentfulRouter\Plugin\ResourceCreator\ResourceCreatorPluginInterface> $resourceCreatorPlugins
     */
    public function __construct(array $resourceCreatorPlugins)
    {
        $this->resourceCreatorPlugins = $resourceCreatorPlugins;
    }

    /**
     * @param array $defaults
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array
     */
    public function enhance(array $defaults, Request $request): array
    {
        foreach ($this->resourceCreatorPlugins as $resourceCreator) {
            if ($resourceCreator->isDefault() === false && $defaults['type'] === $resourceCreator->getType()) {
                return $this->createResource($resourceCreator, $defaults);
            }
        }

        return $this->createResource($this->getDefaultResourceCreator(), $defaults);
    }

    /**
     * @param \FondOfSpryker\Yves\ContentfulRouter\Plugin\ResourceCreator\ResourceCreatorPluginInterface $resourceCreator
     * @param array $data
     *
     * @return array
     */
    protected function createResource(ResourceCreatorPluginInterface $resourceCreator, array $data)
    {
        $bundleControllerAction = new BundleControllerAction(
            $resourceCreator->getModuleName(),
            $resourceCreator->getControllerName(),
            $resourceCreator->getActionName(),
        );
        $routeResolver = new BundleControllerActionRouteNameResolver($bundleControllerAction);

        $controllerResolver = new ControllerResolver();
        $controller = $controllerResolver->resolve($bundleControllerAction);
        $actionName = $resourceCreator->getActionName();
        if (strrpos($actionName, 'Action') === false) {
            $actionName .= 'Action';
        }

        return [
            'entryId' => $data['value'],
            '_controller' => [$controller, $actionName],
            '_route' => $routeResolver->resolve(),
        ];
    }

    /**
     * @throws \FondOfSpryker\Yves\ContentfulRouter\Exception\DefaultResourceCreatorNotSetException
     *
     * @return \FondOfSpryker\Yves\ContentfulRouter\Plugin\ResourceCreator\ResourceCreatorPluginInterface
     */
    protected function getDefaultResourceCreator(): ResourceCreatorPluginInterface
    {
        foreach ($this->resourceCreatorPlugins as $resourceCreatorPlugin) {
            if ($resourceCreatorPlugin->isDefault()) {
                return $resourceCreatorPlugin;
            }
        }

        throw new DefaultResourceCreatorNotSetException('Please set "isDefault = true" for one of the registered ResourceCreators in ContentfulRouterDependencyProvider');
    }
}
