<?php

namespace FondOfSpryker\Yves\ContentfulRouter\Plugin\ResourceCreator;

interface ResourceCreatorPluginInterface
{
    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return string
     */
    public function getModuleName(): string;

    /**
     * @return string
     */
    public function getActionName(): string;

    /**
     * @return string
     */
    public function getControllerName(): string;

    /**
     * @return bool
     */
    public function isDefault(): bool;
}
