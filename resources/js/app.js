import './bootstrap';
import $ from 'jquery';
window.$ = window.jQuery = $;

import 'jquery-ui/ui/widgets/datepicker.js';


//test jisho_search

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

            console.log(response);
            //let's empty the div before filling with the json
            $("#resultJisho").html("");
            let resultJson = JSON.stringify(response.data, null, 4);
            $("#resultJisho").html(`<div>${resultJson}</div>`);

        }
        
      })
    });

  });





//----fin jisho_search


// $(document).ready(function() is depreciated ---> $(function()
$(function() {
    $('#submitJisho_histories').on('click', function(){
        GetJishoHistories();
    });
});

function GetJishoHistories() {
    console.log("Jquery OK"); 
    // $.ajax({

    //     url: "{{ route('jisho_histories') }}",
    //     success: function (result) {

    //         if (result) {
    //             console.log(result); 

    //     } 
    // });
}
