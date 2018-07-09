# Desafio back-end - NeoAssist

Desafio para a empresa NeoAssist .

## Começando

* Para ter o projeto funcionando em sua máquina, clone este repositório,  acesse a pasta [back-end](https://github.com/jaquepaschoal/desafio-backend/tree/master/back-end) e rode o comando:

```
$ composer install
```

<<<<<<< HEAD
* Para que funcione corretamente, o arquivo tickets.json deve estar em  [Storage](https://github.com/jaquepaschoal/desafio-backend/tree/master/back-end/storage).
=======
* Para que funcione corretamente, o arquivo tickets.json deve estar em  [Storage/app](https://github.com/jaquepaschoal/desafio-backend/tree/master/back-end/storage/app).
>>>>>>> 8725c196781cd57eb0264dc325a1da57a5973e4d
* Para rodar o projeto, o seguinte comando foi utilizado:
```
$ php -S localhost:8000 -t public
```

### Pré - requisitos

* PHP >= 7.1.3
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension
* Ctype PHP Extension
* JSON PHP Extension

## Rotas
* /tickets/priority/{number} : Usada para determinar as prioridades de cada ticket.

**{number}** -> Número da página que deseja ser exibida.

* /tickets/orderby/date/{type}/{number}: Orderna os tickets pela data de Criação ou pela data de Atualização.

**{type}** -> Deve ser 'DateCreate' para data de criação ou 'DateUpdate' para data de atualização.

**{number}** -> Número da página que deseja ser exibida.

* /tickets/orderby/priority/{number}: Orderna os tickets de acordo com sua prioridade.

**{number}** -> Número da página que deseja ser exibida.

* /tickets/filter/date/{initial}/{final}/{number}: Filtra os tickets de acordo com o intervalo da data de criação.

**{initial}** -> Data inicial no formato (ANO-MES-DIA).

**{final}** -> Data final no formato (ANO-MES-DIA).

**{number}** -> Número da página que deseja ser exibida.

* /tickets/filter/priority/{type}/{number}: Filtra os tickets de acordo com a prioridade escolhida.

**{type}** -> 'pa' para prioridade alta, 'pb' para prioridade baixa.

**{number}** -> Número da página que deseja ser exibida.

## Example

Um exemplo com as requisições para cada rota pode ser acessado  [aqui](https://github.com/jaquepaschoal/desafio-backend/tree/master/example-front).
Para tê-lo funcionando, rode: 
```
$ npm i 
```
```
$ npm start
```


## Feito com

* [Lumen](https://lumen.laravel.com/docs/5.6) - Um microframework derivado do Laravel.

## Autor

* **Jaqueline Paschoal** - [*Web Developer*](https://github.com/jaquepaschoal)


