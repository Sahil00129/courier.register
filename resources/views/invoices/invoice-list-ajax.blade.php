<div class="custom-table">
    <table class="table mb-3" style="width:100%">
        <thead>
            <tr>
               <th>S.No.</th>
                <th>UN ID</th>
                <th>STATUS</th>
                <th>PO ID</th>
                <th>INVOICE DATE</th>
                <th>BASIC AMOUNT</th>
                <th>TOTAL AMOUNT</th>
                <th>Action</th>
                <!-- <th>BASIC AMOUNT</th> -->
                <!-- <th>BASIC AMOUNT</th> -->
                <!-- <th>Action </th> -->
            </tr>
        </thead>
        <tbody id="accordion" class="accordion">
            @if(count($invoice)>0)
            @foreach($invoice as $key => $value)
            <?php $i=0; ?>
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$value->id ?? '-'}} </td>
                <?php
                                if ($value->status == 1) {
                                    $status = 'Received';
                                    $class = 'btn-success';
                                } elseif ($value->status == 2) {
                                    $status = 'Handover';
                                    $class = 'btn-warning';
                                } elseif ($value->status == 3) {
                                    $status = 'Verified';
                                    $class = 'btn-success';
                                }
                                ?>


                                <td>
                                    @if($value->status == 0 || $value->status == 1 || $value->status == 2)
                                    <button class="btn {{ $class }} btn-sm btn-rounded mb-2 statusButton" data-toggle="modal" data-target="#exampleModal" v-on:click="open_ter_modal(<?php echo $value->id ?>)">
                                        {{ $status }}
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg>
                                    </button>
                                    @else
                                    <button class="btn {{ $class }} btn-sm btn-rounded mb-2 statusButton" style="cursor: default">
                                        {{ $status }}
                                    </button>
                                    @endif
                                </td>
                <!-- <td>{{$value->status ?? '-'}} </td> -->
                <td>{{$value->po_id ?? '-'}} </td>
                <td>{{$value->invoice_date ?? '-'}} </td>
                <td>{{$value->basic_amount ?? '-'}} </td>
                <td>{{$value->total_amount ?? '-'}} </td>
                <!-- <td> </td> -->
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="6" class="text-center">No Record Found </td>
            </tr>
            @endif
        </tbody>
    </table>
    <!-- <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 col-lg-8 col-xl-9">
            </div>
            <div class="col-md-12 col-lg-4 col-xl-3">
                <div class="form-group mt-3 brown-select">
                    <div class="row">
                        <div class="col-md-6 pr-0">
                            <label class=" mb-0">items per page</label>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control perpage" data-action="<?php //echo url()->current(); ?>">
                                <option value="10" {{$peritem == '10' ? 'selected' : ''}}>10</option>
                                <option value="50" {{$peritem == '50' ? 'selected' : ''}}>50</option>
                                <option value="100" {{$peritem == '100'? 'selected' : ''}}>100</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <div class="ml-auto mr-auto">
        <nav class="navigation2 text-center" aria-label="Page navigation">
            {{$invoice->appends(request()->query())->links()}}
        </nav>
    </div>
</div>