@include('components.header', ['page_title' => 'بيانات ' . $member->name])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">

        <x-alert/>

        <div class="d-flex justify-content-between align-items-center px-3">
          <h4>ملف {{ $member->name }}  </h4>
        </div>

	     <hr/>
       
        <x-table>
          <x-slot:head>
            <th>اسم</th>
            <th>النوع</th>
            <th>العمر</th>
            <th>العلاقة</th>
            <th>الصورة الشخصية</th>
            <th>رقم التأمين الصحي</th>
            <th>بداية التأمين الصحي</th>
            <th>نهاية التأمين الصحي</th>
            <th>رقم الهاتف</th>
            <th>الرقم الوطني</th>
            <th>عمليات</th>
          </x-slot:head>

          <x-slot:body>
              <tr>
                <td>{{ $member->name }}</td>
                <td>{{ $member->gender }}</td>
                <td>{{ $member->age }}</td>
                <td>{{ $member->relation }}</td>
                <td>
                  @if(!is_null($member->personal_image))
                  <a href="{{ url("uploads/images/{$member->personal_image}") }}">
                    <img src="{{ url("uploads/images/{$member->personal_image}") }}" width="50"/>
                  </a>
                  @else
                    -
                  @endif
                </td>
                <td>{{ $member->health_insurance_number }}</td>
                <td>{{ $member->health_insurance_start_date }}</td>
                <td>{{ $member->health_insurance_end_date }}</td>
                <td>{{ $member->phone_number }}</td>
                <td>{{ $member->national_number }}</td>
                <td>
                    <a href="{{ route('familyMembers.edit', ['family' => $member->family->id, 'member' => $member->id]) }}" class="btn btn-success p-2 fs-sm">
                      <i class="fa fa-edit"></i>
                    </a>
                    <a href="{{ route('familyMembers.delete', $member->id) }}" class="btn btn-danger p-2 fs-sm">
                      <i class="fa fa-trash"></i>
                    </a>
                  </td>
              </tr>
          </x-slot:body>
        </x-table>

        <hr>
        <div class="d-flex justify-content-between align-items-center px-3">
          <h5>خدمات العلاج الصحي</h5>
          <a class="btn btn-primary active" href="{{ route('medicalTreatment.create', $member->id) }}">اضافة خدمة جديدة</a>
        </div>

		    <x-table>
          <x-slot:head>
			        <th>#</th>
              <th>نوع الاعانة التعليمية</th>
              <th>الحالة</th>
              <th>التقديري</th>
              <th>من داخل المنظمة</th>
              <th>من خارج المنظمة </th>
			        <th>ملاحظات</th>
			        <th>عمليات</th>
          </x-slot:head>

        <x-slot:body>
		      @if($member->medicalTreatments->count() > 0)
			     @foreach($member->medicalTreatments as $medicalService)
              <tr>
			          <td>{{ $medicalService->id }}</td>
                <td>{{ $medicalService->type }}</td>
                <td>{{ $medicalService->status }}</td>
				        <td>{{ number_format($medicalService->budget ?? 0) }}</td>
                <td>{{ number_format($medicalService->budget_from_org ?? 0) }}</td>
                <td>{{ number_format( $medicalService->budget_out_of_org ?? 0) }}</td>
                <td>{{ $medicalService->notes }}</td>
				        <td>
                    <a href="{{ route('medicalTreatment.edit', $medicalService->id)}}" class="btn btn-success p-2 fs-sm">
                      <i class="fa fa-edit"></i>
                    </a>
                    <a href="{{ route('medicalTreatment.delete', $medicalService->id)}}" class="btn btn-danger p-2 fs-sm">
                      <i class="fa fa-trash"></i>
                    </a>
                  </td>
              </tr>
			    @endforeach
		      @else
			       <tr><td colspan="8">لا توجد خدمات صحية</td></tr>
        		@endif
          </x-slot:body>
        </x-table>
		
		
	     <hr>

        <div class="d-flex justify-content-between align-items-center px-3">
            <h5>الملف التعليمي {{ $member->name }}</h5>
        </div>

        <x-table>
          <x-slot:head>
              <th>#</th>
              <th>اسم المدرسة</th>
              <th>المرحلة التعليمية</th>
              <th>الصف</th>
              <th>عمليات</th>
          </x-slot:head>

        <x-slot:body>
        @empty(!$member->student)
          <tr>
            <td>{{ $member->student->id }}</td>
            <td>{{ $member->student->school_name }}</td>
            <td>{{ $member->student->stage }}</td>
            <td>{{ $member->student->class }}</td>
            <td>
                <a href="{{ route('students.show', $member->student->id)}}" class="btn btn-primary active p-2 fs-sm">
                  <i class="fa fa-user"></i>
                </a>
                <a href="{{ route('students.edit', $member->student->id)}}" class="btn btn-success p-2 fs-sm">
                  <i class="fa fa-edit"></i>
                </a>
                <a href="{{ route('students.delete', $member->student->id)}}" class="btn btn-danger p-2 fs-sm">
                  <i class="fa fa-trash"></i>
                </a>
              </td>
          </tr>
          @else
             <tr>
                <td colspan="5">
                  <a href="{{ route('students.create', $member->id) }}" class="btn btn-primary active">
                    <i class="fas fa-plus mx-2"></i>
                    اضافة البيانات التعليمية 
                  </a>
                </td>
              </tr>
            @endempty
          </x-slot:body>
        </x-table>

        

      @if($member->gender == 'أنثى')
      <hr>
        <div class="d-flex justify-content-between align-items-center px-3">
          <h5>اعانات زواج</h5>
          <a class="btn btn-primary active" href="{{ route('medicalTreatment.create', $member->id) }}">اضافة خدمة جديدة</a>
        </div>

        <x-table>
          <x-slot:head>
              <th>#</th>
              <th>نوع الاعانة التعليمية</th>
              <th>الحالة</th>
              <th>التقديري</th>
              <th>من داخل المنظمة</th>
              <th>من خارج المنظمة </th>
              <th>ملاحظات</th>
              <th>عمليات</th>
          </x-slot:head>

        <x-slot:body>
          @if($member->medicalTreatments->count() > 0)
           @foreach($member->medicalTreatments as $medicalService)
              <tr>
                <td>{{ $medicalService->id }}</td>
                <td>{{ $medicalService->type }}</td>
                <td>{{ $medicalService->status }}</td>
                <td>{{ number_format($medicalService->budget ?? 0) }}</td>
                <td>{{ number_format($medicalService->budget_from_org ?? 0) }}</td>
                <td>{{ number_format( $medicalService->budget_out_of_org ?? 0) }}</td>
                <td>{{ $medicalService->notes }}</td>
                <td>
                    <a href="{{ route('medicalTreatment.edit', $medicalService->id)}}" class="btn btn-success p-2 fs-sm">
                      <i class="fa fa-edit"></i>
                    </a>
                    <a href="{{ route('medicalTreatment.delete', $medicalService->id)}}" class="btn btn-danger p-2 fs-sm">
                      <i class="fa fa-trash"></i>
                    </a>
                  </td>
              </tr>
          @endforeach
          @else
             <tr><td colspan="8">لا توجد خدمات صحية</td></tr>
            @endif
          </x-slot:body>
        </x-table>
      @endif
		
        </div>
      </div>
    </div>

  @include('components.footer')