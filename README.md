# Jogo de Países e Capitais

Este é um projeto de teste desenvolvido em Laravel para praticar e fixar os conceitos de layouts e componentização com Blade.

## Sobre o Projeto

O objetivo principal foi criar uma aplicação web simples, mas funcional, utilizando os recursos do Laravel para estruturar o front-end de forma modular e reutilizável. Foram explorados os seguintes conceitos:

-   **Layouts Blade:** Criação de um template principal (`main-layout`) que define a estrutura comum a todas as páginas (cabeçalho, rodapé, inclusão de assets).
-   **Componentes Blade:** Desenvolvimento de componentes reutilizáveis para partes específicas da interface, como o logo, a caixa de questão e as alternativas de resposta.
-   **Rotas e Controladores:** Definição de rotas para cada etapa do jogo e um controlador (`MainController`) para gerenciar toda a lógica.
-   **Sessão:** Uso da sessão para armazenar o estado do jogo (progresso do quiz, pontuação, etc.) entre as requisições.

## Lógica do Jogo

O jogo é um quiz simples de "acerte a capital" com o seguinte fluxo:

1.  **Início:** O usuário acessa a página inicial, onde define com quantas perguntas deseja jogar (mínimo de 3, máximo de 30).

2.  **Preparação do Quiz:**
    -   Ao iniciar, o sistema seleciona aleatoriamente o número de países/capitais solicitado a partir de uma lista interna.
    -   Para cada país, ele armazena a capital correta e sorteia outras 3 capitais de países diferentes para servirem como alternativas incorretas.
    -   Toda a estrutura do quiz (perguntas, respostas corretas, alternativas) é salva na sessão do usuário.

3.  **Tela do Jogo:**
    -   A cada rodada, o nome de um país é apresentado.
    -   As 4 alternativas de capital (a correta e as 3 incorretas) são exibidas em ordem aleatória.

4.  **Resposta do Usuário:**
    -   Quando o usuário clica em uma resposta, o sistema verifica se a capital escolhida é a correta para o país da rodada.
    -   O resultado (se acertou ou errou) é exibido em uma tela de feedback, que também mostra qual era a resposta certa.
    -   A pontuação é atualizada na sessão.

5.  **Fim de Jogo:**
    -   O jogo continua até que todas as perguntas definidas no início sejam respondidas.
    -   Ao final, uma tela de resultado exibe a pontuação percentual do usuário com base no número de acertos.

## Como Executar

1.  Clone o repositório.
2.  Execute `composer install`.
3.  Copie `.env.example` para `.env` e configure suas variáveis de ambiente.
4.  Execute `php artisan key:generate`.
5.  Execute `php artisan serve` para iniciar o servidor de desenvolvimento.
