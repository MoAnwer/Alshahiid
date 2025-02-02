@include('components.header', ['page_title' => 'مشروع جديد '])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h3>مشروع جديد لاسرة الشهيد {{  $family->martyr->name }} </h3>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
		
        <x-alert />
		
        <form action="{{ route('projects.store') }}" method="POST">
          @csrf
            <div class="form-group">
              <span class="text-danger">*</span>
              <input type="text" class="p-4 form-control" name="project_name" placeholder="اسم المشروع" value="{{ old('project_name') }}">
            </div>

            <div class="form-group">
              <span class="text-danger">*</span>
              <input type="text" class="p-4 form-control" name="manager_name" placeholder="اسم مدير المشروع" value="{{ old('manager_name') }}">
            </div>
            
            <label>النوع</label>
            <div class="form-group">
              <select name="project_type" class="form-select">
                <option value="فردي">فردي</option>
                <option value="جماعي">جماعي</option>
              </select>
            </div>

            <label>حالة التنفيذ</label>
            <div class="form-group">
              <select name="status" class="form-select">
                <option value="مطلوب">مطلوب</option>
                <option value="منفذ">منفذ</option>
              </select>
            </div>

            <label>الحالة التشغيلية</label>
            <div class="form-group">
              <select name="work_status" class="form-select">
                <option value="يعمل">يعمل</option>
                <option value="لا يعمل">لا يعمل</option>
              </select>
            </div>


            <div class="form-group">
              <span class="text-danger">*</span>
              <input name="budget" type="number" class="p-4 form-control" placeholder="ميزانية المشروع" value="{{ old('budget') }}"/>
            </div>

            <div class="form-group">
              <input name="budget_from_org" type="number" class="p-4 form-control" placeholder="المبلغ المقدم من داخل المنظمة" value="{{ old('budget_from_org') }}"/>
            </div>

            <div class="form-group">
              <input name="budget_out_of_org" type="number" class="p-4 form-control" placeholder="المبلغ المقدم من خارج المنظمة" value="{{ old('budget_out_of_org') }}"/>
            </div>
            

            <div class="form-group">
              <input name="monthly_budget" type="number" class="p-4 form-control" 
              placeholder="الدخل الشهري للمشروع" value="{{ old('monthly_budget') }}"/>
            </div>

            <div class="form-group">
              <input name="expense" type="number" class="p-4 form-control" 
              placeholder="مصروفات المشروع" value="{{ old('expense') }}"/>
            </div>

            <label>ملاحظات:</label>
            <textarea name="notes" class="form-control w-100">{{ old('notes') }}</textarea>

            <input name="family_id" type="hidden" value="{{ $family->id }}"/>

            <button type="submit" class="btn btn-success py-2 mt-3">
              انشاء
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{ route('families.socialServices', $family->id) }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')