(function(table){
  'use strict'

  var $orderByDate = document.querySelector('[data-js="order-by-create');
  var page = 1;
  $orderByDate.addEventListener('click', orderByDate);

  function orderByDate( page ) { 
    axios({
      method: 'put',
      url:'http://localhost:8000/tickets/orderby/date/DateCreate/' + page,
      headers: { 
        'Content-Type': 'application/json',
      },
    })
    .then(function (response) {
      var data = response.data;
      console.log(data['Pages']);
      table().pagination(data['Pages'], data['Number']);

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
    orderByDate(this.innerHTML);
  }

})(window.table)

