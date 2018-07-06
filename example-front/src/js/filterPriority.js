(function(table){
  'use strict'

  var $filterPriority = document.querySelector('[data-js="filter-priority');
  var page = 1;
  $filterPriority.addEventListener('click', filterPriority);

 
  function filterPriority( page ) { 
    axios({
      method: 'put',
      url:'http://localhost:8000/tickets/filter/priority/pa/' + page,
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
    filterPriority(this.innerHTML);
  }

})(window.table)

