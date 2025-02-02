@include('components.header', ['page_title' => 'تعديل  معسكر جديدة '])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h4>تعديل  معسكر {{ $camp->name }} </h4>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
		
        <x-alert />
		
        <form action="{{ route('tazkiia.camps.update', $camp->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="form-group">
            <label>اسم  المعسكر <span class="text-danger fs-5">*</span></label>
            <input name="name" type="text" class="p-4 form-control" placeholder="اسم  المعسكر " value="{{ $camp->name }}"/>
          </div>

          <label>تاريخ بداية المعسكر<span class="text-danger fs-5">*</span></label>
          <div class="form-group">
              <input name="start_at" type="date" class="p-4 form-control" placeholder="" value="{{ $camp->start_at }}"/>
          </div>


          <label>تاريخ انتهاء المعسكر<span class="text-danger fs-5">*</span></label>
          <div class="form-group">
              <input name="end_at" type="date" class="p-4 form-control" placeholder="" value="{{ $camp->end_at }}"/>
          </div>

		    	<label>الحالة</label>
            <div class="form-group">
              <select name="status" class="form-select">
                <option value="مطلوب" @selected($camp->status == 'مطلوب')>مطلوب</option>
                <option value="منفذ" @selected($camp->status == 'منفذ')>منفذ</option>
              </select>
            </div>

            <label>المبلغ<span class="text-danger fs-5">*</span></label>
            <div class="form-group">
              <input name="budget" type="number" class="p-4 form-control" placeholder="المبلغ" value="{{ $camp->budget }}"/>
            </div>

            <label>المبلغ المقدم من داخل المنظمة</label>
            <div class="form-group">
              <input name="budget_from_org" type="number" class="p-4 form-control" placeholder="" value="{{ $camp->budget_from_org }}"/>
            </div>

            <label>المبلغ المقدم من خارج المنظمة</label>
            <div class="form-group">
              <input name="budget_out_of_org" type="number" class="p-4 form-control" placeholder="" value="{{ $camp->budget_out_of_org }}"/>
            </div>
            
            <label>ملاحظات: </label>
            <textarea name="notes" class="form-control w-100">{{ $camp->notes }}</textarea>

            <button type="submit" class="btn btn-success py-2 mt-3">
              تعديل
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{ route('tazkiia.camps.index') }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')