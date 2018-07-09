(function(win, doc) {

  'use strict';

  function table() {
    return {
      create: function create(response) {
        this.clear();
        var result = document.querySelector("[data-js='result']");
        for (var key in response) {
          if (response.hasOwnProperty(key)) {
            var row = document.createElement('tr');
      
            var collId          = document.createElement('td');
            var collPriority    = document.createElement('td');
            var collPunctuation = document.createElement('td');
            var collDateCreate  = document.createElement('td');
            var collDateUpdate  = document.createElement('td');
      
            collId.textContent          = response[key].TicketID;
            collPriority.textContent    = response[key].Priority;
            collPunctuation.textContent = response[key].Punctuation;
            collDateCreate.textContent  = response[key].DateCreate;
            collDateUpdate.textContent  = response[key].DateUpdate;
      
            row.appendChild(collId);
            row.appendChild(collPriority);
            row.appendChild(collPunctuation);
            row.appendChild(collDateCreate);
            row.appendChild(collDateUpdate);
      
            result.appendChild(row);
          }
        }
          
      },
      clear: function clear() {
        var result = document.querySelector("[data-js='result']");
        result.innerHTML= " ";
      },
      pagination: function pagination( pages ) {
        var numbers = document.querySelector('[data-js="numbers"]');
        numbers.innerHTML = '';
        
        for ( var x = 1; x <= pages; x++ ) {
          var btn = document.createElement('button');
          btn.textContent = x;
          btn.name = 'number';
          numbers.appendChild(btn);
        }
      }
    }
  }

  win.table = table;

})(window, document);