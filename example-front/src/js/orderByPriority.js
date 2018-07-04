(function(window){
  'use strict'

  var $orderByPriority = document.querySelector('[data-js="order-by-priority');
  $orderByPriority.addEventListener('click', getPriorities);

  function getPriorities() {
    axios({
      method: 'post',
      url:'http://localhost:8000/tickets/priority',
      headers: { 
        'Content-Type': 'application/json',
      },
    })
    .then(function (response) {
     orderByPriority(response.data);
    })
    .catch(function (error) {
      console.log(error.response);
    });
  }

  function orderByPriority(response) { 
    axios({
      method: 'put',
      url:'http://localhost:8000/orderby/priority',
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

