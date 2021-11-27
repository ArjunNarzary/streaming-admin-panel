
@extends('layouts.master')
@section('content')
<div class="container">
    <div class="text-right py-2">
        <button class="btn btn-primary" data-toggle="modal" data-target="#addGenre"><i class="fa fa-plus"></i> Add Genre</button>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered datatable" id="genreTable">
            <thead>
                <tr>
                    <th class="text-center">Sl No</th>
                    <th>Name</th>
                    <th class="text-center">Total Movies</th>
                    <th class="text-center">Toal Series</th>
                    <th class="text-center">Edit</th>
                    <th class="text-center">Delete</th>
                </tr>
            </thead>
            <tbody>
                @if(count($genres) != 0)
                    @foreach($genres as $key => $genre)
                        <tr>
                            <td class="text-center">{{ $key+1 }}</td>
                            <td>{{ $genre->name }}</td>
                            <td class="text-center">{{ count($genre->movies) }}</td>
                            <td class="text-center"></td>
                            <td class="text-center"><a href="" onclick="return false"><i class="fas fa-edit editGenre" id="{{ \encrypt($genre->id) }}"></i></a></td>
                            <td class="text-center"><a class="text-danger" href="{{ route('genre.delete', ['genre' => \encrypt($genre->id)]) }}"  onclick="return confirm('Are you sure?')"><i class="fas fa-trash-alt deleteCast"></i></a></td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

<!--Modal for adding Genre-->
  <div class="modal fade" id="addGenre" tabindex="-1" role="dialog" aria-labelledby="addGenreLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary py-2">
          <h5 class="modal-title text-uppercase font-weight-bold text-light text-center" id="addGenreLabel">Add New Genre</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="genreForm">
            @csrf
        <div class="modal-body px-5">
            <div class="form-group">
                <input type="hidden" name="id" id="genre_id" value="">
                <label for="name">Genre Name</label>
                <input type="text" class="form-control" name="name" id="name" required>
                <div class="invalid-feedback" role="alert">
                    <strong></strong>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="addGenrebtn" class="btn btn-primary addGenrebtn">Save</button>
        </div>
        </form>
      </div>
    </div>
  </div>
<!--Modal for adding Genre END-->


@endsection

