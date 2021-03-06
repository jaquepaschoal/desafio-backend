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

  var $filterDate = document.querySelector('[data-js="filter-date');
  var page = 1;
  $filterDate.addEventListener('click', filterDate);

 
  function filterDate( page ) { 
    axios({
      method: 'put',
      url:'http://localhost:8000/tickets/filter/date/17-12-03/17-12-20/' + page,
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
    filterDate(this.innerHTML);
  }

})(window.table)

