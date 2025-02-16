@include('components.header', ['page_title' => 'بيانات ' . $member->name])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      
      <div class="container-fluid mt-4">

        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style">
            <li class="breadcrumb-item">
              <a href="{{ route('home') }}">الرئيسية</a>
              /               
            </li>
            <li class="breadcrumb-item mx-1">
              <a href="{{ route('families.list') }}">قائمة اسر الشهداء</a>
            </li>
            <li class="breadcrumb-item ">
              <a href="{{ route('families.show', $member->family->id) }}"> اسرة الشهيد {{ $member->family->martyr->name}} </a>
              
            </li>
            <li  class="breadcrumb-item active">ملف {{ $member->name }} </li>
          </ol>
        </nav>

        <hr>

        <x-alert/>

        <div class="d-flex justify-content-between align-items-center px-3 mb-2">
          <div class="d-flex align-items-end gap-2">
            <div style="border-radius: 50%;">
              @if ($member->personal_image)
                <a href="{{ url("uploads/images/{$member->personal_image}") }}">
                  <img src="{{ url("uploads/images/{$member->personal_image}") }}" width="120"/>
                </a>
              @else 
                <img src="{{  url('asset/images/logo.jpg')  }}" width="80" class="mx-2"/>
              @endif
            </div>
            <h4>ملف {{ $member->name }}  </h4>
          </div>
        </div>

	     <hr/>
       
        <x-table>
          <x-slot:head>
            <th>اسم</th>
            <th>النوع</th>
            <th>العمر</th>
            <th>العلاقة</th>
            <th>الصورة الشخصية</th>
            <th>الرقم الوطني</th>
            <th>رقم التأمين الصحي</th>
            <th>بداية التأمين الصحي</th>
            <th>نهاية التأمين الصحي</th>
            <th>رقم الهاتف</th>
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
                <td>{{ $member->national_number }}</td>
                <td>{{ $member->health_insurance_number }}</td>
                <td>{{ $member->health_insurance_start_date }}</td>
                <td>{{ $member->health_insurance_end_date }}</td>
                <td>{{ $member->phone_number }}</td>
                <td>
                    <a href="{{ route('familyMembers.edit', $member->id) }}" class="btn btn-success p-2 fs-sm">
                      <i class="bi bi-pen" title="تعديل"></i>
                    </a>
                    <a href="{{ route('familyMembers.delete', $member->id) }}" class="btn btn-danger p-2 fs-sm">
                      <i class="bi bi-trash-fill" title="حذف"></i>
                    </a>
                  </td>
              </tr>
          </x-slot:body>
        </x-table>


        <hr>


          <div class="d-flex justify-content-between align-items-center px-3">
            <h5>الوثائق الخاصة بـ {{ $member->name }}</h5>
            <a class="btn btn-primary active" href="{{ route('familyMemberDocuments.create', $member->id) }}">اضافة وثيقة جديدة</a>
          </div>


          <x-table>
            <x-slot:head>
			        <th>#</th>
              <th>نوع الوثيقة</th>
              <th>رابط الوثيقة</th>
			        <th>ملاحظات</th>
			        <th>عمليات</th>
            </x-slot:head>

            <x-slot:body>
              @if($member->documents->isNotEmpty())
                @foreach($member->documents as $document)
                    <tr>
                      <td>{{ $document->id }}</td>
                      <td>{{ $document->type }}</td>
                      <td>
                        <a href="{{ asset('uploads/members_documents/'. $document->storage_path ) }}" class="text-primary" target="_blank">
                          <i class="bi bi-file-pdf fs-3"></i>
                        </a>
                      </td>
                      <td>{{ $document->notes  ?? 'لا يوجد'}}</td>
                      <td>
                          <a href="{{ route('familyMemberDocuments.edit', $document->id)}}" class="btn btn-success p-2 fs-sm">
                            <i class="bi bi-pen" title="تعديل"></i>
                          </a>
                          <a href="{{ route('familyMemberDocuments.delete', $document->id)}}" class="btn btn-danger p-2 fs-sm">
                            <i class="bi bi-trash-fill" title="حذف"></i>
                          </a>
                        </td>
                    </tr>
                @endforeach
                @else
                  <tr><td colspan="5">لا توجد  وثائق</td></tr>
                  @endif
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
              <th>نوع الخدمة الصحية </th>
              <th>الحالة</th>
              <th>التقديري</th>
              <th>من داخل المنظمة</th>
              <th>من خارج المنظمة </th>
			        <th>ملاحظات</th>
			        <th>عمليات</th>
          </x-slot:head>

        <x-slot:body>
		      @if($member->medicalTreatments->isNotEmpty())
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
                      <i class="bi bi-pen" title="تعديل"></i>
                    </a>
                    <a href="{{ route('medicalTreatment.delete', $medicalService->id)}}" class="btn btn-danger p-2 fs-sm">
                      <i class="bi bi-trash-fill" title="حذف"></i>
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
              <th>المرحلة التعليمية</th>
              <th>الصف</th>
              <th>المدرسة</th>
              <th>عمليات</th>
          </x-slot:head>

        <x-slot:body>
        @empty(!$member->student)
          <tr>
            <td>{{ $member->student->id }}</td>
            <td>{{ $member->student->stage }}</td>
            <td>{{ $member->student->class }}</td>
            <td>{{ $member->student->school_name }}</td>
            <td>
                <a href="{{ route('students.show', $member->student->id)}}" class="btn btn-primary active p-2 fs-sm">
                  <i class="bi bi-person-fill"></i>
                </a>
                <a href="{{ route('students.edit', $member->student->id)}}" class="btn btn-success p-2 fs-sm">
                  <i class="bi bi-pen" title="تعديل"></i>
                </a>
                <a href="{{ route('students.delete', $member->student->id)}}" class="btn btn-danger p-2 fs-sm">
                  <i class="bi bi-trash-fill" title="حذف"></i>
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

      @if($member->gender == 'أنثى'  || $member->relation == 'اخ')
      <hr>
        <div class="d-flex justify-content-between align-items-center px-3">
          <h5>اعانات زواج</h5>
          <a class="btn btn-primary active" href="{{ route('marryAssistances.create', $member->id) }}">اضافة خدمة جديدة</a>
        </div>

        <x-table>
          <x-slot:head>
              <th>#</th>
              <th>الحالة</th>
              <th>التقديري</th>
              <th>من داخل المنظمة</th>
              <th>من خارج المنظمة </th>
              <th>ملاحظات</th>
              <th>عمليات</th>
          </x-slot:head>

        <x-slot:body>
          @if($member->marryAssistances->isNotEmpty())
           @foreach($member->marryAssistances as $marryAssistance)
            <tr>
              <td>{{ $marryAssistance->id }}</td>
              <td>{{ $marryAssistance->status }}</td>
              <td>{{ number_format($marryAssistance->budget ?? 0) }}</td>
              <td>{{ number_format($marryAssistance->budget_from_org ?? 0) }}</td>
              <td>{{ number_format( $marryAssistance->budget_out_of_org ?? 0) }}</td>
              <td>{{ $marryAssistance->notes }}</td>
              <td>
                  <a href="{{ route('marryAssistances.edit', $marryAssistance->id)}}" class="btn btn-success p-2 fs-sm">
                    <i class="bi bi-pen" title="تعديل"></i>
                  </a>
                  <a href="{{ route('marryAssistances.delete', $marryAssistance->id)}}" class="btn btn-danger p-2 fs-sm">
                    <i class="bi bi-trash-fill" title="حذف"></i>
                  </a>
                </td>
            </tr>
            @endforeach
            @else
              <tr><td colspan="8">لا توجد اعانات زواج</td></tr>
              @endif
            </x-slot:body>
          </x-table>
          @endif
		


          
      <hr/>
      {{-- Hag --}}

      <div class="d-flex justify-content-between align-items-center px-3">
          <h5>خدمات حج و عمرة</h5>
          <a class="btn btn-primary active" href="{{ route('tazkiia.hagAndOmmrah.create', $member->id) }}"> اضافة خدمة حج و عمرة</a>
      </div>

      <x-table>
        <x-slot:head>
          <th>#</th>
          <th>النوع</th>
          <th>الحالة</th>
          <th>التقديري</th>
          <th>من  داخل المنظمة</th>
          <th>من  خارج المنظمة</th>
          <th>المبلغ المؤمن</th>
          <th>عمليات</th>
        </x-slot:head>

        <x-slot:body>
          @if ($member->hags->isNotEmpty())
            @foreach ($member->hags as $hag)
              <tr>
                <td>{{ $hag->id }}</td>
                <td>{{ $hag->type }}</td>
                <td>{{ $hag->status }}</td>
                <td>{{ number_format($hag->budget) }}</td>
                <td>{{ number_format($hag->budget_from_org) }}</td>
                <td>{{ number_format($hag->budget_out_of_org) }}</td>
                <td>{{ number_format($hag->budget_out_of_org  + $hag->budget_from_org) }}</td>
                <td>
                  <a href="{{ route('tazkiia.hagAndOmmrah.edit', $hag->id) }}" class="btn btn-success p-2 fa-sm">
                      <i class="bi bi-pen" title="تعديل"></i>
                  </a>
                  <a href="{{ route('tazkiia.hagAndOmmrah.delete', $hag->id) }}" class="btn btn-danger p-2 fa-sm">
                      <i class="bi bi-trash-fill" title="حذف"></i>
                  </a>
                </td>
              </tr>
            @endforeach
          @else
            <tr><td colspan="11">لا توجد خدمات حج و عمرة بعد</td></tr>
          @endif

        </x-slot:body>
      </x-table>
      </div>
      </div>
    </div>

  @include('components.footer')