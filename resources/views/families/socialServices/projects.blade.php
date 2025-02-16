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
                <a href="{{ route('home') }}">الرئيسية</a>
                /               
              </li>
              <li class="breadcrumb-item mx-1">
                <a href="{{ route('families.list') }}">قائمة اسر الشهداء</a>
              </li>

            <li class="breadcrumb-item  mx-1">
              <a href="{{ route('families.show', $family_with_martyr[0]->id) }}">اسرة الشهيد {{ @$family_with_martyr[0]['martyr']->name }}</a>            
            </li>
            <li class="breadcrumb-item" >
            
              <a href="{{ route('families.socialServices', $family_with_martyr[0]->id) }}">   الخدمات الاجتماعية </a>  
            </li>

            <li class="breadcrumb-item mx-1 active" >
              المشاريع
            </li>
          </ol>
        </nav>
        <hr>


        
        {{-- projects --}}

        <div class="d-flex justify-content-between align-items-center px-3">
          <h4>المشاريع</h4>
          <a class="btn btn-primary active" href="{{ route('projects.create', $family_with_martyr[0]->id) }}">اضافة مساعدة جديد</a>
        </div>


        <hr>
 
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
              <th>تم الانشاء في</th>
              <th>عمليات</th>
            </x-slot:head>

          <x-slot:body>
             @forelse($projects as $project)
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
                <td>{{ date('Y-m-d', strtotime($project->created_at)) }}</td>
                <td>
                  <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-success p-2 fa-sm">
                    <i class="bi bi-pen" title="تعديل"></i>
                  </a>
                  <a href="{{ route('projects.delete', $project->id) }}" class="btn btn-danger p-2 fa-sm">
                    <i class="bi bi-trash-fill" title="حذف"></i>
                  </a>
                  </td>
                </tr>
              @empty
			          <tr>
				           <td colspan="13">لا توجد مشاريع</td>
			          </tr>
              @endforelse

            </x-slot:body>
          </x-table>

          {{ $projects->withQueryString()->appends(['searching' => 1])->links('vendor.pagination.bootstrap-5') }}


        </div>

    </div>
  @include('components.footer')