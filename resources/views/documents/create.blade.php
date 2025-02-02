@include('components.header', ['page_title' => 'اضافة خطاب جديد'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h4>إضافة خطاب جديد الى اسرة الشهيد {{ $family->martyr->name }} </h4>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
		
        <x-alert />
        <form action="{{ route('documents.store', $family->id) }}" method="POST" enctype="multipart/form-data">
          @csrf

           <label>نوع الخطاب</label>
            <div class="form-group">
              <select name="type" class="form-select">
                <option value="اعلام شرعي">اعلام شرعي</option>
                <option value="تأكيد الاستشهاد">تأكيد الاستشهاد</option>
                <option value="التوكيل">التوكيل</option>
                <option value="عقد قطعة الارض">عقد قطعة الارض</option>
              </select>
            </div>

            <label>ملف الخطاب</label>
            <div class="for-group">
              <input type="file" name="storage_path"  class="form-control" accept=".pdf"/>
            </div>

            <label>الملاحظات</label>
            <textarea name="notes"  class="form-control"></textarea>

            <button type="submit" class="btn btn-success py-2 mt-3">
              <i class="fa fas-user-plus"></i>
              اضافة
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{  route('documents.show', $family->id) }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')