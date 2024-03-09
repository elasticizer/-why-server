# why-server

To install dependencies:

```bash
composer install
```

To serve:

```bash
env $(cat ./.env | xargs) php -S 0.0.0.0:80 -t ./www/ -d variables_order=EGPCS
```
