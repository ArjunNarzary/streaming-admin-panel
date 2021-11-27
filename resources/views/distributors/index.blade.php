
@extends('layouts.master')
@section('content')
<div class="container">
    <div class="text-right py-2">
        <button class="btn btn-primary" data-toggle="modal" data-target="#addDistributor"><i class="fa fa-plus"></i> Add Cast</button>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered datatable" id="distributorTable">
            <thead>
                <tr>
                    <th class="text-center">Sl No</th>
                    <th>Name</th>
                    <th class="text-center">View</th>
                    <th class="text-center">Edit</th>
                    <th class="text-center">Delete</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @if(count($distributors) != 0)
                    @foreach($distributors as $key => $distributor)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td>{{ $distributor->name }}</td>
                            <td class="text-center"><a href="" onclick="return false"><i class="fas fa-eye viewDistributor" id="{{ \encrypt($distributor->id) }}"></i></a></td>
                            <td class="text-center"><a href="" onclick="return false"><i class="fas fa-edit editDistributor" id="{{ \encrypt($distributor->id) }}"></i></a></td>
                            <td class="text-center"><a class="text-danger" href="{{ route('distributor.delete', ['distributor' => \encrypt($distributor->id)]) }}"  onclick="return confirm('Are you sure?')"><i class="fas fa-trash-alt deleteDistributor"></i></a></td>
                            <td class="text-center">@if($distributor->active == '1') <span class="text-success">Active</span> @else <span class="text-danger">Inactive</span>@endif</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

<!--Modal for adding Distributor-->
  <div class="modal fade" id="addDistributor" tabindex="-1" role="dialog" aria-labelledby="addDistributorLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary py-2">
          <h5 class="modal-title text-uppercase font-weight-bold text-light text-center" id="addCastLabel">Add New Distributor</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="distributorForm">
            @csrf
        <div class="modal-body px-5">
            <div class="form-group">
                <input type="hidden" name="id" id="distributor_id" value="">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" id="name" required>
                <div class="invalid-feedback" role="alert">
                    <strong></strong>
                </div>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" required>
                <div class="invalid-feedback" role="alert">
                    <strong></strong>
                </div>
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select class="custom-select" name="gender" id="gender">
                    <option value="">Select</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Other">Other</option>
                </select>
                <div class="invalid-feedback" role="alert">
                    <strong></strong>
                </div>
            </div>
            <div class="form-group">
                <label for="company_name">Company</label>
                <input type="text" class="form-control" name="company_name" id="company_name" required>
                <div class="invalid-feedback" role="alert">
                    <strong></strong>
                </div>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select class="custom-select" name="status" id="status">
                    <option value="">Select</option>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
                <div class="invalid-feedback" role="alert">
                    <strong></strong>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="addDistributorbtn" class="btn btn-primary addDistributorbtn">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>
<!--Modal for adding Distributor END-->
<!--Modal for viewing Distributor-->
<div class="modal fade" id="viewDistributor" tabindex="-1" role="dialog" aria-labelledby="viewDistributorLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary py-2">
          <h5 class="modal-title text-uppercase font-weight-bold text-light text-center" id="viewDistributorLabel">Distributor Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body px-5">
            <div class="form-group">
                <label class="font-weight-bold mb-0 d-block" for="name">Name</label>
                <label id="name"></label>
            </div>
            <div class="form-group">
                <label class="font-weight-bold mb-0 d-block" for="email">Email</label>
                <label id="email"></label>
            </div>
            <div class="form-group">
                <label class="font-weight-bold mb-0 d-block" for="gender">Gender</label>
                <label id="gender"></label>
            </div>
            <div class="form-group">
                <label class="font-weight-bold mb-0 d-block" for="company">Company</label>
                <label id="company"></label>
            </div>
            <div class="form-group">
                <label class="font-weight-bold mb-0 d-block" for="status">Status</label>
                <label id="status"></label>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
<!--Modal for viewing Distributor END-->

@endsection
