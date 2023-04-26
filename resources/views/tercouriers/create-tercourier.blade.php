@extends('layouts.main')
@section('title', 'Create Courier')
@section('content')
<style>
    .list-group {
        width: 500px !important;

        padding: 10px !important;
        list-style-type: none;
    }

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

    * html .ui-autocomplete {
        height: 100px;
    }

    li:hover {
        color: #1f4eaf;
    }

    .list-group-item {
        position: relative;
        display: block;
        padding: 10px;
        background-color: #f7f2f2;
        border: 1px solid rgba(0, 0, 0, .125);
        color: #000;
    }

    .select2 {
        margin-bottom: 0 !important;
    }

    .form-group label,
    label {
        font-size: 12px;
        margin-bottom: 0;
    }

    .editTer .form-row {
        border-radius: 12px;
        padding: 1rem 8px 2px;
        position: relative;
    }

    .editTer .form-row h6 {
        font-size: 0.875rem;
        position: absolute;
        top: -0.5rem;
        left: 1rem;
        background: #dee2f4;
        padding: 1px 8px;
        border-radius: 7px;
        box-shadow: 0 2px 2px #83838350;
    }
</style>

<div class="container">
    <div class="container">
        <div class="page-header">
            <nav class="breadcrumb-one d-flex justify-content-between align-items-center flex-grow-1" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Add New TERCourier</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="#">Create New</a></li>
                </ol>
            </nav>
            <div class="d-flex align-items-center" style="gap: 3px; font-size: 1rem; font-weight: 700;">Time taken:
                <div style="width: 80px;" id="time"></div>
            </div>
        </div>
        <div class="row editTer">
            <div id="flFormsGrid" class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area">
                        <form id="new_tercourier_create" method='post' class="specify-numbers-price">
                            @csrf

                            <div class="form-row mb-4">
                                <h6><b>Sender Details</b></h6>
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">From *</label>
                                    <select class="form-control form-control-sm basic" name="sender_id" id="select_employee" required>
                                        <option selected disabled>search..</option>
                                        @foreach($senders as $sender)
                                        <option value="{{$sender->employee_id}}">{{$sender->name}}
                                            : {{$sender->ax_id}} : {{$sender->iag_code}} : {{$sender->employee_id}}
                                            : {{$sender->status}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" id="date_of_joining" />
                                <!--------------- Date of Receipt ---------->
                                <div class="form-group col-md-6">
                                    <label for="inputPassword4">Date of Receipt *</label>
                                    <input type="date" class="form-control form-control-sm" name="date_of_receipt" id="date_of_recp" required>
                                </div>
                                <!--------------- end ------------------>

                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Location</label>
                                    <input type="text" class="form-control form-control-sm" id="location" name="location" readonly="readonly">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Telephone No.</label>
                                    <input type="text" class="form-control form-control-sm mbCheckNm" id="telephone_no" type="tel" name="telephone_no" autocomplete="off" maxlength="10" readonly="readonly">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Status</label>
                                    <input type="text" class="form-control form-control-sm" id="emp_status" name="emp_status" autocomplete="off" readonly="readonly">
                                </div>
                                <input type="hidden" class="form-control" id="last_working_date" name="last_working_date">
                            </div>

                            <!------------Document details --------->
                            <div class="form-row mb-4">
                                <h6><b>Document Details</b></h6>
                                <div class="form-group col-md-3 n-chk align-self-center">
                                    <label class="new-control new-radio radio-classic-primary">
                                        <input checked="checked" onchange="onChangePeriodType()" id="for_month" type="radio" class="new-control-input" name="period_type">
                                        <span class="new-control-indicator"></span>For Month
                                    </label>
                                    <label class="new-control new-radio radio-classic-primary">
                                        <input onchange="onChangePeriodType()" id="for_period" type="radio" class="new-control-input" name="period_type">
                                        <span class="new-control-indicator"></span>For Period
                                    </label>
                                </div>
                                <div class="form-group col-md-3 n-chk align-self-center">
                                    <label class="new-control new-radio radio-classic-primary">
                                        <input checked="checked" id="current_year" type="radio" class="new-control-input" name="selected_year">
                                        <span class="new-control-indicator"></span>Current Year
                                    </label>
                                    <label class="new-control new-radio radio-classic-primary">
                                        <input id="last_year" type="radio" class="new-control-input" name="selected_year">
                                        <span class="new-control-indicator"></span>Last Year
                                    </label>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="month">Select Month</label>
                                    <select id="month" class=" form-control form-control-sm" onchange="onSelectMonth()">
                                        <option value="00">--Select Month--</option>
                                        <option value="01">January</option>
                                        <option value="02">February</option>
                                        <option value="03">March</option>
                                        <option value="04">April</option>
                                        <option value="05">May</option>
                                        <option value="06">June</option>
                                        <option value="07">July</option>
                                        <option value="08">August</option>
                                        <option value="09">September</option>
                                        <option value="10">October</option>
                                        <option value="11">November</option>
                                        <option value="12">December</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputPassword4">TER Period From *</label>
                                    <input disabled="true" type="date" class="form-control form-control-sm" id="terfrom_date" name="terfrom_date" class="terfrom_date" required>
                                    <input type="hidden" class="form-control form-control-sm" id="terfrom_date1" name="terfrom_date1" class="terfrom_date1" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputPassword4">TER Period To *</label>
                                    <input disabled="true" type="date" class="form-control form-control-sm" id="terto_date" name="terto_date" class="terto_date" required>
                                    <input type="hidden" class="form-control form-control-sm" id="terto_date1" name="terto_date1" class="terto_date1" required>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inputState">TER Amount *</label>
                                    <input class="form-control form-control-sm" type="number" id="amount" type="number" name="amount" required>
                                    <span id="amountInwords" style="font-size: 12px;">Required</span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="inputState">Location *</label>
                                    <input type="text" class="form-control form-control-sm location1" id="locations" name="location" required>
                                </div>


                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Other Details</label>
                                    <input type="text" class="form-control form-control-sm" id="details" name="details">
                                </div>

                                <div class="form-group col-md-8">
                                    <label for="remarks">Remarks</label>
                                    <input type="text" class="form-control form-control-sm" id="remarks" name="remarks">
                                </div>
                            </div>

                            <div class="form-row mb-4">
                                <h6><b>Courier Details</b></h6>
                                <div class="form-group col-md-4">
                                    <label for="inputState">Courier Name *</label>
                                    <select id="slct" name="courier_id" class="form-control form-control-sm" onchange="yesnoCheck(this);" required>
                                        <option></option>
                                        @foreach($couriers as $courier)
                                        <option value="{{$courier->id}}">{{$courier->courier_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Docket No.*</label>
                                    <input type="text" class="form-control form-control-sm" id="docket_no" name="docket_no" autocomplete="off" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="inputPassword4">Docket Date</label>
                                    <input type="date" class="form-control form-control-sm" id="docket_date" name="docket_date">
                                    <p class="docketdate_error text-danger" style="display: none; color: #ff0000; font-weight: 500;">
                                        Docket date invalid.
                                    </p>
                                </div>
                            </div>
                            <input id="timeTaken" name="timeTaken" hidden>
                            <div class="d-flex justify-content-end align-items-center">
                                {{-- <div class="d-flex align-items-center" style="gap: 3px;">Time taken:--}}
                                {{-- <div style="width: 80px;" id="time"></div>--}}
                                {{-- </div>--}}

                                <button type="submit" class="btn btn-primary" id="save_ter_btn" style="border-radius: 8px; width: 130px;">
                                    <span class="indicator-label">Save</span>
                                    <span class="indicator-progress" style="display: none;">
                                        Saving..
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('assets/js/libs/jquery-3.1.1.min.js')}}"></script>
<script>
    $('#date_of_recp').val(new Date().toJSON().slice(0, 10));
    $(document).ready(function() {
        $('#delivery_date').val(new Date().toJSON().slice(0, 10));
        //////////
        // $('#select_employee').on('keyup',function () {

        //         var query = $(this).val();
        //         //alert(query);
        //         $.ajax({
        //             url:'{{ url('autocomplete-search') }}',
        //             type:'GET',
        //             data:{'search':query},
        //             beforeSend:function () {
        //                 $('#product_list').empty();

        //             },
        //             success:function (data) {
        //                 // console.log(data.fetch);
        //                 $('#location').val('');
        //                 $('.location1').val('');
        //                 $('#telephone_no').val('');
        //                 $('#emp_status').val('');
        //                 $('#senderID').val('');
        //                 $('#product_list').html(data);

        //             }
        //         });
        //     });


        //     $(document).on('click', 'li', function(){
        //         var value = $(this).text();
        //         //console.log(value);
        //         var location = value.split(':');         //break value in js split
        //         for(var i = 0; i < location.length; i++){
        //             //console.log(location);
        //             var slct = location[0]+':'+location[2]+':'+location[3]+':'+location[5] ;

        //         $('#select_employee').val(slct);
        //         $('#location').val(location[1]);
        //         $('.location1').val(location[1]);
        //         $('#telephone_no').val(location[4]);
        //         $('#emp_status').val(location[5]);
        //         $('#senderID').val(location[6]);
        //         $('#product_list').html("");
        //         }
        //     });
        /*   $('#search').on('keyup',function () {
                    var query = $(this).val();
                    $.ajax({
                        url:'{{ url('autocomplete-search') }}',
                type:'GET',
                data:{'search':query},
                success:function (data) {
                    $('#product_list').html(data);
                }
            });
        }); */

        //// get employee data on change
        $('#select_employee').on('change', function() {
            var emp_id = $(this).val();
            // alert(emp_id);

            $.ajax({
                type: 'GET',
                url: "/get_employees",
                data: {
                    emp_id: emp_id
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: true,

                success: function(res) {
                    if (res.data) {
                        //alert(res.data);
                        console.log(res.data);
                        if (res.data.location == null) {
                            var location = '';
                        } else {
                            var location = res.data.location;
                        }
                        if (res.data.telephone_no == null) {
                            var telephone_no = '';
                        } else {
                            var telephone_no = res.data.telephone_no;
                        }
                        if (res.data.date_of_joining == null) {
                            var date_of_joining = '';
                        } else {
                            var date_of_joining = res.data.date_of_joining;
                        }
                        if (res.data.status == null) {
                            var status = '';
                        } else {
                            var status = res.data.status;
                        }
                        $("#location").val(location);
                        $("#telephone_no").val(telephone_no);
                        $("#emp_status").val(status);
                        $("#last_working_date").val(res.data.last_working_date);
                        $(".location1").val(location);
                        $("#date_of_joining").val(date_of_joining);

                    }
                }
            });
        });


    });
</script>

<script>
    let selectedYear = new Date().getFullYear();
    const currentYear = document.getElementById('current_year')
    const lastYear = document.getElementById('last_year')
    const forMonth = document.getElementById('for_month')
    const forPeiod = document.getElementById('for_period')

    function onChangePeriodType() {

        if (forMonth.checked) {
            document.getElementById('terfrom_date').disabled = true;
            document.getElementById('terto_date').disabled = true;
            document.getElementById('month').disabled = false;
            $("input[name='terfrom_date']").val('');
            $("input[name='terto_date']").val('');
            document.getElementById('month').setAttribute("required", "true");
            currentYear.disabled = false;
            lastYear.disabled = false;
        }
        if (forPeiod.checked) {
            document.getElementById('terfrom_date').disabled = false;
            document.getElementById('terto_date').disabled = false;
            document.getElementById('month').disabled = true;
            document.getElementById('month').setAttribute("required", "false");
            document.getElementById('month').value = '00';

            currentYear.disabled = true;
            lastYear.disabled = true;
        }
    }

    function onSelectMonth() {
        const selectedMonth = document.getElementById('month').value
        const currentYear = lastYear.checked ? (selectedYear - 1) : selectedYear;
        // alert(currentYear)
        if (selectedMonth == 1 || selectedMonth == 3 || selectedMonth == 5 || selectedMonth == 7 || selectedMonth == 8 || selectedMonth == 10 || selectedMonth == 12) {
            $("input[name='terfrom_date']").val(`${currentYear}-${selectedMonth}-01`);
            $("input[name='terto_date']").val(`${currentYear}-${selectedMonth}-31`);
            $("input[name='terfrom_date1']").val(`${currentYear}-${selectedMonth}-01`);
            $("input[name='terto_date1']").val(`${currentYear}-${selectedMonth}-31`);
        } else if (selectedMonth == 2) {
            $("input[name='terfrom_date']").val(`${currentYear}-${selectedMonth}-01`);
            $("input[name='terto_date']").val(`${currentYear}-${selectedMonth}-28`);
            $("input[name='terfrom_date1']").val(`${currentYear}-${selectedMonth}-01`);
            $("input[name='terto_date1']").val(`${currentYear}-${selectedMonth}-28`);
        } else {
            $("input[name='terfrom_date']").val(`${currentYear}-${selectedMonth}-01`);
            $("input[name='terto_date']").val(`${currentYear}-${selectedMonth}-30`);
            $("input[name='terfrom_date1']").val(`${currentYear}-${selectedMonth}-01`);
            $("input[name='terto_date1']").val(`${currentYear}-${selectedMonth}-30`);
        }
        // const t = document.getElementById('terfrom_date').value;
        // const r = document.getElementById('terto_date').value;
        // alert(`${t}, ${r}`)
    }

    function testSubmit() {
        var timeConsumed = document.getElementById('time').innerText;
    }

    var a = ['', 'one ', 'two ', 'three ', 'four ', 'five ', 'six ', 'seven ', 'eight ', 'nine ', 'ten ', 'eleven ', 'twelve ', 'thirteen ', 'fourteen ', 'fifteen ', 'sixteen ', 'seventeen ', 'eighteen ', 'nineteen '];
    var b = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];

    function inWords(num) {
        if ((num = num.toString()).length > 9) return 'overflow';
        n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
        if (!n) return;
        var str = '';
        str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
        str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
        str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
        str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
        str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
        return str;
    }

    document.getElementById('amount').onkeyup = function() {
        document.getElementById('amountInwords').innerHTML = inWords(document.getElementById('amount').value);
        document.getElementById('amountInwords').style.textTransform = "capitalize";
    };
</script>

<script>
    window.raf = (function() {
        return window.requestAnimationFrame ||
            window.webkitRequestAnimationFrame ||
            window.mozRequestAnimationFrame ||
            function(callback) {
                window.setTimeout(callback, 1000 / 60);
            };
    })();

    function Timer() {
        this.start();
        return this;
    };

    Timer.prototype = {
        start: function() {
            this.startTime = Date.now();
            return this;
        },
        getElapsedTime: function() {
            var hours = 0;
            var minutes = 0;
            var seconds = parseInt((Date.now() - this.startTime) / 1000);

            if (seconds > 60) {
                minutes = Math.floor(seconds / 60);
                seconds = seconds - minutes * 60;
            }

            if (minutes > 60) {
                hours = Math.floor(seconds / 3600);
                minutes = seconds - hours * 60;
                seconds = seconds - minutes * 3600;
            }

            return {
                hours: pad(hours, 2),
                minutes: pad(minutes, 2),
                seconds: pad(seconds, 2)
            };
        }
    };

    function pad(number, length) {
        var str = '' + number;
        while (str.length < length) {
            str = '0' + str;
        }
        return str;
    }

    var timer = new Timer();
    var output = document.getElementById('time');

    (function update() {
        var time = timer.getElapsedTime();
        output.textContent = time.hours + ':' + time.minutes + ':' + time.seconds;
        raf(update);
        document.getElementById('timeTaken').value = output.innerText;
    })();
</script>

@endsection