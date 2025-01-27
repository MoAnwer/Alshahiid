@include('components.header', ['page_title' => 'اضافة مشرف جديد '])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h4> اضافة مشرف جديد </h4>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
		
        <x-alert />
		
        <form action="{{ route('supervisors.store') }}" method="POST">
          @csrf
            <div class="form-group">
              <input name="name" type="text" class="p-4 form-control" placeholder="اسم المشرف" value="{{ old('name') }}"/>
            </div>

            <div class="form-group">
              <input name="phone" type="text" class="p-4 form-control" placeholder="رقم الهاتف" value="{{ old('phone') }}"/>
            </div>

            <button type="submit" class="btn btn-success py-2 mt-3">
              انشاء
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{ route('supervisors.index') }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')