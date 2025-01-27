@include('components.header', ['page_title' => 'حذف'])

 <div id="wrapper">


    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      
      <div class="container-fluid mt-4">
        <h4>حذف بيانات الشهيد  {{ $martyr->name }}</h4>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
        
        <x-alert />

        <form action="{{ route('martyrs.destroy', $martyr->id ) }}" method="POST">
          <h5>هل تريد حذف بيانات الشهيد   حقاً ؟</h5>
          @csrf
          @method('DELETE')
            <button type="submit" class="btn btn-danger py-2 mt-3">
              حذف
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{ route('martyrs.index') }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')