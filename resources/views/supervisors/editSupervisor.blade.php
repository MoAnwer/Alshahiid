@include('components.header', ['page_title' => 'تعديل بيانات مشرف '])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h4> تعديل بيانات المشرف {{ $supervisor->name }} </h4>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
		
        <x-alert />
		
        <form action="{{ route('supervisors.update', $supervisor->id) }}" method="POST">
          @csrf
          @method('PUT')
            <div class="form-group">
              <input name="name" type="text" class="p-4 form-control" placeholder="اسم المشرف" value="{{ $supervisor->name }}"/>
            </div>

            <div class="form-group">
              <input name="phone" type="text" class="p-4 form-control" placeholder="رقم الهاتف [{{ $supervisor->phone }}] دعه فارغ اذا لم ترغب بالتعديل عليه"/>
            </div>

            <button type="submit" class="btn btn-success py-2 mt-3">
              تعديل
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{ route('supervisors.index') }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')