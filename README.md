# INSTRUÇÕES:

Instalar o docker e docker compose.

Executar o comando abaixo para incializar os containers do docker (php-container e db-container):

`docker-compose up -d php-container`

O arquivo **docker/php/docker-entrypoint.sh** realizara: 

- todas as configurações de certificados para o JWT com a senha 123456;
- inclusão de um usuário de teste `{"username": "usuario", "password": "senha"}`.

Além disso foi adicionado ao projeto um exemplo de requisição de login e uma chamada a um endpoint já existente passando o token jwt no header.

**Importante:**

- Verificar a estrutura usada para refresh token uma vez que o mesmo deve ser gerado perto do tempo de término de expiração do token atual;
- Verificar implementação das controllers que não estão seguindo boas práticas de implementação;
- Utilizar a estrutura de services e repository do Symfony para encapsulamento de regras de negócio, injeção de dependência e encapsulamento de consultas;
- Criar um user provider no lugar do entity provider utilizado atualmente para validar usuários ativos e demais questões necessárias;

Espero ter ajudado.


_Eduardo Romão <eduardo.romao@outlook.com>_