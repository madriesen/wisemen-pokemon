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

See [the openapi document](./openapi.yml) for more information. You can import this document into [Insomnia](https://insomnia.rest/).

**Note:** To use the `/teams` endpoint you need to add the `Authorization`-header (`my-team-token`).
