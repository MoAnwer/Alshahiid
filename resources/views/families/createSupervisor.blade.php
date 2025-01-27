@include('components.header', ['page_title' => 'اضافة مشرف لاسرة للشهيد '])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
     <div id="content">	  

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h4>اضافة مشرف لاسرة للشهيد  {{ $family->martyr->name }}</h4>
        <hr />
        
      @if($errors->any())
        @foreach($errors->all() as $error)
          <div class="alert alert-danger"> {{ $error }} </div>
        @endforeach
      @endif
		
      <x-alert />
		
			<form action="{{ route('families.storeSupervisor', $family->id) }}" method="POST">
			  @csrf
        <label>إختار المشرف</label>
        <div class="form-group">
          <select class="form-select" name="supervisor_id">
            @foreach($supervisors as $supervisor)
              <option value="{{ $supervisor->id }}">{{ $supervisor->name }}</option>
            @endforeach
          </select>
        </div>

        <button type="submit" class="btn btn-success py-2 mt-3">
          اضافة
        </button>
        <a class="btn btn-info py-2 mt-3" href="{{ route('families.show', $family->id) }}">رجوع</a>
      </form>

    </div>
  </div>

  @include('components.footer')
