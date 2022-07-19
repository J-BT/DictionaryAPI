import './bootstrap';
import $ from 'jquery';
window.$ = window.jQuery = $;

import 'jquery-ui/ui/widgets/datepicker.js';


//jisho_search AJAX

$(function() {
    $("#jisho_search_homeAjax").on("submit", function(e) { //id of form 
      e.preventDefault();
  
      let category = $("#category").val();
      let search = $("#search").val();

      $.ajax({
        url: `api/jisho/${category}/${search}`,
        data: {category:category, search:search},

        success: function(response) {

            console.log(response);

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
