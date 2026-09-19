# 2Read

[![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=flat-square&logo=laravel&logoColor=white)](https://laravel.com)
[![Docker](https://img.shields.io/badge/Docker-2496ED?style=flat-square&logo=docker&logoColor=white)](https://www.docker.com/)
[![Justfile](https://img.shields.io/badge/Just-000000?style=flat-square&logo=just&logoColor=white)](https://github.com/casey/just)
[![Scramble](https://img.shields.io/badge/Scramble-FF3E00?style=flat-square&logo=openapi-initiative&logoColor=white)](https://scramble.dedoc.co)
[![Truss](https://img.shields.io/badge/Truss-000000?style=flat-square&logo=php&logoColor=white)](https://github.com/truss)

_Uma API REST headless e leve para gerenciamento e leitura offline de artigos, inspirada no Pocket._

---

## Documentação

Toda a documentação técnica do projeto está centralizada no diretório `docs/`:

*   [Visão Geral do Projeto](docs/overview.md)
*   [Guia de Instalação e Execução Local](docs/installation.md)
*   [Arquitetura e Escopo da API](docs/architecture.md)
*   [Documentação dos Endpoints (OpenAPI/Scramble)](docs/api-reference.md)

---

## Como Executar o Projeto

Certifique-se de ter o **Docker** e o **Just** instalados na sua máquina.

1. Clone o repositório:
   ```bash
   git clone [https://github.com/joaogabrielmndz/2Read.git](https://github.com/joaogabrielmndz/2Read.git)
   cd seu-projeto
2. Inicie o setup do projeto com o comando:
   ```bash
   just setup
   ```