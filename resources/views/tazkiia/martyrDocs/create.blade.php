@include('components.header', ['page_title' => 'اضافة سيرة ذاتية للشهيد ' .  $martyr->name ])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h4> اضافة سيرة ذاتية للشهيد {{ $martyr->name }} </h4>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
		
        <x-alert />
        <form action="{{ route('tazkiia.martyrDocs.store', $martyr->id) }}" method="POST" enctype="multipart/form-data">
          @csrf

          	<label>الحالة</label>
            <div class="form-group">
              <select name="status" class="form-select">
                <option value="مطلوب">مطلوب</option>
                <option value="منفذ">منفذ</option>
              </select>
            </div>

            <div class="form-group">
            <span class="text-danger fs-5">*</span>
              <input name="budget" type="number" class="p-4 form-control" placeholder="المبلغ التقديري" value="{{ old('budget') }}"/>
            </div>

            <div class="form-group">
              <input name="budget_from_org" type="number" class="p-4 form-control" placeholder="المبلغ المقدم من داخل المنظمة" value="{{ old('budget_from_org') }}"/>
            </div>

            <div class="form-group">
              <input name="budget_out_of_org" type="number" class="p-4 form-control" placeholder="المبلغ المقدم من خارج المنظمة" value="{{ old('budget_out_of_org') }}"/>
            </div>
            

            <label>ملف السيرة الذاتية</label>
            <div class="for-group">
              <input type="file" name="storage_path"  class="form-control" accept=".pdf"/>
            </div>

            <label>الملاحظات</label>
            <textarea name="notes" class="form-control"></textarea>

            <button type="submit" class="btn btn-success py-2 mt-3">
              <i class="fa fas-user-plus"></i>
              اضافة
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{  route('tazkiia.martyrDocs.index', $martyr->id) }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')