/*!
 * DesafioBackEnd
 * Application for the challange
 * https://github.com/jaquepaschoal/desafio-backend
 * @author Jaqueline Paschoal
 * @version 1.1.1
 * Copyright 2018. MIT licensed.
 */
(function(table){
  'use strict'

  var $pagination = document.querySelector('[data-js="pagination');
  $pagination.addEventListener('click', getPriorities);

  function getPriorities() {
    axios({
      method: 'post',
      url:'http://localhost:8000/tickets/priority',
      headers: { 
        'Content-Type': 'application/json',
      },
    })
    .then(function (response) {
     pagination(response.data, 1);
    })
    .catch(function (error) {
      console.log(error.response);
    });
  }

  function pagination(response, page) { 
    axios({
      method: 'put',
      url:'http://localhost:8000/pagination/3/' + page,
      headers: { 
        'Content-Type': 'application/json',
      },
      data: response
    })
    .then(function (response) {
      var resp = response.data;
      showButtons(resp['Items'], resp['Pages'], resp['Number'])



      table().create(resp);
    })
    .catch(function (error) {
      console.log(error);
    });
  }

  function showButtons(items, pages, pageNumber) {
    var page       = document.querySelector('[data-js="page"]').innerHTML = pageNumber;
    var next       = document.querySelector('[data-js="next"]');
    var totalPages = document.querySelector('[data-js="totalPages"]').innerHTML = pages;
    var pagination = document.querySelector('[data-js="pagination-buttons"]').style.display = "flex";

    next.addEventListener('click',function(){
      axios({
        method: 'post',
        url:'http://localhost:8000/tickets/priority',
        headers: { 
          'Content-Type': 'application/json',
        },
      })
      .then(function (response) {
        pagination(response.data, page + 1);
      })
      .catch(function (error) {
        console.log(error.response);
      });
    });
  }

})(window.table)

