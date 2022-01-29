# api-agendamento-tarefa
Implementação de API agendamento de tarefas para Vaga dev

### **Iniciar o Projeto**

1. Clonar o repositório - `git clone`
2. Entra para pasta do projeto - `cd api-agendamento-tarefa`
3. Executar comando `composer install` para baixar todas dependências
4. Executar o comando - `php artisan key:generate`
5. Copiar  o .env.example cria um arquivo .env e editar as credenciais do banco
6. Editar o nome do banco para - ` agendamento_tarefas`
7. Executa o comando `php artisan migrate:refresh` para criar as tabelas do banco
8. Executar o comando `php artisan storage:link`
9. Executa o comando para rodar o projeto `php artisan serve`

[Licença MIT](LICENSE)
