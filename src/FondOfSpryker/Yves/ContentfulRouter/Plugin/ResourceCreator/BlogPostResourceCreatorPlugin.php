<?php

namespace FondOfSpryker\Yves\ContentfulRouter\Plugin\ResourceCreator;

class BlogPostResourceCreatorPlugin implements ResourceCreatorPluginInterface
{
    private const RESOURCE_TYPE = 'blog';

    private const ACTION_NAME = 'post';

    protected const MODULE_NAME = 'Contentful';

    /**
     * @var bool
     */
    protected $isDefault;

    /**
     * BlogPostResourceCreator constructor.
     *
     * @param  bool  $isDefault
     */
    public function __construct(bool $isDefault = false)
    {
        $this->isDefault = $isDefault;
    }

    /**
     * @return string
     */
    public function getModuleName(): string
    {
        return static::MODULE_NAME;
    }

    /**
     * @return string
     */
    public function getActionName(): string
    {
        return static::ACTION_NAME;
    }

    /**
     * @return string
     */
    public function getControllerName(): string
    {
        return static::RESOURCE_TYPE;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return static::RESOURCE_TYPE.ucfirst($this->getActionName());
    }

    /**
     * @return bool
     */
    public function isDefault(): bool
    {
        return $this->isDefault;
    }
}
