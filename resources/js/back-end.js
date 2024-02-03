
window._ = require('lodash');
var ImageEditor = require('tui-image-editor');

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');


    require('jquery-slimscroll');
    require('fastclick');
    require('bootstrap');
    require('select2');
    window.niceSelect = require('jquery-nice-select');
    require('./adminLTE')
    window.toastr = require('toastr')
    window.swal = require('bootstrap-sweetalert')
} catch (e) {}


window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}


import Echo from 'laravel-echo'

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'ad7cdc097d309d7b1621',
    cluster: 'ap3',
    encrypted: true
});


window.Vue = require('vue');
Vue.component('scoring-range', require('./components/Ui/ScoringRange.vue').default);
Vue.component('component-comment', require('./components/Ui/ComponentBookComment/MainComponent.vue').default);
Vue.component('notification-component', require('./components/BackEnd/Notification/MainComponent.vue').default);
Vue.component('component-manager', require('./components/BackEnd/Component/MainComponent.vue').default);
Vue.component('grammar-component', require('./components/BackEnd/Grammar/MainComponent.vue').default);
Vue.component('quiz-option-composer-component', require('./components/BackEnd/Quiz/OptionComposerComponent.vue').default);
Vue.component('edit-quiz-option-composer-component', require('./components/BackEnd/Quiz/OptionComposerComponentEdit.vue').default);
Vue.component('comment-component', require('./components/Ui/Comment/MainComponent.vue').default);
Vue.component('audiobook-thumbnail-component', require('./components/BackEnd/AudioBookThumbnail/MainComponent.vue').default);
Vue.component('question-component', require('./components/BackEnd/Quiz/QuestionBox/MainComponent.vue').default);
Vue.component('question-component-edit', require('./components/BackEnd/Quiz/QuestionBoxEdit/MainComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


import VueChatScroll from 'vue-chat-scroll'
Vue.use(VueChatScroll)

const app = new Vue({
    el: '#app'
});



$(document).ready(function(){

    // $('select').niceSelect();
    $('.with-input').dblclick(function(){
          $(this).find('.date-data').hide();
          $(this).find('input').show()
    })

    $('#file-logo').on('change', function(){
      var file = $(this).get(0).files[0];
      if(file){
          var reader = new FileReader();
          reader.onload = function(){
              $("#picture-preview").attr("src", reader.result);
          }
          reader.readAsDataURL(file);
      }
  });

    $('.input-date-data').change(function(){
            var val = $(this).val();
            var bookId = $(this).data('book')
            var userId = $(this).data('user')
            var cell = $(this).data('cell')

            // updating sa server
            axios.post('/back-end/student/update-chart-data', {
                    book_id: bookId,
                    user_id: userId,
                    cell: cell,
                    data: val
            })
            .then( response => {
                    $(this).hide();
                    $(this).closest('td.with-input').find('.date-data').html(response.data).show();
            })
            .catch(error => {
                    console.log(error)
            })

    })

    $('#deleteAllBtn').click(function(){
      if(confirm('Are you sure to Delete?')){
        $('#deleteAllForm').submit();
      }
    });

    $('input[name=excelfile]').change(function(){
        $('#upload-excel-form').submit();
    });

    $('#delete-notification').click(function(){
      $('#notification-submit-type').val('delete');
      $('#notification-form').submit();
    });

    $('#diary-date-input').change(function(){
      $('#diary-date-form').submit();
    });

    $('#mark-notification').click(function(){
      $('#notification-submit-type').val('mark');
      $('#notification-form').submit();
    });

    $(document).on('click','#checkAll', function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $('.niceselect').niceSelect();
    $('.select2').select2();

    $('.select2-student').select2({
      ajax:{
          url: '/back-end/search/student',
          dataType: 'json',
          delay: 500,
          data: function (params) {
            return {
                searchTerm: params.term // search term
            };
          },
          processResults: function (response) {
            return {
                results: response
            };
          },
          // cache: true
      }
    });

    $('#delete-all-btn').click(function(){
      // if(confirm("Are you sure to delete?")){
      //   $('#delete-all-form').submit();
      // }
      swal({
            title: "Are you sure to delete?",
            type: "warning",
            confirmButtonText: "Yes, Delete it.",
            confirmButtonClass: "btn-danger",
            showCancelButton: true,
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        }, function () {
          $('#delete-all-form').submit();
            // axios.delete(url)
            //     .then(resposne => {
            //         swal.close()
            //         if(type == "remove"){
            //             $(remove).fadeOut()
            //         }else if(type == "redirect"){
            //             window.open(redirect, '_bank')
            //         }else{
            //             location.reload();
            //         }
            //     })
        });
    })

    $('.select2-book').select2({
      ajax:{
          url: '/back-end/search/book',
          dataType: 'json',

          data: function (params) {
            return {
                searchTerm: params.term // search term
            };
          },
          processResults: function (response) {
            return {
                results: response
            };
          },
          // cache: true
      }
    });

    $(document).on('click','.delete-item', function(){
        var uri = $(this).data('uri');
        var remove = $(this).data('remove');

        swal({
              title: "Are you sure to delete?",
              type: "warning",
              confirmButtonText: "Yes, Delete it.",
              confirmButtonClass: "btn-danger",
              showCancelButton: true,
              closeOnConfirm: false,
              showLoaderOnConfirm: true
          }, function () {
            axios.delete(uri)
                .then(response => {
                    if(remove){
                      $(remove).fadeOut()
                    }else{
                      location.reload()
                    }
                    swal.close()
                })
                .catch( error => {
                  console.log(error)
                })
        })
    })

    $('.delete-writing').click(function(){
        if( confirm('Are you sure to delete?')){
            var uri = $(this).data('uri')
            axios.delete(uri)
                .then( () => {
                    location.reload()
                })
                .catch( error => {
                    console.log(error)
                })
        }
    });

  $('#branch-select').change(function(){
    $('#select-branch-form').submit();
  })


  /* 2. Action to perform on click */
  $('.component-scoring li').on('click', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
    var stars = $(this).parent().children('li.star');


    for ( var i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('selected');
    }

    for ( var i = 0; i < onStar; i++) {
      $(stars[i]).addClass('selected');
    }

    // JUST RESPONSE (Not needed)
    var ratingValue = parseInt($('.component-scoring li.selected').last().data('value'), 10);
    var msg = "";
    if (ratingValue > 1) {
        msg = "Thanks! You rated this " + ratingValue + " stars.";
    }
    else {
        msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
    }
    var uri = $(this).closest('ul').data('uri');
    var book = $(this).closest('ul').data('book');
    var component = $(this).closest('ul').data('component');
    var student = $(this).closest('ul').data('student');
    var preview = $(this).closest('ul').data('preview')

    axios.post(uri, {
        student: student,
        book: book,
        component: component,
        rating: ratingValue
      })
      .then(reponse => {
        toastr.success(msg);
        $(preview).html(ratingValue)
      })
      .catch(error => {
        console.log(error)
      })
  });
  /* 2. Action to perform on click */
  $('.book-scoring li').on('click', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
    var stars = $(this).parent().children('li.star');

    for ( var i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('selected');
    }

    for ( var i = 0; i < onStar; i++) {
      $(stars[i]).addClass('selected');
    }

    // JUST RESPONSE (Not needed)
    var ratingValue = parseInt($('.book-scoring li.selected').last().data('value'), 10);
    var msg = "";
    if (ratingValue > 1) {
        msg = "Thanks! You rated this " + ratingValue + " stars.";
    }
    else {
        msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
    }
    var uri = $(this).closest('ul').data('uri');
    var book = $(this).closest('ul').data('book');
    var component = $(this).closest('ul').data('component');
    var student = $(this).closest('ul').data('student');
    var preview = $(this).closest('ul').data('preview')

    axios.post(uri, {
        student: student,
        book: book,
        component: component,
        rating: ratingValue
      })
      .then(reponse => {
        toastr.success(msg);
        $(preview).html(ratingValue)
      })
      .catch(error => {
        console.log(error)
      })
  });

});
