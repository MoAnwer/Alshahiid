@include('components.header', ['page_title' => 'اضافة خدمات تعليمية'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h4>إضافة خدمات تعليمية - {{  $student->familyMember->name }} </h4>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
		
        <x-alert />
		
        <form action="{{ route('educationServices.store', $student->id) }}" method="POST">
          @csrf
		  <label>نوع الخدمة</label>
            <div class="form-group">
              <select name="type" class="form-select">
			  @foreach(['زي و أدوات', 'رسوم دراسية', 'تأهيل مهني', 'تأهيل نسوي', 'تكريم متفوقين', 'دراسات عليا', 'إعانات طلاب', 'دورات رفع المستويات'] as $type)
                <option value="{{ $type }}">{{ $type }}</option>
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
              <input name="budget" type="number" class="p-4 form-control" placeholder="المبلغ" value="{{ old('budget') }}"/>
            </div>

            <div class="form-group">
              <input name="budget_from_org" type="number" class="p-4 form-control" placeholder="المبلغ المقدم من داخل المنظمة" value="{{ old('budget_from_org') }}"/>
            </div>

            <div class="form-group">
              <input name="budget_out_of_org" type="number" class="p-4 form-control" placeholder="المبلغ المقدم من خارج المنظمة" value="{{ old('budget_out_of_org') }}"/>
            </div>
            
            <label>ملاحظات: </label>
            <textarea name="notes" class="form-control w-100"></textarea>

            <button type="submit" class="btn btn-success py-2 mt-3">
              انشاء
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{ route('students.show', $student->id) }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')