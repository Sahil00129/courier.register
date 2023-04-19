<div class="custom-table">
    <table class="table mb-3" style="width:100%">
        <thead>
            <tr>
                <th>PO Number</th>
                <th>Status</th>
                <th>Vendor Name</th>
                <th>Unit</th>
                <th>Po Date</th>
                <th>PO Value</th>
                <th>Invoice Value</th>
                <th>Remaining  Value</th>
                <th class="text-center">Action </th>
            </tr>
        </thead>
        <tbody id="accordion" class="accordion">
            @if(count($posdata)>0)
            @foreach($posdata as $value)
            <?php //dd($value->PoTercouriers) 
            ?>
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
                elseif ($value->status == "4") {
                    $status = "Cancelled";
                }
                ?>
                <td>{{$status ?? '-'}} </td>

                <td>{{$value->vendor_name ?? '-'}} </td>
                <td>{{$value->unit}} </td>
                <td>{{Helper::ShowFormatDate($value->po_date) ?? '-'}} </td>
                <td>{{$value->po_value ?? '-'}} </td>
                <?php $total = array(); ?>
                @foreach($value->PoTercouriers as $po_data)
              <?php  
              $total[] = (int)$po_data->total_amount;
            //   dd((int)$po_data->total_amount);?>
                
                @endforeach
              <?php  $total_sum = array_sum($total); ?>
                <td> {{$total_sum}}</td>
                <?php $invoice_total = array(); ?>
                @foreach($value->PoTercouriers as $po_data)
              <?php  
              $invoice_total[] = (int)$po_data->total_amount;
            //   dd((int)$po_data->total_amount);?>
                
                @endforeach
              <?php  $invoice_sum = array_sum($total); 
              $remaning_sum = (int)$value->initial_po_value - $invoice_sum;?>
                <td> {{$remaning_sum}}</td>
                <td>
                    @if($value->status == 1)
                    <div class="d-flex align-items-center justify-content-center" style="gap: 8px;">
                        <!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download" style="height: 16px; width: 16px;">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                            <polyline points="7 10 12 15 17 10"></polyline>
                            <line x1="12" y1="15" x2="12" y2="3"></line>
                        </svg> -->
                        <div class="action d-flex justify-content-center align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" data-toggle="modal" data-target="#cancelPOModal" @click="open_cancel_modal(<?php echo $value->po_number?>)"  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle" style="height: 16px; width: 16px;cursor:pointer">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="15" y1="9" x2="9" y2="15"></line>
                                <line x1="9" y1="9" x2="15" y2="15"></line>
                            </svg>
                        </div>
                    </div>
                    @endif
                </td>
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
                            <select class="form-control perpage" data-action="<?php //echo url()->current(); 
                                                                                ?>">
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

   <!-- HR approval Modal -->
   <div class="modal fade show" id="cancelPOModal" v-if="cancel_modal" tabindex="-1" role="dialog" aria-labelledby="cancelPOModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cancelPOModalLabel"> Po Number: @{{po_number}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- <div class="modal-body" v-if="loader">
                            <div class="d-flex justify-content-center align-items-center" style="min-height: 200px">
                                Loading...
                            </div>
                        </div> -->
                      
                        <div class="modal-body">
                            <form>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Cancel Remarks:</label>
                                    <input type="text" class="form-control" id="recipient-name" v-model="cancel_remarks">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" style="min-width: 100px" class="btn btn-primary" data-dismiss="modal" @click="submit_remarks()">Submit</button>
                        </div>

                    </div>
                </div>
            </div>

            <script>
    new Vue({
        el: '#divbox',
        // components: {
        //   ValidationProvider
        // },
        data: {
           po_number:"",
           cancel_modal:false,
           cancel_remarks:"",
           loader:false,
        },
        created: function() {
            // alert(this.got_details)
            //   alert('hello');
        },
        methods: {
            open_cancel_modal: function(number) {
            //   alert(number)
                this.po_number = number;
                this.cancel_modal = true;
                // $('#cancelPOModal').modal('show');
                // data-toggle="modal" data-target="#cancelPOModal"
            },
            submit_remarks: function() {
                this.loader = true;
                if (this.cancel_remarks != "") {
                    axios.post('/submit_cancel_remarks', {
                            'cancel_remarks': this.cancel_remarks,
                            'po_number': this.po_number,
                        })
                        .then(response => {
                            if (response.data == '1') {
                                swal('success', 'Updated Successfully!', 'success')
                                this.loader = false;
                                this.cancel_remarks="";
                                this.po_number = "";
                                location.reload();
                                // console.log(response.data[0].status)
                            }
                        }).catch(error => {

                            console.log(response)

                        })
                } else {
                    swal('error', 'Remarks are Required', 'error')
                }
            }
        },
      
        


    })
</script>