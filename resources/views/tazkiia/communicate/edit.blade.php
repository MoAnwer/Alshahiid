@include('components.header', ['page_title' => 'تعديل التواصل مع اسرة الشهيد ' . $com->family->martyr->name])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h4> تعديل التواصل مع اسرة الشهيد   {{ $com->family->martyr->name }}</h4>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
		
        <x-alert />
		
        <form action="{{ route('tazkiia.communicate.update', $com->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="form-group">
          <span class="text-danger fs-5">*</span>
            <input name="phone" type="text" class="p-4 form-control" placeholder="رقم التلفون" value="{{ $com->phone }}"/>
          </div>

		    	<label>الحالة</label>
            <div class="form-group">
              <select name="status" class="form-select">
                <option value="مطلوب" @selected($com->status == 'مطلوب')>مطلوب</option>
                <option value="منفذ" @selected($com->status == 'منفذ')>منفذ</option>
              </select>
            </div>
            
		    	  <label>حالة التواصل</label>
            <div class="form-group">
              <select name="isCom" class="form-select">
                <option value="تم" @selected($com->isCom == 'تم')>تم</option>
                <option value="لم يتم" @selected($com->isCom == 'لم يتم')>لم يتم</option>
              </select>
            </div>

            <div class="form-group">
              <label> <span class="text-danger fs-5">*</span> المبلغ</label>
              <input name="budget" type="number" class="p-4 form-control" placeholder="المبلغ" value="{{ $com->budget ?? 0 }}"/>
            </div>

            <div class="form-group">
              <label>المبلغ المقدم من داخل المنظمة</label>
              <input name="budget_from_org" type="number" class="p-4 form-control" placeholder="المبلغ المقدم من داخل المنظمة" value="{{ $com->budget_from_org }}"/>
            </div>

            <div class="form-group">
            <label>المبلغ المقدم من خارج المنظمة</label>
              <input name="budget_out_of_org" type="number" class="p-4 form-control" placeholder="المبلغ المقدم من خارج المنظمة" value="{{ $com->budget_out_of_org }}"/>
            </div>
            
            <label>ملاحظات: </label>
            <textarea name="notes" class="form-control w-100">{{ $com->notes }}</textarea>

            <button type="submit" class="btn btn-success py-2 mt-3">
              تعديل
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{ route('tazkiia.communicate.index') }}">رجوع</a>
        </form>
        
      </div>
      
    </div>

  </div>

  @include('components.footer')