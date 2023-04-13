<div class="custom-table">
    <table class="table mb-3" style="width:100%">
        <thead>
            <tr>
                <th>PO Number</th>
                <th>Status</th>
                <th>Vendor Name</th>
                <th>Po Date</th>
                <th>PO Value</th>
                <!-- <th>Invoice Value</th> -->
                <th>Unit</th>
                <th>Activity</th>
                <!-- <th>Action </th> -->
            </tr>
        </thead>
        <tbody id="accordion" class="accordion">
            @if(count($posdata)>0)
            @foreach($posdata as $value)
            <?php //dd($value->PoTercouriers) ?>
            <tr>
                <td>{{$value->po_number ?? '-'}} </td>
                <?php
                            if ($value->status == "1") {
                                $status = "Open";
                            } elseif ($value->status == "2") {
                                $status = "Semi-closed";
                            } elseif ($value->status == "3") {
                                $status = "Closed";
                            }
                            ?>
                <td>{{$status ?? '-'}} </td>

                <td>{{$value->vendor_name ?? '-'}} </td>
                <td>{{Helper::ShowFormatDate($value->po_date) ?? '-'}} </td>
                <td>{{$value->po_value ?? '-'}} </td>
                <!-- @foreach($value->PoTercouriers as $po_data)
                <td> {{$po_data->total_amount}}</td>
                @endforeach -->
                <td>{{$value->unit}} </td>
                <td>{{$value->activity}} </td>
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
            {{$posdata->appends(request()->query())->links()}}
        </nav>
    </div>
</div>