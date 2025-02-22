@include('components.header', ['page_title' => 'إضافة شهيد'])

 <div id="wrapper">

  @include('components.sidebar')
  <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">
	  

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h4>ربط الشهيد {{ $martyr->name }} بإسرة</h4>
        <hr />

       @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
      @endif

      <x-alert />
		

        <form action="{{ route('martyrs.relateToFamilyAction', $martyr->id) }}" method="POST">
          @csrf
          <div class="mx-auto">

              <label>ادخل المعرف الخاص بالاسرة:</label>
                <div class="form-group">
                  <input name="family_id" type="number" class="form-control py-4" />
                </div>
              </div>

            <button class="btn py-4 btn-primary active form-control mx-auto">
                <i class="bi bi-plus-circle ml-2"></i>
                إضافة 
            </button>

          </div>

        </form>
    
      </div>

    </div>

  @include('components.footer')