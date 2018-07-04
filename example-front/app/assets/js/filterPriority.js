/*!
 * DesafioBackEnd
 * Application for the challange
 * https://github.com/jaquepaschoal/desafio-backend
 * @author Jaqueline Paschoal
 * @version 1.1.1
 * Copyright 2018. MIT licensed.
 */
(function(window){
  'use strict'

  var $filterPriority = document.querySelector('[data-js="filter-priority');
  $filterPriority.addEventListener('click', getPriorities);

  function getPriorities() {
    axios({
      method: 'post',
      url:'http://localhost:8000/tickets/priority',
      headers: { 
        'Content-Type': 'application/json',
      },
    })
    .then(function (response) {
     filterPriority(response.data);
    })
    .catch(function (error) {
      console.log(error.response);
    });
  }

  function filterPriority(response) { 
    axios({
      method: 'put',
      url:'http://localhost:8000/filter/priority/pa',
      headers: { 
        'Content-Type': 'application/json',
      },
      data: response
    })
    .then(function (response) {
      console.log(response.data);
    })
    .catch(function (error) {
      console.log(error.response);
    });
  }

})(window)

