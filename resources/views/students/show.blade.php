@include('components.header', ['page_title' => 'ملف '. $student->familyMember->name ])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      
      <div class="container-fluid mt-4">

        <x-alert/>

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
              <a href="{{ route('families.show', $student->familyMember->family->id) }}"> اسرة الشهيد {{ $student->familyMember->family->martyr->name}} </a>
            </li>
            <li class="breadcrumb-item">
              <a href="{{ route('familyMembers.show', $student->familyMember->id) }}"> {{ $student->familyMember->name }}  </a>
            </li>
            <li  class="breadcrumb-item active">ملف {{ $student->familyMember->name }} التعليمي</li>
          </ol>
        </nav>

        <hr>

        <div class="d-flex justify-content-between align-items-center px-3">
          <h4>ملف {{ $student->familyMember->name }} التعليمي </h4>
        </div>
       <hr>

       
       <x-table>
        <x-slot:head>
            <th>#</th>
            <th>المرحلة التعليمية</th>
            <th>الصف</th>
            <th>المدرسة</th>
            <th>عمليات</th>
        </x-slot:head>

      <x-slot:body>
      @empty(!$student)
        <tr>
          <td>{{ $student->id }}</td>
          <td>{{ $student->stage }}</td>
          <td>{{ $student->class }}</td>
          <td>{{ $student->school_name }}</td>
          <td>
              <a href="{{ route('students.edit', $student->id)}}" class="btn btn-success p-2 fs-sm">
                <i class="bi bi-pen" title="تعديل"></i>
              </a>
              <a href="{{ route('students.delete', $student->id)}}" class="btn btn-danger p-2 fs-sm">
                <i class="bi bi-trash-fill" title="حذف"></i>
              </a>
            </td>
        </tr>
        @endempty
        </x-slot:body>
      </x-table>


        <hr>

		    <div class="d-flex justify-content-between align-items-center px-3">
            <h5>الاعانات التعليمية</h5>
            <a class="btn btn-primary active" href="{{ route('educationServices.create', $student->id) }}">اضافة خدمة جديدة</a>
        </div>

        <x-table>
          <x-slot:head>
			        <th>#</th>
              <th>الخدمة</th>
              <th>الحالة</th>
              <th>التقديري</th>
              <th>من داخل المنظمة</th>
              <th>من خارج المنظمة </th>
			        <th>ملاحظات</th>
			        <th>عمليات</th>
          </x-slot:head>

        <x-slot:body>
		      @if($student->educationServices->isNotEmpty())
			     @foreach($student->loadMissing('educationServices')->educationServices as $service)
              <tr>
			          <td>{{ $service->id }}</td>
                <td>{{ $service->type }}</td>
                <td>{{ $service->status }}</td>
				        <td>{{ number_format($service->budget ?? 0) }}</td>
                <td>{{ number_format($service->budget_from_org ?? 0) }}</td>
                <td>{{ number_format($service->budget_out_of_org ?? 0) }}</td>
                <td>{{ $service->notes }}</td>
				        <td>
                    <a href="{{ route('educationServices.edit', $service->id)}}" class="btn btn-success p-2 fs-sm">
                      <i class="bi bi-pen" title="تعديل"></i>
                    </a>
                    <a href="{{ route('educationServices.delete', $service->id)}}" class="btn btn-danger p-2 fs-sm">
                      <i class="bi bi-trash-fill" title="حذف"></i>
                    </a>
                  </td>
              </tr>
			     @endforeach
		        @else
			       <tr><td colspan="8">لا توجد خدمات تعليمية</td></tr>
        		@endif
          </x-slot:body>
        </x-table>

        </div>
      </div>
    </div>

  @include('components.footer')