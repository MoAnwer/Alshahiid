@include('components.header', ['page_title' => 'تعديل كفالة'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h3>تعديل كفالة لاسرة الشهيد {{  $bail->family->martyr->name }} </h3>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
		
        <x-alert />
		
        <form action="{{ route('bails.update', $bail->id) }}" method="POST">
          @csrf
          @method('PUT')

          <label>نوع الكفالة</label>
          <div class="form-group">
            <select name="type" class="form-select">
              @foreach (['مجتمعية','مؤسسية','المنظمة'] as $type)
                <option value="{{ $type }}" @selected($type == $bail->type)>{{ $type }}</option>
              @endforeach
            </select>
          </div>

          <label>الجهة المسؤلة من تقديم الكفالة</label>
          <div class="form-group">
            <select name="provider" class="form-select">
              @foreach (['الحكومة','ديوان الزكاة','دعم شعبي','ايرادات المنظمة'] as $provider)
                <option value="{{ $provider }}" @selected($provider == $bail->provider)>{{ $provider }}</option>
              @endforeach
            </select>
          </div>

          
          <label>الحالة</label>
            <div class="form-group">
              <select name="status" class="form-select">
                <option value="مطلوب" @selected($bail->status == 'مطلوب')>مطلوب</option>
                <option value="منفذ" @selected($bail->status == 'منفذ')>منفذ</option>
              </select>
            </div>


          <div class="form-group">
            <input name="budget" type="number" class="p-4 form-control" placeholder="المبلغ"  value="{{ $bail->budget }}">
          </div>

          <div class="form-group">
            <input name="budget_from_org" type="number" class="p-4 form-control" placeholder="المبلغ المقدم من داخل المنظمة" value="{{  $bail->budget_from_org }}"/>
          </div>

          <div class="form-group">
            <input name="budget_out_of_org" type="number" class="p-4 form-control" placeholder="المبلغ المقدم من خارج المنظمة" value="{{  $bail->budget_out_of_org }}"/>
          </div>

          <label>ملاحظات:</label>
          <textarea name="notes" class="form-control w-100">{{ $bail->notes }}</textarea>


          <button type="submit" class="btn btn-success py-2 mt-3">تعديل</button>
            <a class="btn btn-info py-2 mt-3" href="{{ route('families.bails', $bail->family->id) }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')