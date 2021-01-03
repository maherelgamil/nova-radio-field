<?php

namespace Maherelgamil\NovaRadioField;

use Laravel\Nova\Fields\Field;
use Laravel\Nova\Http\Requests\NovaRequest;

class NovaRadioField extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'nova-radio-field';

    /**
     * The options for the field.
     *
     * @var array
     */
    public $options;

    /**
     * Set the options for the field.
     *
     * @param  array|\Closure|\Illuminate\Support\Collection
     * @return $this
     */
    public function options($options)
    {
        if (is_callable($options)) {
            $options = $options();
        }

        $this->options = with(collect($options), function ($options) {
            return $options->map(function ($label, $name) use ($options) {
                return $options->isAssoc()
                    ? ['label' => $label, 'name' => $name]
                    : ['label' => $label, 'name' => $label];
            })->values()->all();
        });

        return $this;
    }

    /**
     * Hydrate the given attribute on the model based on the incoming request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @param  string  $requestAttribute
     * @param  object  $model
     * @param  string  $attribute
     * @return void
     */
    protected function fillAttributeFromRequest(NovaRequest $request, $requestAttribute, $model, $attribute)
    {
        if ($request->exists($requestAttribute)) {
            $model->{$attribute} = json_decode($request[$requestAttribute], true);
        }
    }

    /**
     * Prepare the field for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'options' => $this->options,
        ]);
    }
}
