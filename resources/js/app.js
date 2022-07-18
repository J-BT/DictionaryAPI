import './bootstrap';
import $ from 'jquery';
window.$ = window.jQuery = $;

import 'jquery-ui/ui/widgets/datepicker.js';


// $(document).ready(function() is depreciated ---> $(function()
$(function() {
    $('#submitJisho_histories').on('click', function(){
        GetJishoHistories();
    });
});
// document.addEventListener("DOMContentLoaded", function(){
//     $('#submitJisho_histories').on('click', function(){
//         GetJishoHistories();
//     });
// });


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
