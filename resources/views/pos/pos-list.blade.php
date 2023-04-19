@extends('layouts.main')
@section('title', 'Create PO')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.11/dist/vue.min.js" integrity="sha256-ngFW3UnAN0Tnm76mDuu7uUtYEcG3G5H1+zioJw3t+68=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/vee-validate@2.2.15/dist/vee-validate.min.js" integrity="sha256-m+taJnCBUpRECKCx5pbA0mw4ckdM2SvoNxgPMeUJU6E=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.js" integrity="sha256-bd8XIKzrtyJ1O5Sh3Xp3GiuMIzWC42ZekvrMMD4GxRg=" crossorigin="anonymous"></script>
<style>
    .moreInvoicesView ul {
        padding: 0;
        margin-bottom: 0;
        display: inline-flex;
        width: 200px;
        overflow: hidden;
        white-space: nowrap;
        gap: 2rem;
        text-overflow: ellipsis;
    }
</style>

<div class="layout-px-spacing" id="divbox">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="page-header">
                <nav class="breadcrumb-one" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">PRS</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><a href="javascript:void(0);">PRS
                                List</a></li>
                    </ol>
                </nav>
            </div>
            <div class="widget-content widget-content-area br-6">
                <div class="mb-4 mt-4">

                    <div class="container-fluid">
                        <div class="row winery_row_n spaceing_2n mb-3">
                            <div class="col d-flex pr-0">
                                <div class="search-inp w-100">
                                    <form class="navbar-form" role="search">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search" id="search" data-action="<?php echo url()->current(); ?>">
                                            
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg lead_bladebtop1_n pl-0">
                                <div class="winery_btn_n btn-section px-0 text-right">
                                <a class="btn-primary btn-cstm btn ml-2" style="font-size: 15px; padding: 9px; width: 130px" href="{{'/download_po_list'}}"><span><i class="fa fa-plus"></i> Export
                                            PO List</span></a>
                                    <a class="btn-primary btn-cstm btn ml-2" style="font-size: 15px; padding: 9px; width: 130px" href="{{'pos/create'}}"><span><i class="fa fa-plus"></i> Add
                                            New</span></a>
                                    <!-- <a href="javascript:void(0)" class="btn btn-primary btn-cstm reset_filter ml-2" style="font-size: 15px; padding: 9px;" data-action="<?php //echo url()->current(); ?>"><span><i class="fa fa-refresh"></i> Reset Filters</span></a>

                                    <a href="<?php //echo URL::to('/export/excel'); ?>" class="btn btn-primary btn-cstm downloadEx ml-2" style="font-size: 15px; padding: 9px;" data-action="<?php //echo URL::to('/export/excel'); ?>" download><span>
                                    <i class="fa fa-download"></i> Export</span></a> -->

                                </div>
                            </div>
                        </div>
                    </div>

                    @csrf
                    <div class="main-table table-responsive">
                        @include('pos.pos-list-ajax')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection