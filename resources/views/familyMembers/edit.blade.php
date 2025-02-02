@include('components.header', ['page_title' => 'تعديل بيانات'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h4> تعديل بيانات {{ $familyMember->name}} </h4>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
        <x-alert />
        <form action="{{ route('familyMembers.update', $familyMember->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
            <div class="form-group">
            <span class="text-danger fs-5">*</span>
              <input type="text" class="p-4 form-control" name="name" placeholder="الاسم" value="{{ $familyMember->name }}">
            </div>

            <div class="form-group">
            <span class="text-danger fs-5">*</span>
              <input type="number" class="p-4 form-control" name="age" placeholder="العمر" value="{{ $familyMember->age }}">
            </div>
            
            <div class="form-group">
              <select name="gender" class="form-select">
                <option value="ذكر" @selected( $familyMember->gender == 'ذكر')>ذكر</option>
                <option value="أنثى" @selected( $familyMember->gender == 'أنثى')>أنثى</option>
              </select>
            </div>

            <div class="form-group">
              <select name="relation" class="form-select">
                <option value="ابن" @selected($familyMember->relation == 'ابن')>ابن</option>
                <option value="ابنة" @selected($familyMember->relation == 'ابنة')>ابنة</option>
                <option value="اخ" @selected($familyMember->relation == 'اخ')>اخ</option>
                <option value="اخت" @selected($familyMember->relation == 'اخت')>اخت</option>
                <option value="اب" @selected($familyMember->relation == 'اب')>اب</option>
                <option value="ام" @selected($familyMember->relation == 'ام')>ام</option>
                <option value="زوجة" @selected($familyMember->relation == 'زوجة')>زوجة</option>
              </select>
            </div>




            <label> <span class="text-danger fs-5">*</span> الرقم الوطني</label>
            <div class="form-group">
              <input name="national_number" type="number" class="p-4 form-control" placeholder="{{ $familyMember->national_number }}"/>
            </div>

            <div class="form-group">
              <input name="phone_number" type="text" class="p-4 form-control" placeholder="رقم الهاتف" value="{{ $familyMember->phone_number }}"/>
            </div>

            <label> <span class="text-danger fs-5">*</span> تاريخ الميلاد </label>
            <div class="form-group">
              <input name="birth_date" type="date" class="p-4 form-control" value="{{ $familyMember->birth_date }}"/>
            </div>

            
            
            <label>رقم بطاقة التأمين الصحي</label>
            <div class="form-group">
              <input name="health_insurance_number" type="number" class="p-4 form-control" 
              placeholder="{{$familyMember->health_insurance_number }}"/>
            </div>
            
            <label>تاريخ بداية التأمين الصحي</label>
            <div class="form-group">
              <input name="health_insurance_start_date" type="date" class="p-4 form-control" value="{{ $familyMember->health_insurance_start_date }}"/>
            </div>
            

            <label>تاريخ نهاية التأمين الصحي</label>
            <div class="form-group">
              <input name="health_insurance_end_date" type="date" class="p-4 form-control" value="{{ $familyMember->health_insurance_end_date }}"/>
            </div>

            <label>الصورة الشخصية</label>
            <div class="for-group">
              <input type="file" name="personal_image"  class="form-control"/>
            </div>

            <button type="submit" class="btn btn-success py-2 mt-3">
              <i class="fa fas-user-plus"></i>
              تعديل
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{route('families.show', $familyMember->family->id) }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')