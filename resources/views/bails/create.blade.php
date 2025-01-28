@include('components.header', ['page_title' => 'اضافة كفالة'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h3>اضافة كفالة لاسرة الشهيد {{  $family->martyr->name }} </h3>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
		
        <x-alert />
		
        <form action="{{ route('bails.store', $family->id) }}" method="POST">
          @csrf


          <label>نوع الكفالة</label>
          <div class="form-group">
            <select name="type" class="form-select">
              @foreach (['مجتمعية','مؤسسية','المنظمة'] as $type)
                <option value="{{ $type }}">{{ $type }}</option>
              @endforeach
            </select>
          </div>

          <label>الجهة المسؤلة من تقديم الكفالة</label>
          <div class="form-group">
            <select name="provider" class="form-select">
              @foreach (['الحكومة','ديوان الزكاة','دعم شعبي','ايرادات المنظمة'] as $provider)
                <option value="{{ $provider }}">{{ $provider }}</option>
              @endforeach
            </select>
          </div>

          <label>الحالة</label>
            <div class="form-group">
              <select name="status" class="form-select">
                <option value="مطلوب">مطلوب</option>
                <option value="منفذ">منفذ</option>
              </select>
            </div>


          <div class="form-group">
            <input name="budget" type="number" class="p-4 form-control" placeholder="المبلغ" value="{{ old('budget') }}">
          </div>

          <div class="form-group">
            <input name="budget_from_org" type="number" class="p-4 form-control" placeholder="المبلغ المقدم من داخل المنظمة" value="{{ old('budget_from_org') }}"/>
          </div>

          <div class="form-group">
            <input name="budget_out_of_org" type="number" class="p-4 form-control" placeholder="المبلغ المقدم من خارج المنظمة" value="{{ old('budget_out_of_org') }}"/>
          </div>

          <label>ملاحظات:</label>
          <textarea name="notes" class="form-control w-100">{{ old('notes') }}</textarea>

          <input name="family_id" type="hidden" value="{{ $family->id }}"/>

          <button type="submit" class="btn btn-success py-2 mt-3">انشاء</button>
            <a class="btn btn-info py-2 mt-3" href="{{ route('families.bails', $family->id) }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')