@include('components.header', ['page_title' => 'بيانات ' . $student->familyMember->name])

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
          <h4>ملف {{ $student->familyMember->name }} التعليمي </h4>
        </div>
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
		      @if($student->educationServices->count() > 0)
			     @foreach($student->educationServices as $service)
              <tr>
			          <td>{{ $service->id }}</td>
                <td>{{ $service->type }}</td>
                <td>{{ $service->status }}</td>
				        <td>{{ number_format($service->budget ?? 0) }}</td>
                <td>{{ number_format($service->budget_from_org ?? 0) }}</td>
                <td>{{ number_format( $service->budget_out_of_org ?? 0) }}</td>
                <td>{{ $service->notes }}</td>
				        <td>
                    <a href="{{ route('educationServices.edit', $service->id)}}" class="btn btn-success p-2 fs-sm">
                      <i class="fa fa-edit"></i>
                    </a>
                    <a href="{{ route('educationServices.delete', $service->id)}}" class="btn btn-danger p-2 fs-sm">
                      <i class="fa fa-trash"></i>
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