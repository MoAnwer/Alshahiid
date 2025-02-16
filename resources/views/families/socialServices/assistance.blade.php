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
              المساعدات
            </li>
          </ol>
        </nav>
        <hr>


        
        {{-- Assistances --}}

        <div class="d-flex justify-content-between align-items-center px-3">
          <h4>المساعدات</h4>
          <a class="btn btn-primary active" href="{{ route('assistances.create', $family_with_martyr[0]->id) }}">اضافة مساعدة جديد</a>
        </div>


        <hr>

         <x-table>
            <x-slot:head>
              <th>#</th>
              <th>النوع</th>
              <th>الحالة</th>
              <th>التقديري</th>
              <th>من  داخل المنظمة</th>
              <th>من  خارج المنظمة</th>
			        <th>المبلغ المؤمن</th>
              <th>تم الانشاء في</th>
              <th>ملاحظات</th>
              <th>عمليات</th>
            </x-slot:head>

            <x-slot:body>
			      @if($assistances->isNotEmpty())			
             @foreach($assistances as $assistance)
                <tr>
                  <td>{{ $assistance->id }}</td>
                  <td>{{ $assistance->type }}</td>
                  <td>{{ $assistance->status }}</td>
                  <td>{{ number_format($assistance->budget) }}</td>
                  <td>{{ number_format($assistance->budget_from_org) ?? '-' }}</td>
                  <td>{{ number_format($assistance->budget_out_of_org) ?? '-' }}</td>
				          <td>{{ number_format($assistance->budget_from_org + $assistance->budget_out_of_org) }}</td>
                  <td>{{ date('Y-m-d', strtotime($assistance->created_at)) }}</td>
                  <td>{{ $assistance->notes ?? 'لايوجد' }}</td>
                  <td>
                    <a href="{{ route('assistances.edit', ['id' => $assistance->id, 'family' => $assistance->family_id ] )}}" class="btn btn-success p-2 fa-sm">
                      <i class="bi bi-pen" title="تعديل"></i>
                    </a>
                    <a href="{{ route('assistances.delete', $assistance->id)}}" class="btn btn-danger p-2 fa-sm">
                      <i class="bi bi-trash-fill" title="حذف"></i>
                    </a>
                  </td>
                </tr>
              @endforeach
			       @else
				      <tr>
					       <td colspan="12">لا توجد مساعدات</td>
				      </tr>
			       @endif
            </x-slot:body>
          </x-table>


          {{ $assistances->withQueryString()->appends(['searching' => 1])->links('vendor.pagination.bootstrap-5') }}


        </div>

    </div>

  @include('components.footer')