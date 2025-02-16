@include('components.header', ['page_title' =>  'تعديل  حلقة  '])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h4> تعديل  حلقة {{ $session->name }} </h4>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
		
        <x-alert />
		
        <form action="{{ route('tazkiia.sessions.update', $session->id) }}" method="POST">
          @csrf
          @method('PUT')
          <label>اسم  الحلقة <span class="text-danger fs-5">*</span></label>
          <div class="form-group">
            <input name="name" type="text" class="p-4 form-control" value="{{ $session->name }}"/>
          </div>

         <label>تاريخ الحلقة <span class="text-danger fs-5">*</span></label>
          <div class="form-group">
              <input name="date" type="date" class="p-4 form-control" value="{{ $session->date }}"/>
          </div>

		    	<label>الحالة</label>
            <div class="form-group">
              <select name="status" class="form-select">
                <option value="مطلوب">مطلوب</option>
                <option value="منفذ">منفذ</option>
              </select>
            </div>

            <label>المبلغ <span class="text-danger fs-5">*</span></label>
            <div class="form-group">
              <input name="budget" type="number" class="p-4 form-control" placeholder="المبلغ" value="{{ $session->budget }}"/>
            </div>

            <label>لمبلغ المقدم من داخل المنظمة</label>
            <div class="form-group">
              <input name="budget_from_org" type="number" class="p-4 form-control" value="{{ $session->budget_from_org }}"/>
            </div>

            <label>لمبلغ المقدم من خارج المنظمة</label>
            <div class="form-group">
              <input name="budget_out_of_org" type="number" class="p-4 form-control" value="{{ $session->budget_out_of_org }}"/>
            </div>
 

               <label>القطاع :</label>
            <div class="form-group">
                <select name="sector" class="form-select">
                  <option value="القطاع الشرقي"  @selected($session->sector == 'القطاع الشرقي')>القطاع الشرقي</option>
                  <option value="القطاع الشمالي" @selected($session->sector == 'القطاع الشمالي')>القطاع الشمالي</option>
                  <option value="القطاع الغربي"  @selected($session->sector == 'القطاع الغربي')>القطاع الغربي</option>
                </select>
              </div>

              <label>المحلية: </label>
              <div class="form-group">
                <select name="locality" class="form-select">
                  @foreach(['كسلا','خشم القربة','همشكوريب','تلكوك وتوايت','شمال الدلتا','اروما','ريفي كسلا','غرب كسلا','محلية المصنع محطة ود الحليو','نهر عطبرة','غرب كسلا','حلفا الجديدة'] as $locality)
                    <option value="{{ $locality }}" @selected($session->locality == $locality)>{{ $locality }}</option>
                    @endforeach
                  </select>
              </div>

                         
            <label>ملاحظات: </label>
            <textarea name="notes" class="form-control w-100">{{ $session->notes }}</textarea>

            <button type="submit" class="btn btn-success py-2 mt-3">
              تعديل
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{ route('tazkiia.sessions.index') }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')