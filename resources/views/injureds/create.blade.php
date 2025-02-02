@include('components.header', ['page_title' => 'اضافة مصاب'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h4>اضافة مصاب جديد</h4>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
		
        <x-alert />
		
        <form action="{{ route('injureds.store') }}" method="POST">
          @csrf
            <div class="form-group">
            <span class="text-danger fs-5">*</span>
              <input type="text" class="p-4 form-control" name="name" placeholder="اسم المصاب" value="{{ old('name') }}" />
            </div>

            <div class="form-group">
            <span class="text-danger fs-5">*</span>
              <input type="text" class="p-4 form-control" name="type"  placeholder="نوع الاصابة" max-length="2" value="{{ old('type') }}"/>
            </div>

			      <label>تاريخ الاصابة <span class="text-danger fs-5">*</span></label>
      
            <div class="form-group">
              <input  type="date" class="p-4 form-control" name="injured_date" value="{{ old('injured_date') }}" />
            </div>

			      <label>نسبة الاصابة <span class="text-danger fs-5">*</span></label>
            <div class="form-group">
              <input name="injured_percentage" type="number" class="p-4 form-control" value="{{ old('injured_percentage') }}"/>
            </div>
            
            <div class="form-group">
              <input name="health_insurance_number" type="number" class="p-4 form-control" placeholder="رقم بطاقة التأمين الصحي" value="{{ old('health_insurance_number') }}"/>
            </div>
            
            <label>تاريخ بداية التأمين الصحي</label>
            <div class="form-group">
              <input name="health_insurance_start_date" type="date" class="p-4 form-control" value="{{ old('health_insurance_start_date') }}"/>
            </div>
            

            <label>تاريخ نهاية التأمين الصحي</label>
            <div class="form-group">
              <input name="health_insurance_end_date" type="date" class="p-4 form-control" value="{{ old('health_insurance_end_date') }}"/>
            </div>

            <label>ملاحظات: </label>
            <textarea name="notes" class="form-control w-100">{{ old('note')}}</textarea>

            <button type="submit" class="btn btn-success py-2 mt-3">
              انشاء
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{ route('injureds.index') }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')