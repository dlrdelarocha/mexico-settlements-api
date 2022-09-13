
# México Settlements API

This microservice allows search for le settlements in Mexico using the postal code.


## Environment Variables

To run this project, you will need to add the following environment variables to your .env file


Copy the file .env.example and renamed it to .env

```bash
  cp  .env.example .env 
```

```bash
`DB_CONNECTION=mongodb`  
`DB_HOST=mongo`
`DB_PORT=27017`
`DB_DATABASE=settlements`
`DB_USERNAME=root`
`DB_PASSWORD=root`
```
## Run Locally

Clone the project

```bash
 git clone https://github.com/dlrdelarocha/mexico-settlements-api.git
```

Go to the project directory

```bash
  cd mexico-settlements-api
```

Install dependencies

NOTE: This project implements [Laravel Sail](https://laravel.com/docs/9.x/sail) to run Locally.
Project requires composer to be installed

```bash
 composer install
```

```bash
  run ./vendor/bin/sail builder --no-cache
  run ./vendor/bin/sail up
```
## Import Settlements


Go to [SAT](https://www.correosdemexico.gob.mx/SSLServicios/ConsultaCP/CodigoPostal_Exportar.aspx)
and dowload all regions using .txt format.

![](https://github.com/dlrdelarocha/mexico-settlements-api/blob/main/public/settlements-sat.png)

Extract the archive and place it in the storage/settlements folder.

Finally, Run the following command to import the data to MongoDB

```bash
  ./vendor/bin/sail php artisan settlements:migrate 
  ./vendor/bin/sail php artisan migrate --path=/database/migrations/2022_09_13_161019_create_settlements_zipcode_index.php
```

## API Reference

#### Gets a list of settlements by zipcode

```http
  GET /api/zip-codes/{zipcode}
```

