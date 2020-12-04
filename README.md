# INSTRU��ES:

Instalar o docker e docker compose.

Executar o comando abaixo para incializar os containers do docker (php-container e db-container):

`docker-compose up -d php-container`

O arquivo **docker/php/docker-entrypoint.sh** realizara: 

- todas as configura��es de certificados para o JWT com a senha 123456;
- inclus�o de um usu�rio de teste `{"username": "usuario", "password": "senha"}`.

Al�m disso foi adicionado ao projeto um exemplo de requisi��o de login e uma chamada a um endpoint j� existente passando o token jwt no header.

**Importante:**

- Verificar a estrutura usada para refresh token uma vez que o mesmo deve ser gerado perto do tempo de t�rmino de expira��o do token atual;
- Verificar implementa��o das controllers que n�o est�o seguindo boas pr�ticas de implementa��o;
- Utilizar a estrutura de services e repository do Symfony para encapsulamento de regras de neg�cio, inje��o de depend�ncia e encapsulamento de consultas;
- Criar um user provider no lugar do entity provider utilizado atualmente para validar usu�rios ativos e demais quest�es necess�rias;

Espero ter ajudado.


_Eduardo Rom�o <eduardo.romao@outlook.com>_