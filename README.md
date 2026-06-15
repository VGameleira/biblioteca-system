# Biblioteca - Sistema de Gerenciamento

**Sistema completo de gerenciamento de biblioteca em PHP com MySQL**

[![PHP](https://img.shields.io/badge/PHP-7.4-777BB4?logo=php)](https://php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-5.7-4479A1?logo=mysql)](https://www.mysql.com/)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](LICENSE)

Sistema CRUD completo para biblioteca com controle de empréstimos, devoluções e cálculo automático de multas. Autenticação com perfis de acesso (admin/aluno).

### Funcionalidades

- CRUD de livros com upload de capa
- Cadastro e autenticação de usuários
- Registro de empréstimos e devoluções
- Cálculo automático de multas
- Dashboard com estatísticas
- Prepared Statements para segurança

### Instalação

```bash
git clone https://github.com/VGameleira/Biblioteca.git
cd Biblioteca
cp .env.example .env
mysql -u root -p < biblioteca.sql
php -S localhost:8000
```

---

MIT License — Veja [LICENSE](LICENSE).

**Vinícius dos Santos Gameleira** — [@VGameleira](https://github.com/VGameleira)
