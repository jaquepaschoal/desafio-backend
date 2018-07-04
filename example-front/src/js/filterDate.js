(function(window){
  'use strict'

  var $filterDate = document.querySelector('[data-js="filter-date');
  $filterDate.addEventListener('click', getPriorities);

  function getPriorities() {
    axios({
      method: 'post',
      url:'http://localhost:8000/tickets/priority',
      headers: { 
        'Content-Type': 'application/json',
      },
    })
    .then(function (response) {
     filterDate(response.data);
    })
    .catch(function (error) {
      console.log(error.response);
    });
  }

  function filterDate(response) { 
    axios({
      method: 'put',
      url:'http://localhost:8000/filter/date/17-12-20/17-12-30',
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

