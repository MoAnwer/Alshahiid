@include('components.header', ['page_title' => 'بيانات اسرة  الشهيد'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h3> تعديل مشروع {{  $project->project_name }} </h3>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
    
        <x-alert />
    
        <form action="{{ route('projects.update', $project->id) }}" method="POST">
          @csrf
          @method('PUT')
            <div class="form-group">
            <label>اسم المشروع <span class="text-danger fs-5">*</span></label>
              <input type="text" class="p-4 form-control" name="project_name" value="{{ $project->project_name }}">
            </div>

            <div class="form-group">
            <label> اسم مدير المشروع<span class="text-danger fs-5">*</span></label>
              <input type="text" class="p-4 form-control" name="manager_name" placeholder="" value="{{ $project->manager_name }}">
            </div>
            
            <div class="form-group">
              <select name="project_type" class="form-select">
                <option value="فردي" @selected($project->project_type == 'فردي')>فردي</option>
                <option value="جماعي" @selected($project->project_type == 'جماعي')>جماعي</option>
              </select>
            </div>

            <div class="form-group">
              <select name="status" class="form-select">
                <option value="مطلوب" @selected($project->status == 'مطلوب')>مطلوب</option>
                <option value="منفذ" @selected($project->status == 'منفذ')>منفذ</option>
              </select>
            </div>

            <div class="form-group">
              <select name="work_status" class="form-select">
                <option value="يعمل" @selected($project->work_status == 'يعمل')>يعمل</option>
                <option value="لا يعمل"  @selected($project->work_status == 'لا يعمل')>لا يعمل</option>
              </select>
            </div>

            <label>ميزانية المشروع <span class="text-danger fs-5">*</span></label>
            <div class="form-group">
              <input name="budget" type="number" class="p-4 form-control" placeholder="ميزانية المشروع" value="{{ $project->budget }}"/>
            </div>

            <label>لمبلغ المقدم من داخل المنظمة</label>
            <div class="form-group">
              <input name="budget_from_org" type="number" class="p-4 form-control" placeholder="المبلغ المقدم من داخل المنظمة" value="{{ $project->budget_from_org }}"/>
            </div>

            <label>لمبلغ المقدم من خارج المنظمة </label>
            <div class="form-group">
              <input name="budget_out_of_org" type="number" class="p-4 form-control" placeholder="المبلغ المقدم من خارج المنظمة" value="{{ $project->budget_out_of_org }}"/>
            </div>


            <label>الدخل الشهري للمشروع</label>
            <div class="form-group">
              <input name="monthly_budget" type="number" class="p-4 form-control" 
              placeholder="الدخل الشهري للمشروع" value="{{ $project->monthly_budget }}"/>
            </div>

          <label>مصروفات المشروع</label>
            <div class="form-group">
              <input name="expense" type="number" class="p-4 form-control" 
              placeholder="مصروفات المشروع" value="{{ $project->expense }}"/>
            </div>
            
            <label>ملاحظات:</label>
            <textarea name="notes" class="form-control w-100">{{ $project->notes }}</textarea>

            <button type="submit" class="btn btn-success py-2 mt-3">
              تعديل
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{ route('families.socialServices', $project->family->id) }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')