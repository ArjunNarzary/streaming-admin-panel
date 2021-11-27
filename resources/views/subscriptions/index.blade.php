
@extends('layouts.master')
@section('content')
<div class="container">
    <div class="text-right py-2">
        <a href="{{ route('subscription.plan.add') }}">
            <button class="btn btn-primary"><i class="fa fa-plus"></i> Add New Subscription Plan</button>
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered datatable" id="crewTable">
            <thead>
                <tr>
                    <th class="text-center">Sl No</th>
                    <th>Name</th>
                    <th>Fee (Rs)</th>
                    <th>Tax (Rs)</th>
                    <th>Time Period Type</th>
                    <th>Time Period</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if(count($subPlans) != 0)
                    @foreach($subPlans as $key => $sub)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td>{{ $sub->name }}</td>
                            <td>{{ number_format($sub->fee, 2) }}</td>
                            <td>{{ number_format($sub->tax, 2) }}</td>
                            <td>{{ $sub->time_period_type }}</td>
                            <td>{{ $sub->time_period }}</td>
                            <td class="text-center">
                                @if($sub->status == 1)
                                <span class="badge badge-success">Active</span>
                                @else
                                <span class="badge badge-danger">Inactive</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="" onclick="return false"><i class="fas fa-eye viewPlan" data-id="{{ \encrypt($sub->id) }}"></i></a>
                                <a href="{{ route('subscription.plan.edit', ['id' => \encrypt($sub->id)]) }}" ><i class="fas fa-edit"></i></a>
                                <a class="text-danger" href="{{ route('subscription.plan.delete', ['id' => \encrypt($sub->id)]) }}"  onclick="return confirm('Are you sure?')"><i class="fas fa-trash-alt deleteCast"></i></a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

<!--Modal for adding crew-->
  <div class="modal fade" id="viewPlanModal" tabindex="-1" role="dialog" aria-labelledby="viewPlanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary py-2">
          <h5 class="modal-title text-uppercase font-weight-bold text-light text-center" id="viewPlanLabel">Subscription Plan Detail</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="crewForm">
            @csrf
        <div class="modal-body px-5 font-weight-bold">
            <div class="form-group row">
                <label class="col-5 text-uppercase">Plan Name : </label>
                <label class="text-primary col-7" id="name">Plan Name</label>
            </div>
            <div class="form-group row">
                <label class="col-12 text-uppercase">Plan Description : </label>
                <textarea class="col-12 form-control" id="description" name="description" rows="5" disabled></textarea>
            </div>
            <div class="form-group row">
                <label class="col-5 text-uppercase">Plan Fee : </label>
                <label class="text-primary col-7 fee" id="fee">Plan Name</label>
            </div>
            <div class="form-group row">
                <label class="col-5 text-uppercase">Plan Tax : </label>
                <label class="text-primary col-7 tax" id="tax">Plan Name</label>
            </div>
            <div class="form-group row">
                <label class="col-5 text-uppercase">Plan Period Type : </label>
                <label class="text-primary col-7 period_type" id="period_type">Plan Name</label>
            </div>
            <div class="form-group row">
                <label class="col-5 text-uppercase">Plan Time Period : </label>
                <label class="text-primary col-7 time_period" id="time_period">Plan Name</label>
            </div>
            <div class="form-group row">
                <label class="col-5 text-uppercase">Status : </label>
                <label class="text-primary col-7 status" id="status">Plan Name</label>
            </div>

        </div>
        <div class="modal-footer justify-content-center">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>
<!--Modal for adding Crew END-->

@endsection

@push('scripts')
<script>
    $(document).ready(function() {

        $('#description').ckeditor();
       //View Plan
       $(document).on('click', '.viewPlan', function(){
           var id = $(this).attr('data-id');

           $.post('{{ route("subscription.plan.view") }}', {id:id},
                function(data) {
                    if(data.status == true){
                        var modal = $('#viewPlanModal');
                        modal.find('#name').text(data.sub.name);
                        modal.find('#description').val(data.sub.description);
                        modal.find('#fee').text(data.sub.tax);
                        modal.find('#tax').text(data.sub.fee);
                        modal.find('#period_type').text(data.sub.time_period_type);
                        modal.find('#time_period').text(data.sub.time_period);

                        if(data.sub.status == 1){
                            modal.find('#status').text('Active');
                        }else{
                            modal.find('#status').text('Inactive');
                        }

                        modal.modal('show');

                    }
                    else{
                        alert('Please try again.')
                    }
                });
       })

    }); //end of ready function
</script>
@endpush
