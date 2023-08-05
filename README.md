# Eloquent external events via API

## Setup
1. Add trait ExternalEvents to model
2. Add `eloquent_external_events` config:
    ```php
    return [
        'connections' => [
            'default' => [
                'endpoint' => env('ELOQUENT_EXTERNAL_EVENTS_API_ENDPOINT'),
                'token' => env('ELOQUENT_EXTERNAL_EVENTS_API_TOKEN'),
            ],
        ],
    ];
    ```
3. Add name of external model:
    ```php
    public function externalModel(): string
    {
        return 'App\Models\Application';
    }
    ```
4. Add connection name to model from `eloquent_external_events` config:
    ```php
    public function getExternalEventConnectionName(): string
    {
        return 'kyc';
    }
    ```
5. See https://github.com/laravel-tool/eloquent-external-events-server