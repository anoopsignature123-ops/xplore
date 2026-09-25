@extends('admin.includes.layout')
@section('title', $page_title)
@section('content')
<div class="page-body">
   <div class="container-fluid">
      <div class="page-title">
         <div class="row">
            <div class="col-sm-6 col-12">
               <h4 class="m-0">{{ $page_title }}</h4>
            </div>
            <div class="col-sm-6 col-12">
               <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('admin.index') }}"><i class="fa-solid fa-home me-2"></i></a></li>
                  <li class="breadcrumb-item"><a href="{{ route('admin.build-category.list') }}">Build Categories</a></li>
                  <li class="breadcrumb-item active">{{ $page_title }}</li>
               </ol>
            </div>
         </div>
      </div>
   </div>
   <div class="container-fluid">
      <div class="row">
         <div class="col-sm-12">
            <div class="card shadow-lg border-0 rounded-3">
               <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
                  <h5 class="mb-0 fw-bold text-primary">{{ $page_title }}</h5>
                  <a href="{{ route('admin.build-category.list') }}" class="btn btn-secondary btn-sm">
                     <i class="fas fa-arrow-left me-1"></i> Back
                  </a>
               </div>
               <div class="card-body">
                  <form action="{{ route('admin.build-category.save') }}" method="POST">
                     @csrf
                     <input type="hidden" name="id" value="{{ $category->id ?? '' }}">

                     <div class="row g-3">
                        <div class="col-md-6">
                           <label class="form-label fw-bold">Category Name <span class="text-danger">*</span></label>
                           <input type="text" name="name" class="form-control" value="{{ old('name', $category->name ?? '') }}" placeholder="e.g. Architect, Civil Contractor" required>
                        </div>

                        <div class="col-md-6 d-flex align-items-center mt-4">
                           <div class="form-check form-switch">
                              <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{ old('status', $category->status ?? true) ? 'checked' : '' }}>
                              <label class="form-check-label fw-bold" for="status">Active Status</label>
                           </div>
                        </div>

                        <div class="col-12 text-end mt-4">
                           <button type="submit" class="btn btn-primary px-4">{{ $btn_title }}</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
