@include('components.header', ['page_title' => 'تعديل خدمة علاجية'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">
        <h3>تعديل خدمة علاجية لـ{{ $medicalTreatment->familyMember->name }}</h3>
        <hr />
        
        @if($errors->any())
          @foreach($errors->all() as $error)
            <div class="alert alert-danger"> {{ $error }} </div>
          @endforeach
        @endif
		
        <x-alert />
		
        <form action="{{ route('medicalTreatment.update', $medicalTreatment->id) }}" method="POST">
          @csrf            
		  @method('PUT')
			<label>نوع الخدمة العلاجية</label>
            <div class="form-group">
              <select name="type" class="form-select">
				<option value="{{ $medicalTreatment->type }}">{{ $medicalTreatment->type }}</option>
                <option value="التأمين الصحي">التأمين الصحي</option>
                <option value="علاج خارج المظلة">علاج خارج المظلة</option>
                <option value="علاج بالخارج">علاج بالخارج</option>
              </select>
            </div>
			
			<label>حالة الخدمة</label>
            <div class="form-group">
              <select name="status" class="form-select">
				<option value="{{ $medicalTreatment->status }}">{{ $medicalTreatment->status }}</option>
                <option value="مطلوب">مطلوب</option>
                <option value="منفذ">منفذ</option>
              </select>
            </div>
			

            <div class="form-group">
              <input name="budget" type="number" class="p-4 form-control" placeholder="المبلغ المطلوب" value="{{ $medicalTreatment->budget }}"/>
            </div>

            <div class="form-group">
              <input name="budget_from_org" type="number" class="p-4 form-control" placeholder="المبلغ المقدم من داخل المنظمة" value="{{ $medicalTreatment->budget_from_org }}"/>
            </div>

            <div class="form-group">
              <input name="budget_out_of_org" type="number" class="p-4 form-control" placeholder="المبلغ المقدم من خارج المنظمة" value="{{ $medicalTreatment->budget_out_of_org }}"/>
            </div>
            
            <label>ملاحظات</label>
            <textarea name="notes" class="form-control">{{ $medicalTreatment->notes }}</textarea>


            <button type="submit" class="btn btn-success py-2 mt-3">
              تعديل
            </button>
			
            <a class="btn btn-info py-2 mt-3" href="{{ route('familyMembers.show', $medicalTreatment->familyMember->id) }}">رجوع</a>
			
        </form>
      </div>
      
    </div>

  </div>

  @include('components.footer')