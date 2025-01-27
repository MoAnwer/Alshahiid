@include('components.header', ['page_title' => 'حذف بيانات مصاب'])

 <div id="wrapper">


    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      
      <div class="container-fluid mt-4">
        <h4>حذف خدمة {{ $injuredService->name }} </h4>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
        <x-alert />
        <form action="{{ route('injuredServices.destroy', $injuredService->id ) }}" method="POST">
          <h5>هل تريد حذف  بيانات خدمة  {{ $injuredService->name }} حقاً ؟</h5>
          @csrf
          @method('DELETE')
            <button type="submit" class="btn btn-danger py-2 mt-3">
              حذف
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{ route('injureds.show', $injuredService->injured->id) }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')