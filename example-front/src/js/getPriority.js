(function(){

  'use strict'

  var $priority = document.querySelector('[data-js="priority"]');
  $priority.addEventListener('click', getPriorities);

 function getPriorities() {
    axios({
      method: 'post',
      url:'http://localhost:8000/tickets/priority',
      headers: { 
        'Content-Type': 'application/json',
      },
    })
    .then(function (response) {
     showResponse(response.data);
    })
    .catch(function (error) {
      console.log(error.response);
    });
  }

  function showResponse(response) { 
    console.log(response);
  }

})()

