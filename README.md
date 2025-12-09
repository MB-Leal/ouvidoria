🏛️ Sistema de Gestão de Manifestações (Ouvidoria)
<br>
📝 Sobre o Projeto
Este é um sistema Web robusto e intuitivo desenvolvido para a gestão completa de manifestações (denúncias, sugestões, reclamações, elogios e solicitações) de uma Ouvidoria.

O sistema permite o registro de manifestações via formulário web ou de forma manual pela equipe, o rastreamento por protocolo, atribuição de responsabilidade por setor/usuário, definição de prioridades, controle de prazos de resposta e manutenção de um histórico completo do atendimento.

O painel administrativo oferece funcionalidades para a equipe interna, como a edição de informações de status, prioridade, resposta e observações internas.

✨ Funcionalidades Principais
Registro de Manifestações: Permite o cadastro manual pela equipe e a integração para registro via interface pública (não inclusa nos arquivos, mas implícita).

Controle de Protocolo: Geração automática e única de protocolos (ProtocoloService).

Gestão de Status e Prioridade: Definição de ABERTO, EM ANÁLISE, RESPONDIDO e FINALIZADO, além de prioridades (baixa a urgente).

Atribuição e Responsabilidade: Atribuição de manifestações a usuários específicos (Ouvidor, Secretário ou Admin).

Controle de Prazos: Campo para data_limite_resposta e cálculo de dias restantes.

Registro de Resposta: Campos dedicados para resposta pública e observacao_interna.

Rastreamento de Data: Registro automático de data_resposta quando o status é alterado para RESPONDIDO.

Controle de Acesso (ACL): Definição de permissões baseadas em role (Admin, Ouvidor, Secretário) para edição e atribuição.

⚙️ Tecnologias Utilizadas
Framework: Laravel (PHP)

Banco de Dados: MySQL

Front-end: HTML, CSS, JavaScript (e provavelmente Bootstrap/Blade Templates para o layout de administração).

Dependências PHP: Composer

🚀 Instalação e Configuração (Ambiente Local)
Siga os passos abaixo para configurar o projeto em sua máquina local:

Pré-requisitos
PHP 8.2+

Composer

Git

Servidor de banco de dados (MySQL/MariaDB)

Passos para a Instalação
Clone o Repositório:

Bash

git clone https://github.com/seu-usuario/seu-repositorio.git
cd seu-repositorio
Instale as Dependências do PHP:

Bash

composer install
Configure o Arquivo de Ambiente: Crie o arquivo .env copiando o exemplo:

Bash

cp .env.example .env
Gere a Chave da Aplicação:

Bash

php artisan key:generate
Configure o Banco de Dados: No arquivo .env, configure as credenciais do seu banco de dados:

Snippet de código

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ouvidoria
DB_USERNAME=root
DB_PASSWORD=


Execute as Migrations e Seeders (Opcional):

Bash

No VS Code ou cmd
php artisan migration (para criar as tabelas do banco de dados)
php artisan migrate --seed
Certifique-se de que suas Migrations e Seeders existam e estejam prontas para criar as tabelas users, manifestacoes, tipos_manifestacao, etc.

Crie o Link Simbólico para Storage: Necessário para o armazenamento de anexos (anexo_path).

Bash

php artisan storage:link
Inicie o Servidor Local:

Bash

php artisan serve
O sistema estará acessível em http://127.0.0.1:8000.

🔒 Acesso ao Painel Administrativo
Acesse a URL de administração e utilize as credenciais de um usuário cadastrado com a role apropriada (Admin/Ouvidor/Secretário) para gerir as manifestações:

URL de Acesso: http://127.0.0.1:8000/admin/login

Se funcionar corretamente, poderá acessar com os dados:
usuario: admin@admin.com.br
Senha: admin123

usuario: ouvidor@admin.com.br
senha: ouvidor123

usuario: secretario@admin.com.br
senha: secretario123


Exemplo de URL de Edição: http://127.0.0.1:8000/admin/manifestacoes/7/edit

🤝 Como Contribuir
Contribuições são bem-vindas! Se você encontrar bugs, tiver sugestões de novas funcionalidades ou melhorias, sinta-se à vontade para:

Fazer um Fork do projeto.

Criar uma nova branch (git checkout -b feature/minha-melhoria).

Fazer suas alterações e commitar (git commit -am 'feat: Adiciona nova funcionalidade X').

Fazer push para a branch (git push origin feature/minha-melhoria).

Abrir um Pull Request.

Faltam pequenos ajustes para concluir

Dev: Marcos Leal
E-mail: marcosbleal26@gmail.com
Whatsapp: +5591981490019


📄 Licença
Este projeto está licenciado sob a Licença MIT - veja o arquivo LICENSE.md para detalhes.
