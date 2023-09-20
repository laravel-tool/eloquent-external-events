<?php

namespace LaravelTool\EloquentExternalEvents\Traits;

use LaravelTool\EloquentExternalEvents\Exceptions\EloquentExternalEventsException;

trait ExternalEvents
{
    abstract public function externalModel(): string;

    public function getExternalEventConnectionName(): string
    {
        return 'default';
    }

    /**
     * @throws EloquentExternalEventsException
     */
    protected function fireModelEvent($event, $halt = true)
    {
        if (($result = parent::fireModelEvent($event, $halt)) === false) {
            return false;
        }

        if (!config('eloquent_external_events.enabled', true)) {
            return $result;
        }

        if (in_array($event, config('eloquent_external_events.excluded_events', ['booting', 'booted', 'retrieved']))) {
            return $result;
        }

        return $this->request(
            $event,
            $this->externalModel(),
            $this->getKey(),
            $this->attributes,
            $this->original,
            $this->changes,
            $halt
        );
    }

    /**
     * @throws EloquentExternalEventsException
     */
    protected function request($event, $modelType, $modelId, $attributes, $originals, $changes, $halt)
    {
        $configPath = 'eloquent_external_events.connections.'.$this->getExternalEventConnectionName();
        $token = config($configPath.'.token');
        $endpoint = config($configPath.'.endpoint');

        $response = \Http::asJson()
            ->acceptJson()
            ->withToken($token)
            ->post($endpoint, [
                'event' => $event,
                'model_type' => $modelType,
                'model_id' => $modelId,
                'attributes' => $attributes,
                'originals' => $originals,
                'changes' => $changes,
                'halt' => $halt,
            ]);

        if ($response->failed()) {
            throw new EloquentExternalEventsException($response->body());
        }

        return $response->json();
    }
}