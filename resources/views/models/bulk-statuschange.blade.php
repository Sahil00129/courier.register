<div class="modal fade" id="bulk-terstatus" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title">Change Status</h4>
            </div>
        <!-- Modal body -->
            <!-- <form id="update_bulkstatus" method="POST">
                @csrf -->
                <div class="modal-body">
                    <div class="Delt-content text-center">
                        <h5><b>Handover Details</b></h5>
                        <input type="hidden" class="form-control" id="tercourier_id" name="tercourier_id">
                        <div class="form-row mb-0">
                            <div class="form-group col-md-6">
                                <label for="remarks">Given To</label>
                                <select class="form-control" id="given_to" name="given_to">
                                    <!-- <option value="">Select</option> -->
                                    <option value="Veena">Veena</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="remarks">Delivery Date</label>
                                <input type="date" class="form-control" id="delivery_date" name="delivery_date">
                            </div>
                        </div>  
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <div class="btn-section w-100">
                        <a class="btn-cstm btn-primary btn btn-modal bulkstatus-yes" data-action="<?php echo URL::to($prefix.'tercouriers/bulk-statuschange'); ?>" data-currenturl="<?php echo url()->current(); ?>" data-id = '{{isset($tercourier->id)?$tercourier->id:''}}'>Save</a>
                        <!-- <button type="submit" class="btn-cstm btn-default btn btn-modal">Save</button> -->
                        <a class="btn btn-modal" data-dismiss="modal">Cancel</a>
                    </div>
                </div>
            <!-- </form> -->
        </div>
    </div>
</div>