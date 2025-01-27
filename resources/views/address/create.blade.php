@include('components.header', ['page_title' => 'اضافة سكن'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h4> اضافة بيانات السكن لاسرة الشهيد {{ $family->martyr->name}} </h4>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
        <x-alert />

        <form action="{{ route('address.store', $family->id) }}" method="POST">
          @csrf
          <label>القطاع :</label>
            <div class="form-group">
              <select name="sector" class="form-select">
                <option value="القاش">القاش</option>
                <option value="اروما">اروما</option>
                <option value="حلفا">حلفا</option>
              </select>
            </div>

            <label>المحلية: </label>
            <div class="form-group">
              <select name="locality" class="form-select">
			@foreach(['كسلا','خشم القربة','همشكوريب','تلكوك',' شمال الدلتا','جنوب الدلتا','ريفي كسلا','غرب كسلا','ود الحليو','نهر عطبرة','ريفي غرب كسلا','حلفا الجديدة'] as $locality)
					<option value="{{ $locality }}">{{ $locality }}</option>
                @endforeach
              </select>
            </div>

            <label>الحي: </label>
            <div class="form-group">
              <input class="form-control py-4" name="neighborhood" value="{{ old('neighborhood') }}"/>
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
              <i class="fa fas-user-plus"></i>
              اضافة
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{ route('families.show', $family->id) }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')