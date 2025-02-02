@include('components.header', ['page_title' => 'اضافة وثيقة جديدة'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h4>إضافة وثيقة جديدة الى  {{ $member->name }} </h4>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
		
        <x-alert />
        <form action="{{ route('familyMemberDocuments.store', $member->id) }}" method="POST" enctype="multipart/form-data">
          @csrf

           <label>نوع الوثيقة</label>
            <div class="form-group">
              <select name="type" class="form-select">
                <option value="شهادة ميلاد">شهادة ميلاد</option>
                <option value="شهادة مدرسية">شهادة مدرسية</option>
                <option value="رقم وطني">رقم وطني</option>
              </select>
            </div>

            <label>ملف الوثيقة</label>
            <div class="for-group">
              <input type="file" name="storage_path"  class="form-control mb-1" accept=".pdf"/>
            </div>

            <label>الملاحظات</label>
            <textarea name="notes"  class="form-control"></textarea>

            <button type="submit" class="btn btn-success py-2 mt-3">
              <i class="fa fas-user-plus"></i>
              اضافة
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{  route('familyMembers.show', $member->id) }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')