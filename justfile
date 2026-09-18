sail := "./vendor/bin/sail"

# ------------------------------------------------------------------------------
# AMBIENTE & SAIL
# ------------------------------------------------------------------------------

# Executa o setup inicial do projeto (instala dependências, sobe Docker e configura o app)
setup:
    @echo "Instalando dependências via Sail..."
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php83-composer:latest \
        composer install --ignore-platform-reqs
    @echo "Iniciando os containers..."
    {{sail}} up -d
    @echo "Executando o setup do Laravel..."
    {{sail}} composer run setup

# Inicia os containers em segundo plano
up:
    {{sail}} up -d

# Para os containers
down:
    {{sail}} down

# Reinicia os containers
restart:
    {{sail}} restart

# Lista os containers ativos
ls:
    {{sail}} ps

# Acessa o terminal do container do app
sh:
    {{sail}} shell
# Exibe os logs do Sail
sail-logs:
    {{sail}} logs

# ------------------------------------------------------------------------------
# BANCO DE DADOS
# ------------------------------------------------------------------------------

# Roda as migrations pendentes
migrate:
    {{sail}} artisan migrate

# Recria o banco do zero e executa as seeders
fresh:
    {{sail}} composer run fresh

# Apaga todas as tabelas do banco de dados
[confirm("Tem certeza que deseja apagar TODAS as tabelas do banco? (y/n)")]
db-wipe:
    {{sail}} artisan db:wipe

# ------------------------------------------------------------------------------
# DESENVOLVIMENTO & ARTISAN
# ------------------------------------------------------------------------------

# Atalho universal para qualquer comando do Artisan (Ex: just art make:model Page -m)
art *ARGS:
    {{sail}} artisan {{ARGS}}

# Limpa todos os caches da aplicação
clear:
    {{sail}} artisan optimize:clear

# Executa a suíte de testes
test:
    {{sail}} artisan test
# Exibe todas as Rotas da aplicação
routes:
    {{sail}} artisan route:list
# Exibe os logs os ultimos logs registrados da aplicação
get-logs:
    tail -f storage/logs/laravel.log