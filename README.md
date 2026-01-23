🏛️ Sistema de Gestão de Manifestações (Ouvidoria FASPM/PA)
📝 Sobre o Projeto
Este é um sistema Web robusto desenvolvido para a gestão completa de manifestações (denúncias, sugestões, reclamações, elogios e solicitações) da Ouvidoria do Fundo de Assistência Social da Polícia Militar do Pará.

O sistema permite o registro de manifestações via portal público ou inserção manual pela equipe interna, garantindo o cumprimento da Lei de Acesso à Informação (LAI) através do controle automatizado de prazos e transparência ativa.

✨ Funcionalidades Principais
Portal do Manifestante: Interface para registro de demandas e acompanhamento via protocolo.

Cálculo Automático de Prazos: Prazos definidos por tipo de manifestação (15, 20 ou 30 dias) com contagem regressiva visual.

Gestão Administrativa: Painel completo para edição de status, prioridade, setor responsável e inserção de respostas.

Searchable Dropdowns: Seleção de setores e responsáveis com busca em tempo real (Select2).

Controle de Acesso (ACL): Gestão de permissões via pacotes Spatie (Admin, Ouvidor, Secretário).

Relatórios Estratégicos: Índices de resolutividade, cumprimento de prazos (LAI) e perfil de identificação dos usuários.

Transparência Ativa: Espaço para Carta de Serviços e Relatórios Anuais em PDF.

⚙️ Tecnologias Utilizadas
Framework: Laravel 11 / PHP 8.2+

Banco de Dados: MySQL 5.7+ / 8.0

Segurança: Spatie Laravel-Permission

Front-end: Blade Templates, Bootstrap 5, FontAwesome, Select2.

🚀 Instalação e Configuração (Ambiente Local)
Pré-requisitos
PHP 8.2 ou superior

Composer

MySQL/MariaDB

Git

Passos para a Instalação
Clone o Repositório:

Bash
git clone https://github.com/MB-Leal/ouvidoria.git
cd ouvidoria
Instale as Dependências:

Bash
composer install
Configuração de Ambiente: Crie o arquivo .env e gere a chave da aplicação:

Bash
cp .env.example .env
php artisan key:generate
Banco de Dados: Crie um banco de dados no MySQL (ex: ouvidoria) e configure o .env:

Snippet de código
DB_DATABASE=ouvidoria
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
APP_URL=http://127.0.0.1:8000
⚠️ Nota para MySQL antigo: Se encontrar o erro "Specified key was too long", o projeto já inclui a correção no AppServiceProvider.php com Schema::defaultStringLength(125).

Migrações e Permissões: Execute as migrações para criar as tabelas (incluindo as tabelas do Spatie):

Bash
php artisan migrate
Popular o Banco (Seeders): Cadastre os tipos de manifestação e os administradores (Marcos e Adriano):

Bash
php artisan db:seed --class=TipoManifestacaoSeeder
php artisan db:seed --class=RolesAndUsersSeeder
Arquivos e Storage: Crie o link simbólico para visualização de anexos:

Bash
php artisan storage:link
Certifique-se de que os arquivos PDF da Carta de Serviços estejam em public/files/.

Inicie o Servidor:

Bash
php artisan serve
🔒 Acesso ao Painel Administrativo
URL: http://127.0.0.1:8000/login

Credenciais de Administrador:

Marcos Leal: marcosbleal26@gmail.com | Senha: marcos123

Adriano Maia: drikomaia89@gmail.com | Senha: adriano123

📁 Estrutura de Pastas de Anexos
Para o correto funcionamento dos uploads:

Anexos de manifestações: storage/app/public/anexos/

Documentos institucionais: public/files/

Desenvolvedor: Marcos Leal

Contato: marcosbleal26@gmail.com

WhatsApp: +55 91 98149-0019