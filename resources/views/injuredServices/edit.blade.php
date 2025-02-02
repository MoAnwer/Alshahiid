@include('components.header', ['page_title' => 'خدمات مصابين'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h4>تعديل خدمة {{ $injuredService->name }}</h4>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
		
        <x-alert />
		
        <form action="{{ route('injuredServices.update', $injuredService->id) }}" method="POST">
          @csrf
		  @method('PUT')
            <div class="form-group">
            <label><span class="text-danger fs-5">*</span>اسم الخدمة</label>
              <input type="text" class="p-4 form-control" name="name" placeholder="اسم الخدمة" value="{{ $injuredService->name }}" />
            </div>
			
			<label>نوع الخدمة</label>
			<div class="form-group">
              <select name="type" class="form-select">
                <option value="{{  $injuredService->type }}" selected>{{  $injuredService->type }}</option>
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
            <option value="مطلوب" @selected($injuredService->status == 'مطلوب')>مطلوب</option>
            <option value="منفذ" @selected($injuredService->status == 'منفذ')>منفذ</option>
          </select>
        </div>
			
			  <div class="form-group">
	  		<label>وصف الخدمة</label>
              <input type="text" class="p-4 form-control" name="description" placeholder="وصف الخدمة" value="{{ $injuredService->description }}" />
            </div>
			
	  		<label><span class="text-danger fs-5">*</span> المبلغ</label>
            <div class="form-group">
              <input  type="number" class="p-4 form-control" placeholder="المبلغ" name="budget" value="{{ $injuredService->budget }}" />
            </div>
			
	  		<label> من داخل المنظمة</label>
            <div class="form-group">
              <input  type="number" class="p-4 form-control" placeholder="من داخل المنظمة" name="budget_from_org" value="{{ $injuredService->budget_from_org }}" />
            </div>
			
	  		<label> من خارج المنظمة</label>

            <div class="form-group">
              <input  type="number" class="p-4 form-control" placeholder="من خارج المنظمة" name="budget_out_of_org" value="{{$injuredService->budget_out_of_org }}" />
            </div>

            <label>ملاحظات: </label>
            <textarea name="notes" class="form-control w-100" style="min-height: 60px !important">{{ $injuredService->notes }}</textarea>

            <button type="submit" class="btn btn-success py-2 mt-3">
              تعديل
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{ route('injureds.show', $injuredService->injured->id) }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')