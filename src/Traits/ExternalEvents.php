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

    protected static array $excludeExternalEvents = [
        'booting',
        'booted',
    ];

    /**
     * @throws EloquentExternalEventsException
     */
    protected function fireModelEvent($event, $halt = true)
    {
        if (($result = parent::fireModelEvent($event, $halt)) === false) {
            return false;
        }

        if (in_array($event, self::$excludeExternalEvents)) {
            return $result;
        }

        return $this->request(
            $event,
            $this->externalModel(),
            $this->getKey(),
            $halt
        );
    }

    /**
     * @throws EloquentExternalEventsException
     */
    protected function request($event, $modelType, $modelId, $halt)
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
                'halt' => $halt,
            ]);

        if ($response->failed()) {
            throw new EloquentExternalEventsException($response->body());
        }

        return $response->json();
    }
}