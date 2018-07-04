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

  var $orderByDate = document.querySelector('[data-js="order-by-update');
  $orderByDate.addEventListener('click', getPriorities);

  function getPriorities() {
    axios({
      method: 'post',
      url:'http://localhost:8000/tickets/priority',
      headers: { 
        'Content-Type': 'application/json',
      },
    })
    .then(function (response) {
     orderByDate(response.data);
    })
    .catch(function (error) {
      console.log(error.response);
    });
  }

  function orderByDate(response) { 
    axios({
      method: 'put',
      url:'http://localhost:8000/orderby/date/DateUpdate',
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
