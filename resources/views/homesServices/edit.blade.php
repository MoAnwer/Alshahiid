@include('components.header', ['page_title' =>  'تعديل مشروع سكني'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h3>تعديل مشروع سكني لاسرة الشهيد {{ $home->family->martyr->name }}</h3>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
        <x-alert />
        <form action="{{ route('homes.update', ['family' => $home->family->id, 'home' => $home->id]) }}" method="POST">
          @csrf
          @method('PUT')
            <label> <span class="text-danger fs-5">*</span> اسم مدير المشروع</label>
            <div class="form-group">
              <input type="text" class="p-4 form-control" name="manager_name" placeholder="اسم مدير المشروع" value="{{ $home->manager_name }}">
            </div>
            
            <div class="form-group">
             <label>نوع المشروع</label>
              <select name="type" class="form-select">
                <option value="تشييد" @selected('تشييد' ==  $home->type)>تشييد</option>
                <option value="اكمال التشييد" @selected('اكمال التشييد'  ==  $home->type)>اكمال التشييد</option>
              </select>
            </div>

            <div class="form-group">
             <label>الحالة</label>
              <select name="status" class="form-select">
                <option value="مطلوب" @selected($home->status == 'مطلوب')>مطلوب</option>
                <option value="منفذ" @selected($home->status == 'منفذ')>منفذ</option>
              </select>
            </div>

            <div class="form-group">
              <label>المبلغ التقديري <span class="text-danger fs-5">*</span></label>
              <input name="budget" type="number" class="p-4 form-control" placeholder="المبلغ التقديري" value="{{ $home->budget }}"/>
            </div>

            <div class="form-group">
              <label> المبلغ المقدم من داخل المنظمة</label>
              <input name="budget_from_org" type="number" class="p-4 form-control" placeholder="المبلغ المقدم من داخل المنظمة" value="{{ $home->budget_from_org }}"/>
            </div>

            <label> المبلغ المقدم من خارج المنظمة</label>
            <div class="form-group">
              <input name="budget_out_of_org" type="number" class="p-4 form-control" placeholder="المبلغ المقدم من خارج المنظمة" value="{{ $home->budget_out_of_org }}"/>
            </div>
            
            <label>ملاحظات: </label>
            <textarea name="notes" class="form-control w-100">{{ $home->notes }}</textarea>

            <button type="submit" class="btn btn-success py-2 mt-3">
              تعديل
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{ route('families.socialServices', $home->family->id) }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')