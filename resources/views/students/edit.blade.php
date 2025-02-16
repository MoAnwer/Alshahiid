@include('components.header', ['page_title' => 'إنشاء ملف تعليمي'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h4>إنشاء ملف تعليمي  {{  $student->familyMember->name }} </h4>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
		
        <x-alert />
		
        <form action="{{ route('students.update', $student->id) }}" method="POST">
          @csrf
          @method('PUT')
		      <label>المرحلة</label>
            <div class="form-group">
              <select name="stage" class="form-select my-2">
			         @foreach(['جامعي', 'الإبتدائي', 'فوق الجامعي', 'الثانوي', 'المتوسط'] as $stage)
                <option value="{{ $stage }}" @selected( $student->stage  == $stage)>{{ $stage }}</option>
			         @endforeach
              </select>
              <label>الصف   <span class="text-danger fs-5">*</span></label>
              <input type="text" name="class" class="form-control py-4 mb-3" value="{{$student->class}}"/>
              <label>اسم المدرسة   <span class="text-danger fs-5">*</span></label>
              <input type="text" name="school_name" class="form-control py-4 mb-3" value="{{$student->school_name}}"/>
            </div>

            <button type="submit" class="btn btn-success py-2 mt-3">
              انشاء
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{ route('familyMembers.show', $student->familyMember->id) }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')