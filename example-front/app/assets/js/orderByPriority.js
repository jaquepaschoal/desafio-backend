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

  var $orderByPriority = document.querySelector('[data-js="order-by-priority');
  $orderByPriority.addEventListener('click', orderByPriority);

  function orderByPriority( page ) { 
    axios({
      method: 'put',
      url:'http://localhost:8000/tickets/orderby/priority/' + page,
      headers: { 
        'Content-Type': 'application/json',
      },
    })
    .then(function (response) {
      var data = response.data;
      table().pagination( data['Pages'] );

      var buttons = document.getElementsByName('number');
      Array.prototype.map.call(buttons, function(item){
        item.addEventListener('click', nextPage);
      })  

      delete data['Items']; delete data['Pages']; delete data['Number'];
      table().create(data);
    })
    .catch(function (error) {
      console.log(error.response);
    });
  }

  function nextPage() {
    orderByPriority(this.innerHTML);
  }

})(window.table)

