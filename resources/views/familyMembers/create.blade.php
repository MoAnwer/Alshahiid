@include('components.header', ['page_title' => 'اضافة فرد جديد'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h4>إضافة فرد جديد الى اسرة الشهيد{{ $family->martyr->name }} </h4>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
		
        <x-alert />
        <form action="{{ route('familyMembers.store', $family->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
            <div class="form-group">
            <span class="text-danger fs-5">*</span>
              <input type="text" class="p-4 form-control" name="name" placeholder="الاسم" value="{{ old('name') }}">
            </div>

            <div class="form-group">
            <span class="text-danger fs-5">*</span>
              <input type="number" class="p-4 form-control" name="age" placeholder="العمر" value="{{ old('age') }}">
            </div>
            
            <div class="form-group">
              <select name="gender" class="form-select">
                <option value="ذكر">ذكر</option>
                <option value="أنثى">أنثى</option>
              </select>
            </div>

            <div class="form-group">
              <select name="relation" class="form-select">
                <option value="ابن">ابن</option>
                <option value="ابنة">ابنة</option>
                <option value="اخ">اخ</option>
                <option value="اخت">اخت</option>
                <option value="اب">اب</option>
                <option value="ام">ام</option>
                <option value="زوجة">زوجة</option>
              </select>
            </div>

            <div class="form-group">
            <span class="text-danger fs-5">*</span>
              <input name="national_number" type="number" class="p-4 form-control" placeholder="الرقم الوطني" value="{{ old("national_number") }}"/>
            </div>

            <div class="form-group">
              <input name="phone_number" type="text" class="p-4 form-control" placeholder="رقم الهاتف" value="{{ old('phone_number') }}"/>
            </div>

            <label>تاريخ الميلاد <span class="text-danger fs-5">*</span></label>
            <div class="form-group">
              <input name="birth_date" type="date" class="p-4 form-control" value="{{ old("birth_date") }}"/>
            </div>
            
            <div class="form-group">
              <input name="health_insurance_number" type="number" class="p-4 form-control" placeholder="رقم بطاقة التأمين الصحي" value="{{ old('health_insurance_number') }}"/>
            </div>
            
            <label>تاريخ بداية التأمين الصحي</label>
            <div class="form-group">
              <input name="health_insurance_start_date" type="date" class="p-4 form-control" value="{{ old('health_insurance_start_date') }}"/>
            </div>
            

            <label>تاريخ نهاية التأمين الصحي</label>
            <div class="form-group">
              <input name="health_insurance_end_date" type="date" class="p-4 form-control" value="{{ old('health_insurance_end_date') }}"/>
            </div>

            <input name="family_id" type="hidden" value="{{ $family->id }}"/>

            <label>الصورة الشخصية</label>
            <div class="for-group">
              <input type="file" name="personal_image"  class="form-control"/>
            </div>

            <button type="submit" class="btn btn-success py-2 mt-3">
              <i class="fa fas-user-plus"></i>
              انشاء
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{  route('families.show', $family->id) }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')