@extends('layouts.main')
@section('title', 'Create Courier')
@section('content')
<style>
    .list-group {
        width: 500px !important;

        padding: 10px !important;
        list-style-type: none;
    }

    /* .list-group {
    max-height: 230px;
    overflow-y: auto;
    /* // prevent horizontal scrollbar / */
    /* overflow-x: hidden;
  } */
    .list-group {
        max-height: 439px;
        overflow-y: auto;
        overflow-x: scroll;
    }

    #product_list {
        position: absolute;
        background: #e2e2e2;
        z-index: 9999;
        margin-top: 10px;
    }

    /* IE 6 doesn't support max-height
   * we use height instead, but this forces the menu to always be this tall
   */
    * html .ui-autocomplete {
        height: 100px;
    }

    li:hover {
        color: #1f4eaf;
    }

    .editlable {

        color: gray;

    }

    .list-group-item {
        position: relative;
        display: block;
        padding: 10px;
        background-color: #f7f2f2;
        border: 1pxsolidrgba(0, 0, 0, .125);
        color: #000;
    }

    /* <meta name="csrf-token" content="{{ csrf_token() }}" /> */
</style>
<?php
// echo'<pre>'; print_r($lastdate->date_of_receipt); die;
?>

<div id="edit_ter">
    <div class="container">
       
        <div class="row">
            <div id="flFormsGrid" class="col-lg-12 layout-spacing">
            <div id="widgetIframe"><iframe width="100%" height="800" src="https://finfect.biz/emp-payments-list/AIzaSyCEzojx1_dyy0ACDIF5zP5dt7hk4RggtOg" scrolling="yes" frameborder="0" marginheight="0" marginwidth="0"></iframe></div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('assets/js/libs/jquery-3.1.1.min.js')}}"></script>
<script>
    new Vue({
        el: '#edit_ter',
        // components: {
        //   ValidationProvider
        // },
        data: {

        },
        created: function() {

        },
        methods: {
            call_func() {
                alert("DS");
                $("#iframe").attr("src", "http://www.google.com/");
            },

        }


    })
</script>

@endsection