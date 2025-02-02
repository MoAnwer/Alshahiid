@include('components.header', ['page_title' => 'تعديل خطاب '])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h4>تعديل خطاب  {{ $document->type }} </h4>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
		
        <x-alert />
        <form action="{{ route('documents.update', $document->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <br>

           <label>نوع الخطاب</label>
            <div class="form-group">
              <select name="type" class="form-select">
                <option value="اعلام شرعي" @selected($document->type == "اعلام شرعي")>اعلام شرعي</option>
                <option value="تأكيد الاستشهاد" @selected($document->type == "تأكيد الاستشهاد")>تأكيد الاستشهاد</option>
                <option value="التوكيل" @selected($document->type == "التوكيل")>التوكيل</option>
              </select>
            </div>
            <label>ملف الخطاب</label>
            <span>(دعه فارغ اذا لم ترغب يالتعديل عليه)</span>
            <div class="for-group">
              <input type="file" name="storage_path"  class="form-control" accept=".pdf"/>
            </div>

            <label>الملاحظات</label>
            <textarea name="notes"  class="form-control">{{ $document->notes }}</textarea>

            <button type="submit" class="btn btn-success py-2 mt-3">
              <i class="fa fas-user-plus"></i>
              تعديل
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{  route('documents.show', $document->family->id) }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')