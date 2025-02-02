@include('components.header', ['page_title' =>  'تعديل  خدمة حج و عمرة'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h3>تعديل  خدمة حج و عمرة لـ {{ $hag->familyMember->name }}</h3>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
        <x-alert />
        <form action="{{ route('tazkiia.hagAndOmmrah.update', $hag->id) }}" method="POST">
          @csrf
          @method('PUT')

            <label> نوع الخدمة </label>
            <div class="form-group">
              <select name="type" class="form-select">
                <option value="حج" @selected($hag->type == 'حج')>حج</option>
                <option value="عمرة" @selected($hag->type == 'عمرة')>عمرة</option>
              </select>
            </div>

            <label> الحالة </label>
            <div class="form-group">
              <select name="status" class="form-select">
                <option value="مطلوب" @selected($hag->status == 'مطلوب')>مطلوب</option>
                <option value="منفذ" @selected($hag->status == 'منفذ')>منفذ</option>
              </select>
            </div>

            <div class="form-group">
              <input name="budget" type="number" class="p-4 form-control" placeholder="المبلغ" value="{{ $hag->budget }}"/>
            </div>

            <div class="form-group">
              <input name="budget_from_org" type="number" class="p-4 form-control" placeholder="المبلغ المقدم من داخل المنظمة" value="{{ $hag->budget_from_org }}"/>
            </div>

            <div class="form-group">
              <input name="budget_out_of_org" type="number" class="p-4 form-control" placeholder="المبلغ المقدم من خارج المنظمة" value="{{ $hag->budget_out_of_org }}"/>
            </div>
            
            <button type="submit" class="btn btn-success py-2 mt-3">
              تعديل
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{ route('familyMembers.show', $hag->familyMember->id) }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')