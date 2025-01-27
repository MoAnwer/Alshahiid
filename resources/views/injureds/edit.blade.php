@include('components.header', ['page_title' => 'تعديل بيانات المصاب'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h4>تعديل بيانات المصاب {{$injured->name}} </h4>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
		
        <x-alert />
		
        <form action="{{ route('injureds.update', $injured->id) }}" method="POST">
          @csrf
		  @method('PUT')
            <div class="form-group">
              <input type="text" class="p-4 form-control" name="name" placeholder="اسم المصاب" value="{{ $injured->name }}" />
            </div>

            <div class="form-group">
              <input type="text" class="p-4 form-control" name="type"  placeholder="نوع الاصابة" max-length="2" value="{{ $injured->type }}"/>
            </div>

            <label>رقم بطاقة التأمين الصحي</label>
            <div class="form-group">
              <input name="health_insurance_number" type="number" class="p-4 form-control" 
              placeholder="{{$injured->health_insurance_number}}" value="{{ old('health_insurance_number') }}"/>
            </div>
            
            <label>تاريخ بداية التأمين الصحي</label>
            <div class="form-group">
              <input name="health_insurance_start_date" type="date" class="p-4 form-control" value="{{  $injured->health_insurance_start_date }}"/>
            </div>
            

            <label>تاريخ نهاية التأمين الصحي</label>
            <div class="form-group">
              <input name="health_insurance_end_date" type="date" class="p-4 form-control" value="{{  $injured->health_insurance_end_date }}"/>
            </div>

			<label>تاريخ الاصابة</label>
            <div class="form-group">
              <input  type="date" class="p-4 form-control" name="injured_date" value="{{ $injured->injured_date }}" />
            </div>

			<label>نسبة الاصابة</label>
            <div class="form-group">
              <input name="injured_percentage" type="number" class="p-4 form-control" value="{{ $injured->injured_percentage }}"/>
            </div>
            
            <label>ملاحظات: </label>
            <textarea name="notes" class="form-control w-100">{{ $injured->notes }}</textarea>

            <button type="submit" class="btn btn-success py-2 mt-3">
              تعديل
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{ route('injureds.index') }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')