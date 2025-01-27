@include('components.header', ['page_title' => 'خدمات مصابين'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h4>اضافة خدمة للمصاب {{ $injured->name }}</h4>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
		
        <x-alert />
		
        <form action="{{ route('injuredServices.store', $injured->id) }}" method="POST">
          @csrf
            <div class="form-group">
              <input type="text" class="p-4 form-control" name="name" placeholder="اسم الخدمة" value="{{ old('name') }}" />
            </div>
			
			<label>نوع الخدمة</label>
			<div class="form-group">
              <select name="type" class="form-select">
				@foreach(['إعانة عامة',
					'سكن',
					'مشروع إنتاجي',
					'طرف صناعي',
					'وسيلة حركة',
					'علاج',
					'تأهيل مهني و معنوي'] as $service)
                <option value="{{ $service }}">{{ $service }}</option>
				@endforeach
              </select>
            </div>
			
			<label>حالة الخدمة</label>
			<div class="form-group">
              <select name="status" class="form-select">
                <option value="مطلوب">مطلوب</option>
                <option value="منفذ">منفذ</option>
              </select>
            </div>
			
			<div class="form-group">
              <input type="text" class="p-4 form-control" name="description" placeholder="وصف الخدمة" value="{{ old('description') }}" />
            </div>
			
            <div class="form-group">
              <input  type="number" class="p-4 form-control" placeholder="المبلغ" name="budget" value="{{ old('budget') }}" />
            </div>
			
            <div class="form-group">
              <input  type="number" class="p-4 form-control" placeholder="من داخل المنظمة" name="budget_from_org" value="{{ old('budget_from_org') }}" />
            </div>
			
            <div class="form-group">
              <input  type="number" class="p-4 form-control" placeholder="من خارج المنظمة" name="budget_out_of_org" value="{{ old('budget_out_of_org') }}" />
            </div>

            <label>ملاحظات: </label>
            <textarea name="notes" class="form-control w-100" style="min-height: 60px !important">{{ old('note')}}</textarea>

            <button type="submit" class="btn btn-success py-2 mt-3">
              انشاء
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{ route('injureds.show', $injured->id) }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')