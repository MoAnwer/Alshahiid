@include('components.header', ['page_title' => 'الخدمات الاجتماعية'])

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
              <a href="{{ route('martyrs.index') }}">الشهداء</a>
              /               
            </li>
            <li class="breadcrumb-item  mx-1">
              <a href="{{ route('families.show', $family->id) }}">اسرة الشهيد {{ $family->martyr->name}}</a>            
            </li>
            <li class="breadcrumb-item active" >
              الخدمات الاجتماعية 
            </li>
          </ol>
        </nav>

        <x-alert/>

        <!-- Services -->
        <hr/>

        <h3>الخدمات الاجتماعية</h3>
        <hr/>

        {{-- Assistances --}}

        <div class="d-flex justify-content-between align-items-center px-3">
          <h5>المساعدات</h5>
          <a class="btn btn-primary active" href="{{ route('assistances.create', $family->id) }}">اضافة مساعدة جديد</a>
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
              <th>ملاحظات</th>
              <th>عمليات</th>
            </x-slot:head>

            <x-slot:body>
			      @if($family->assistances->isNotEmpty())			
             @foreach($family->loadMissing('assistances')->assistances as $assistance)
                <tr>
                  <td>{{ $assistance->id }}</td>
                  <td>{{ $assistance->type }}</td>
                  <td>{{ $assistance->status }}</td>
                  <td>{{ number_format($assistance->budget) }}</td>
                  <td>{{ number_format($assistance->budget_from_org) ?? '-' }}</td>
                  <td>{{ number_format($assistance->budget_out_of_org) ?? '-' }}</td>
				          <td>{{ number_format($assistance->budget_from_org + $assistance->budget_out_of_org) }}</td>
                  <td>{{ $assistance->notes ?? 'لايوجد' }}</td>
                  <td>
                    <a href="{{ route('assistances.edit', ['family' => $family->id, 'id' => $assistance->id])}}" class="btn btn-success p-2 fa-sm">
                      <i class="fa fa-edit"></i>
                    </a>
                    <a href="{{ route('assistances.delete', $assistance->id)}}" class="btn btn-danger p-2 fa-sm">
                      <i class="fa fa-trash"></i>
                    </a>
                  </td>
                </tr>
              @endforeach
			       @else
				      <tr>
					       <td colspan="11">لا توجد مساعدات</td>
				      </tr>
			       @endif
            </x-slot:body>
          </x-table>

          <hr>

        {{-- / Assistances --}}


          <!-- Porjects -->
          <div class="d-flex justify-content-between align-items-center px-3">
            <h5>المشاريع </h5>
            <a class="btn btn-primary active" href="{{ route('projects.create', $family->id) }}">اضافة مشروع جديد</a>
          </div>
          
          <x-table>
            <x-slot:head>
              <th>#</th>
              <th>اسم المشروع</th>
              <th>النوع</th>
              <th>الحالة</th>
              <th>الحالة التشغيلية</th>
              <th>التقديري</th>
              <th>المدير</th>
              <th>من  داخل المنظمة</th>
              <th>من  خارج المنظمة</th>
              <th>الدخل الشهري</th>
              <th>المصروفات</th>
              <th>عمليات</th>
            </x-slot:head>

          <x-slot:body>
			     @if($family->projects->isNotEmpty())
             @foreach($family->loadMissing('projects')->projects as $project)
              <tr>
                <td>{{ $project->id }}</td>
                <td>{{ $project->project_name }}</td>
                <td>{{ $project->project_type }}</td>
                <td>{{ $project->status }}</td>
                <td>{{ $project->work_status }}</td>
                <td>{{ number_format($project->budget) }}</td>
                <td>{{ !empty($project->manager_name) ? $project->manager_name : '-' }}</td>
                <td>{{ number_format($project->budget_from_org) ?? '-' }}</td>
                <td>{{ number_format($project->budget_out_of_org ) ?? '-' }}</td>
                <td>{{ number_format($project->monthly_budget) }}</td>
                <td>{{ number_format($project->expense) }}</td>
                <td>
                  <a href="{{ route('projects.edit', ['family' => $family->id, 'project' => $project->id]) }}" class="btn btn-success p-2 fa-sm">
                    <i class="fa fa-edit"></i>
                  </a>
                  <a href="{{ route('projects.delete', $project->id) }}" class="btn btn-danger p-2 fa-sm">
                    <i class="fa fa-trash"></i>
                  </a>
                  </td>
                </tr>
              @endforeach
			         @else
			          <tr>
				           <td colspan="12">لا توجد مشاريع</td>
			          </tr>
			       @endif
            </x-slot:body>
          </x-table>
          <hr>

        <!--/ Porjects -->

        <!-- Homes -->
		
  		<div class="d-flex justify-content-between align-items-center px-3">
        <h5>مشاريع السكن</h5>
          <a class="btn btn-primary active" href="{{ route('homes.create', $family->id) }}">اضافة مشروع جديد</a>
        </div>

         <x-table>
            <x-slot:head>
              <th>#</th>
              <th>النوع</th>
              <th>الحالة</th>
			        <th>المدير</th>
              <th>التقديري</th>
              <th>من  داخل المنظمة</th>
              <th>من  خارج المنظمة</th>
			        <th>المبلغ المؤمن</th>
              <th>ملاحظات</th>
              <th>عمليات</th>
            </x-slot:head>

          <x-slot:body>
			     @if($family->homeServices->isNotEmpty())			
              @foreach($family->loadMissing('homeServices')->homeServices as $homeService)
                <tr>
                  <td>{{ $homeService->id }}</td>
                  <td>{{ $homeService->type }}</td>
                  <td>{{ $homeService->status }}</td>
				          <td>{{ $homeService->manager_name }}</td>
                  <td>{{ number_format($homeService->budget) }}</td>
                  <td>{{ number_format($homeService->budget_from_org) ?? '-' }}</td>
                  <td>{{ number_format($homeService->budget_out_of_org) ?? '-' }}</td>
				          <td>{{ number_format($homeService->budget_from_org + $homeService->budget_out_of_org) }}</td>
                  <td>{{ $homeService->notes ?? 'لايوجد' }}</td>
                  <td>
                    <a href="{{ route('homes.edit', $homeService->id)}}" class="btn btn-success p-2 fa-sm">
                      <i class="fa fa-edit"></i>
                    </a>
                    <a href="{{ route('homes.delete',  ['home' => $homeService->id])}}" class="btn btn-danger p-2 fa-sm">
                      <i class="fa fa-trash"></i>
                    </a>
                  </td>
                </tr>
              @endforeach
			       @else
				      <tr>
					      <td colspan="10">لا توجد مشاريع السكن</td>
				      </tr>
			       @endif
            </x-slot:body>
          </x-table>
        <!--/ Homes -->

        </div>
      </div>
    </div>

  @include('components.footer')