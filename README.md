# Wisemen - Pokemon

With this application you can serve your own pokemon application!

## Installation

Add your pokemons json file to the `/database/seeders/data` folder.

Then run the following commands:

```
sail up -d
sail php artisan migrate:fresh --seed
```

## Usage

See [the openapi document](./openapi.yml) for more information.
