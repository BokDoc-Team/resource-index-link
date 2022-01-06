<?php

namespace Causelabs\ResourceIndexLink;

use Laravel\Nova\Fields\Text;
use Config;

class ResourceIndexLink extends Text
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'resource-index-link';

    protected $primaryKey = 'id';

    /**
     * Sets the link to open in a new tab.
     *
     * @return $this
     */
    public function newTab()
    {
        return $this->withMeta(['newTab' => true]);
    }

    /**
     * Sets the field ID attribute.
     *
     * @return $this
     */
    public function fieldKey($column)
    {
        $this->primaryKey = $column ?? $this->primaryKey;

        return $this->withMeta(['fieldKey' => $this->primaryKey]);
    }

    /**
     * Sets the link prefix.
     *
     * @return $this
     */
    public function prefix($str)
    {
        return $this->withMeta(['prefix' => $str]);
    }

    /**
     * Sets the link suffix.
     *
     * @return $this
     */
    public function suffix($str)
    {
        return $this->withMeta(['suffix' => $str]);
    }

    /**
     * Overriding the base method in order to grab the model ID.
     *
     * @param mixed       $resource  The resource class
     * @param string|null $attribute The attribute of the resource
     *
     * @return mixed
     */
    public function resolve($resource, $attribute = null)
    {
        $this->setResourceId(data_get($resource, method_exists($resource, 'getKeyName') ? $resource->getKeyName() : 'id'));

        return parent::resolve($resource, $attribute);
    }

    /**
     * Sets the ID of the resource. Used when builing the URL.
     *
     * @param mixed $id The ID of the resource model. Also sets the base URL based on the Nova config
     *
     * @return void
     */
    protected function setResourceId($id)
    {
        $path = Config::get('nova.path');
        // If the path is the site route, prevent a double-slash
        if ('/' === $path) {
            $path = '';
        }
        return $this->withMeta(['id' => $id, 'nova_path' => $path]);
    }
}
