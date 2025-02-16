@include('components.header', ['page_title' => 'تعديل  محاضرة ' . $lecture->name ])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h4>تعديل  محاضرة {{ $lecture->name }}</h4>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
		
        <x-alert />
		
        <form action="{{ route('tazkiia.lectures.update', $lecture->id) }}" method="POST">
          @csrf
          @method('PUT')
          <label>اسم  المحاضرة <span class="text-danger fs-5">*</span></label>
          <div class="form-group">
            <input name="name" type="text" class="p-4 form-control" placeholder="اسم  المحاضرة " value="{{ $lecture->name }}"/>
          </div>

          <label>تاريخ المحاضرة <span class="text-danger fs-5">*</span></label>
          <div class="form-group">
              <input name="date" type="date" class="p-4 form-control" placeholder="" value="{{ $lecture->date }}"/>
          </div>

		    	<label>الحالة</label>
            <div class="form-group">
              <select name="status" class="form-select">
                <option value="مطلوب" @selected($lecture->status == 'مطلوب')>مطلوب</option>
                <option value="منفذ" @selected($lecture->status == 'منفذ')>منفذ</option>
              </select>
            </div>

            <label> المبلغ <span class="text-danger fs-5">*</span></label>
            <div class="form-group">
              <input name="budget" type="number" class="p-4 form-control" placeholder="المبلغ" value="{{ $lecture->budget }}"/>
            </div>

            <label>المبلغ المقدم من داخل المنظمة </label>
            <div class="form-group">
              <input name="budget_from_org" type="number" class="p-4 form-control" placeholder="المبلغ المقدم من داخل المنظمة" value="{{ $lecture->budget_from_org }}"/>
            </div>

            <label>المبلغ المقدم من خارج المنظمة </label>
            <div class="form-group">
              <input name="budget_out_of_org" type="number" class="p-4 form-control" placeholder="المبلغ المقدم من خارج المنظمة" value="{{ $lecture->budget_out_of_org }}"/>
            </div>
            
            <label>القطاع :</label>
            <div class="form-group">
                <select name="sector" class="form-select">
                  <option value="القطاع الشرقي"  @selected($lecture->sector == 'القطاع الشرقي')>القطاع الشرقي</option>
                  <option value="القطاع الشمالي" @selected($lecture->sector == 'القطاع الشمالي')>القطاع الشمالي</option>
                  <option value="القطاع الغربي"  @selected($lecture->sector == 'القطاع الغربي')>القطاع الغربي</option>
                </select>
              </div>

              <label>المحلية: </label>
              <div class="form-group">
                <select name="locality" class="form-select">
                  @foreach(['كسلا','خشم القربة','همشكوريب','تلكوك وتوايت','شمال الدلتا','اروما','ريفي كسلا','غرب كسلا','محلية المصنع محطة ود الحليو','نهر عطبرة','غرب كسلا','حلفا الجديدة'] as $locality)
                    <option value="{{ $locality }}" @selected($lecture->locality == $locality)>{{ $locality }}</option>
                    @endforeach
                  </select>
              </div>
              

            <label>ملاحظات: </label>
            <textarea name="notes" class="form-control w-100">{{ $lecture->notes }}</textarea>

            <button type="submit" class="btn btn-success py-2 mt-3">
              تعديل
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{ route('tazkiia.lectures.index') }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')