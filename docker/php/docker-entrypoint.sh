
#composer install --ansi --no-interaction

openssl genpkey -out /app/config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096 -pass pass:123456
openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout -passin pass:123456
php /app/bin/console doctrine:database:drop --force --no-interaction --if-exists
php /app/bin/console doctrine:database:create --no-interaction
php /app/bin/console doctrine:schema:update --force --no-interaction
php /app/bin/console doctrine:query:sql "insert into users (id, username, password, is_active) values (3, 'usuario3', '\$2y\$12\$qTjtlD6eUNILhvhLYHPB8OxYwoieBSKJggLPv4NimMS4OpzsK6YFC', true);"
echo "Usuario: usuario, Senha: senha"

php -S 0.0.0.0:8000 -t public/