// resources/js/app.js

import './bootstrap';
// import 'bootstrap'
// import 'bootstrap/dist/css/bootstrap.min.css'

import $ from 'jquery';
window.$ = window.jQuery = $;

import 'jquery-ui/ui/widgets/datepicker.js';



//jisho_histories
$(function() {
    $("#jisho_historiesAjax").on("submit", function(e) { //id of form 
      e.preventDefault();

      $.ajax({
        type: 'GET',
        url: `api/jisho_histories`,
        dataType: 'json',

        success: function(response) {

            //let's empty the div before filling with the json
            $("#resultJishoHistories").html("");
            document.getElementById("resultJishoHistories").innerHTML = JSON.stringify(response, null, 4);

        }
        
      })
    });

  });


//wordreference_histories
$(function() {
  $("#wordreference_historiesAjax").on("submit", function(e) { //id of form 
    e.preventDefault();

    $.ajax({
      type: 'GET',
      url: `api/wordreference_histories`,
      dataType: 'json',

      success: function(response) {

          //let's empty the div before filling with the json
          $("#resultWordreferenceHistories").html("");
          document.getElementById("resultWordreferenceHistories").innerHTML = JSON.stringify(response, null, 4);

      }
      
    })
  });

});


//jisho_search
$(function() {
    $("#jisho_search_homeAjax").on("submit", function(e) { //id of form 
      e.preventDefault();
  
      let category = $("#category").val();
      let search = $("#search").val();

      $.ajax({
        type: 'GET',
        url: `api/jisho/${category}/${search}`,
        dataType: 'json',
        data: {category:category, search:search},

        success: function(response) {

            //let's empty the div before filling with the json
            $("#resultJisho").html("");
            let resultJson = JSON.stringify(response, null, 4);
            $("#resultJisho").html(`${resultJson}`);
            // document.getElementById("resultJisho").innerHTML = JSON.stringify(response.data, null, 4);

        }
        
      })
    });

  });


  //wordreference_search
$(function() {
  $("#wordreference_search_homeAjax").on("submit", function(e) { //id of form 
    e.preventDefault();

    let category = $("#categoryWR").val();
    let search = $("#searchWR").val();

    $.ajax({
      type: 'GET',
      url: `api/wordreference/${category}/${search}`,
      dataType: 'json',
      data: {category:category, search:search},

      success: function(response) {

          //let's empty the div before filling with the json
          $("#resultWordreference").html("");
          let resultJson = JSON.stringify(response, null, 4);
          $("#resultWordreference").html(`${resultJson}`);
          // document.getElementById("resultJisho").innerHTML = JSON.stringify(response.data, null, 4);

      }
      
    })
  });

});

