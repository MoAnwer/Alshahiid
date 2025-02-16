@include('components.header', ['page_title' => 'تعديل بيانات المصاب'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h4>تعديل بيانات المصاب {{$injured->name}} </h4>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
		
        <x-alert />
		
        <form action="{{ route('injureds.update', $injured->id) }}" method="POST">
          @csrf
		        @method('PUT')
            <label><span class="text-danger fs-5">*</span>اسم المصاب</label>
            <div class="form-group">
              <input type="text" class="p-4 form-control" name="name" placeholder="اسم المصاب" value="{{ $injured->name }}" />
            </div>

           <label>القطاع :</label>
            <div class="form-group">
                <select name="sector" class="form-select">
                  <option value="القطاع الشرقي"  @selected($injured->sector == 'القطاع الشرقي')>القطاع الشرقي</option>
                  <option value="القطاع الشمالي" @selected($injured->sector == 'القطاع الشمالي')>القطاع الشمالي</option>
                  <option value="القطاع الغربي"  @selected($injured->sector == 'القطاع الغربي')>القطاع الغربي</option>
                </select>
              </div>

              <label>المحلية: </label>
              <div class="form-group">
                <select name="locality" class="form-select">
                  @foreach(['كسلا','خشم القربة','همشكوريب','تلكوك وتوايت','شمال الدلتا','اروما','ريفي كسلا','غرب كسلا','محلية المصنع محطة ود الحليو','نهر عطبرة','غرب كسلا','حلفا الجديدة'] as $locality)
                    <option value="{{ $locality }}" @selected($injured->locality == $locality)>{{ $locality }}</option>
                    @endforeach
                  </select>
              </div>

              <div class="form-group">
                <label>رقم الهاتف</label>
                <span class="text-danger fs-5">*</span>
              <input name="phone" type="text" class="p-4 form-control" placeholder="{{ $injured->phone }}" maxlength="15"/>
            </div>

             <div class="form-group">
              <label>الرقم الوطني</label>
               <span class="text-danger fs-5">*</span>
              <input name="national_number" type="number" class="p-4 form-control"  maxlength="20" placeholder="{{ $injured->national_number }}"/>
            </div>


            <label><span class="text-danger fs-5">*</span>نوع الاصابة</label>
            <div class="form-group">
              <input type="text" class="p-4 form-control" name="type"  placeholder="نوع الاصابة" max-length="2" value="{{ $injured->type }}"/>
            </div>
            
			<label>تاريخ الاصابة<span class="text-danger fs-5">*</span></label>
            <div class="form-group">
              <input  type="date" class="p-4 form-control" name="injured_date" value="{{ $injured->injured_date }}" />
            </div>

			<label>نسبة الاصابة<span class="text-danger fs-5">*</span></label>
            <div class="form-group">
              <input name="injured_percentage" type="number" class="p-4 form-control" value="{{ $injured->injured_percentage }}"/>
            </div>

            <label>رقم بطاقة التأمين الصحي</label>
            <div class="form-group">
              <input name="health_insurance_number" type="number" class="p-4 form-control" 
              placeholder="{{$injured->health_insurance_number}}" value="{{ old('health_insurance_number') }}"/>
            </div>
            
            <label>تاريخ بداية التأمين الصحي</label>
            <div class="form-group">
              <input name="health_insurance_start_date" type="date" class="p-4 form-control" value="{{  $injured->health_insurance_start_date }}"/>
            </div>
            

            <label>تاريخ نهاية التأمين الصحي</label>
            <div class="form-group">
              <input name="health_insurance_end_date" type="date" class="p-4 form-control" value="{{  $injured->health_insurance_end_date }}"/>
            </div>

            
            <label>ملاحظات: </label>
            <textarea name="notes" class="form-control w-100">{{ $injured->notes }}</textarea>

            <button type="submit" class="btn btn-success py-2 mt-3">
              تعديل
            </button>
            <a class="btn btn-info py-2 mt-3" href="{{ route('injureds.index') }}">رجوع</a>
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')