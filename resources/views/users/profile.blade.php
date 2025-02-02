@include('components.header', ['page_title' => auth()->user()->username])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

     @if($errors->any())
        @foreach($errors->all() as $error)
          <div class="alert alert-danger"> {{ $error }} </div>
        @endforeach
      @endif


      <div class="row">
          <x-alert />

      <div class="col-lg-6 col-12 mx-auto mt-5">
        <div class="card py-3">
          <div class="card-body d-flex flex-column align-items-center justify-content-between">
            <div class="d-flex flex-column align-items-center mb-4 border-bottom pb-3">
              <img src="{{ asset('asset/images/undraw_profile_2.svg') }}" class="mb-3" width="200">
              <h1 class="h4">{{ auth()->user()->username }}</h1>
              <h3 class="h6">{{ auth()->user()->full_name }}</h3>
            </div>

                

          <div class="data w-100">
            <div class="form-group">
            <form action="{{ route('profile.update') }}" method="POST">
              @csrf
              @method('PUT')

              <label>اسم المستخدم</label>
              <input name="username" type="text" class="p-4 mb-3 form-control" placeholder="{{ auth()->user()->username }} (دعه فارغ اذا لم ترغب بالتعديل عليه)"/>
              <label>الاسم رباعي</label>
              <input name="full_name" type="text" maxlength="60" class="p-4 mb-3 form-control" placeholder="{{ auth()->user()->full_name }}"/>
              <label>كلمة السر (دعها فارغة اذا لم ترغب بالتعديل عليها)</label>
              <input name="password" type="password" class="p-4 mb-3 form-control" placeholder="******"/>
              <button type="submit" class="btn btn-success py-2 mt-3" maxlength="17">
                تعديل
              </button>
            </div>
          </div>
        </div>
      </div>


    </div>
  </div>

@include('components.footer')