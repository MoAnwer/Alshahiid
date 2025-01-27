@include('components.header', ['page_title' => 'اضافة اسرة للشهيد '])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
     <div id="content">	  

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h4>اضافة اسرة للشهيد  {{ $martyr->name }}</h4>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
		
        <x-alert />
		
			<form action="{{ route('families.store', $martyr->id) }}" method="POST">
			 @csrf
			 
	    <label>الشريحة</label>
      
		  <div class="form-group">
				<select class="form-select" name="category">
          @foreach(['أرملة و ابناء','أب و أم و أخوان و أخوات','أخوات','مكتفية'] as $category)
            <option value="{{ $category }}">{{ $category }}</option>
          @endforeach
				</select>
		  </div>

      <label>عدد الافراد: </label>
      <div class="form-group">
        <input class="form-control py-4" type="number" name="family_size" value="{{ old('family_size') }}"/>
      </div>
      
		  <label>القطاع :</label>
      <div class="form-group">
        <select name="sector" class="form-select">
          <option value="القطاع الشرقي">القطاع الشرقي</option>
          <option value="القطاع الشمالي">القطاع الشمالي</option>
          <option value="القطاع الغربي">القطاع الغربي</option>
        </select>
      </div>

      <label>المحلية: </label>
      <div class="form-group">
        <select name="locality" class="form-select">
					@foreach(['كسلا','خشم القربة','همشكوريب','تلكوك وتوايت','شمال الدلتا','اروما','ريفي كسلا','غرب كسلا','محلية المصنع محطة ود الحليو','نهر عطبرة','غرب كسلا','حلفا الجديدة'] as $locality)
		      <option value="{{ $locality }}">{{ $locality }}</option>
          @endforeach
        </select>
      </div>

      <label>الحي: </label>
      <div class="form-group">
        <input class="form-control py-4" type="text" name="neighborhood" value="{{ old('neighborhood') }}"/>
      </div>


      <label>نوع السكن: </label>
      <div class="form-group">
        <select name="type" class="form-select">
          <option value="ملك">ملك</option>
          <option value="مؤجر">مؤجر</option>
          <option value="حكومي">حكومي</option>
          <option value="ورثة">ورثة</option>
          <option value="استضافة">استضافة</option>
          <option value="قروي">قروي</option>
          <option value="رحل">رحل</option>
          <option value="أخرى">أخرى</option>
        </select>
      </div>

        <button type="submit" class="btn btn-success py-2 mt-3">
          انشاء
        </button>
        <a class="btn btn-info py-2 mt-3" href="{{ route('martyrs.index') }}">رجوع</a>

        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')
