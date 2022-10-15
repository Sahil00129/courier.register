@extends('layouts.main')
@section('title', 'Reports Page')
@section('content')
<style>
@media only screen and (max-width: 767px) {
	.head {
    margin-left: 10rem;
	}
}
</style>

<!--  BEGIN CONTENT AREA  -->
<div class="container" id="reports">
    <div class="container">
        <div class="page-header">
            <nav class="breadcrumb-one" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">Reports</a></li>
                </ol>
            </nav>
            <!-- Lage modal -->
            <!-- <button type="button" class="btn btn-primary mb-2 mr-2" data-toggle="modal" data-target=".bd-example-modal-lg">Sample</button> -->
        </div>
        
        <div class="row layout-top-spacing">
            <div id="modalVerticallyCentered" class="col-lg-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-header">
                        <div class="row">
                            <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <p class="mb-1" style="text-align: center; font-size: 20px;
                                font-weight: 800;">Get Reports</p>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content widget-content-area">
                        <p class="mb-3" style="text-align: center;">Click on the below button to download the report</p>
                        <div class="text-center">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-primary mb-2 mr-2" data-toggle="modal" data-target="#exampleModalCenter">
                              Get Reports Type
                            </button>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalCenterTitle">Reports Section</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                        </button>
                                    </div>
         
                                        <div class="modal-body">
                                            <div class="form-row mb-4">
                                                <label for="inputState">Report Type</label>
                                                <select id="itype" class="form-control" v-model="report_type">
                                                    <option disabled>Choose...</option>
                                                    <option value="ter_timeline">TER Timeline</option>
                                                    <option value="ter_cancel">Cancel TER Remarks</option>
                                                    <option value="ter_updates">Updated TER Remarks</option>
                                                    <option value="ter_user_wise">User wise Processed TER report</option>
                                                    <option value="emp_ledger">Employee Ledger</option>
                                                </select>  
                                            </div>                                      
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                                            <button type="submit" class="btn btn-primary" @click="download_report()">
                                             Download
                                            </button> 
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  END CONTENT AREA  -->

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Sample</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
            <a class="btn btn-primary" href="{{url('/sample-spine-hr-dump')}}" role="button" style="margin-left: 103px;">Spine HR Dump</a> ||
                <a class="btn btn-primary" href="{{url('/sample-sender')}}" role="button" style="margin-left: 103px;">Sender Import</a> ||
                <a class="btn btn-primary" href="{{url('/sample-courier')}}" role="button">Courier Companies</a> ||
                <a class="btn btn-primary" href="{{url('/sample-category')}}" role="button">Catagories</a> ||
                <a class="btn btn-primary" href="{{url('/sample-for')}}" role="button">Receiving Company</a>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    new Vue({
        el: '#reports',
        // components: {
        //   ValidationProvider
        // },
        data: {
            report_type:"",
            url:"",
        },
        created: function() {
    

        },
        methods: {
            download_report() {
             this.url='/download_report/'+this.report_type;
             window.location.href = this.url;
            },

        }


    })
</script>
@endsection