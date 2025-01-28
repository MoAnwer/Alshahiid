@include('components.header', ['page_title' => 'اضافة مشروع سكن'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h4>مشروع  سكن جديد لاسرة الشهيد {{  $family->martyr->name }} </h4>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
		
        <x-alert />
		
        <form action="{{ route('homes.store', $family->id) }}" method="POST">
          @csrf
            <div class="form-group">
              <input type="text" class="p-4 form-control" name="manager_name" placeholder="اسم مدير المشروع">
            </div>
            
            <div class="form-group">
              <select name="type" class="form-select">
                <option value="تشييد">تشييد</option>
                <option value="اكمال التشييد">اكمال التشييد</option>
              </select>
            </div>

            <div class="form-group">
              <select name="status" class="form-select">
                <option value="مطلوب">مطلوب</option>
                <option value="منفذ">منفذ</option>
              </select>
            </div>

            <div class="form-group">
              <input name="budget" type="number" class="p-4 form-control" placeholder="ميزانية المشروع" value="{{ old('budget') }}"/>
            </div>

            <div class="form-group">
              <input name="budget_from_org" type="number" class="p-4 form-control" placeholder="المبلغ المقدم من داخل المنظمة" value="{{ old('budget_from_org') }}"/>
            </div>

            <div class="form-group">
              <input name="budget_out_of_org" type="number" class="p-4 form-control" placeholder="المبلغ المقدم من خارج المنظمة" value="{{ old('budget_out_of_org') }}"/>
            </div>
            
            <label>ملاحظات: </label>
            <textarea name="notes" class="form-control w-100"></textarea>

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