# Guia de Instalação

Guia passo a passo para configurar e executar o ambiente de desenvolvimento local do projeto **2Read**.

---

## Pré-requisitos

Antes de começar, certifique-se de ter as seguintes ferramentas instaladas no seu sistema:

* **[Docker](https://www.docker.com/)** (Docker Desktop ou Docker Engine com Docker Compose)
* **[Just](https://github.com/casey/just)** (Command Runner)
* **[Git](https://git-scm.com/)**

> **Nota:** Como o projeto utiliza o **Laravel Sail**, não precisa de ter o PHP ou o Composer instalados localmente na sua máquina. Tudo é executado dentro de containers Docker.

---

## Passo a Passo de Instalação

### 1. Clonar o Repositório

Faça o clone do repositório para o seu ambiente local e acesse a pasta do projeto:

```bash
git clone [https://github.com/joaogabrielmndz/2Read.git](https://github.com/joaogabrielmndz/2Read.git)
cd 2Read
```

### 2. Executar o Setup automático

Utilize o just para automatizar as configs inicial do ambiente
```bash
just setup
```

Este comando:
1. Baixa a imagem oficial do Laravel Sail e instala as dependências do composer sem necesidade do PHP local.
2. Inicia os containers do Docker em segundo plano (sail up -d).
3. Cria o arquivo de configuração .env a partir do .env.example.
4. Gera a chave de criptografia da aplicação.
5. Executa as migrações do banco.

## Acesso à Aplicação

- http://localhost
- http://localhost/truss (Schema do banco de dados)