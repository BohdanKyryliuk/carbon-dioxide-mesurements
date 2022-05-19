# Carbon Dioxide measurements
A service which collects data and alerts if the CO2 concentrations reached critical levels.

## Requirements

- Docker

## Sail

The local development environment uses Docker powered by Laravel Sail. It is recommended that you alias `sail` with this command:

```shell
$ alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'
```

## Installation

```shell
$ gh repo clone BohdanKyryliuk/carbon-dioxide-mesurements
$ cd carbon-dioxide-mesurements
$ ./install
$ sail up -d
$ sail artisan migrate
```

## Testing

### Run the test suite
```shell
$ sail composer test
```

### Run the full CI suite of checks
```shell
$ sail composer suite
```

## API documentation

### Collect sensor measurements
```shell
POST /api/v1/sensors/{uuid}/mesurements
{
    "co2" : 2000,
    "time" : "2022-05-19T14:55:47+00:00"
}
```

### Sensor status
```shell
GET /api/v1/sensors/{uuid}

Response:
{
  "status" : "OK" // Possible status OK,WARN,ALERT
}
```

### Sensor metrics
```shell
GET /api/v1/sensors/{uuid}/metrics
Response:
{
    "maxLast30Days" : 1200,
    "avgLast30Days" : 900
}
```

### Listing alerts
```shell
GET /api/v1/sensors/{uuid}/alerts
Response:
[
    {
        "startTime" : "2022-05-019T18:55:47+00:00",
        "endTime" : "2022-05-019T20:00:47+00:00",
        "mesurement1" : 2100,
        "mesurement2" : 2200,
        "mesurement3" : 2100
    }
]
```
