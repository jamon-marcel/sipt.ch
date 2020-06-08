@extends('layouts.app')
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">{{ __('Register') }}</div>
        <div class="card-body">
          <form method="POST" action="{{ route('student_store') }}">
              @csrf
              <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">Name *</label>
                <div class="col-md-6">
                  <input type="text" name="name" class="form-control" required value="Name">
                </div>
              </div>
              <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">Vorname *</label>
                <div class="col-md-6">
                  <input type="text" name="firstname" class="form-control" required value="Vorname">
                </div>
              </div>
              <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">E-Mail *</label>
                <div class="col-md-6">
                  <input type="text" name="email" class="form-control" required value="">
                </div>
              </div>
              <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">Titel</label>
                <div class="col-md-6">
                  <input type="text" name="title" class="form-control" value="Titel">
                </div>
              </div>
              <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">Strasse *</label>
                <div class="col-md-6">
                  <input type="text" name="street" class="form-control" required value="Strasse">
                </div>
              </div>
              <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">Nr. *</label>
                <div class="col-md-6">
                  <input type="text" name="street_no" class="form-control" required value="Nr.">
                </div>
              </div>
              <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">ZIP *</label>
                <div class="col-md-6">
                  <input type="text" name="zip" class="form-control" required value="ZIP">
                </div>
              </div>
              <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">City *</label>
                <div class="col-md-6">
                  <input type="text" name="city" class="form-control" required value="City">
                </div>
              </div>
              <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">Telefon *</label>
                <div class="col-md-6">
                  <input type="text" name="phone" class="form-control" required value="052 222 22 22">
                </div>
              </div>
              <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">Telefon Geschäft</label>
                <div class="col-md-6">
                  <input type="text" name="phone_business" class="form-control">
                </div>
              </div>
              <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">Mobile</label>
                <div class="col-md-6">
                  <input type="text" name="mobile" class="form-control">
                </div>
              </div>
              <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">Berufsabschluss *</label>
                <div class="col-md-6">
                  <input type="text" name="qualifications" class="form-control" required value="Berufsabschluss">
                </div>
              </div>
              <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                    {{ __('Register') }}
                  </button>
                </div>
              </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection