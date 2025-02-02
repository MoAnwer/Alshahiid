@include('components.header', ['page_title' => "المعسكرات التربوية"])

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
              <a href="{{ route('tazkiia.index') }}">التزكية الروحية </a>
            /

            </li>
            <li  class="mr-1 breadcrumb-item active">المعسكرات التربوية</li>
          </ol>
        </nav>
        <hr>

        <div class="d-flex justify-content-between align-items-center px-3">
          <h4> المعسكرات التربوية</h4>
          <a class="btn btn-primary active" href="{{ route('tazkiia.camps.create') }}">اضافة معسكر جديد</a>
        </div>
       <hr>

        <x-table>
          <x-slot:head>
			        <th>#</th>
              <th>اسم المعسكر</th>
              <th>تاريخ البداية</th>
              <th>تاريخ النهاية</th>
              <th>الحالة</th>
              <th>التقديري</th>
              <th>من داخل المنظمة</th>
              <th>من خارج المنظمة </th>
			        <th>ملاحظات</th>
			        <th>عمليات</th>
          </x-slot:head>

        <x-slot:body>
		      @if($camps->isNotEmpty())
			     @foreach($camps as $camp)
              <tr>
			          <td>{{ $camp->id }}</td>
                <td>{{ $camp->name }}</td>
                <td>{{ $camp->start_at }}</td>
                <td>{{ $camp->end_at }}</td>
                <td>{{ $camp->status }}</td>
				        <td>{{ number_format($camp->budget ?? 0) }}</td>
                <td>{{ number_format($camp->budget_from_org ?? 0) }}</td>
                <td>{{ number_format( $camp->budget_out_of_org ?? 0) }}</td>
                <td>{{ $camp->notes }}</td>
				        <td>
                    <a href="{{ route('tazkiia.camps.edit', $camp->id)}}" class="btn btn-success p-2 fs-sm">
                      <i class="fa fa-edit"></i>
                    </a>
                    <a href="{{ route('tazkiia.camps.delete', $camp->id)}}" class="btn btn-danger p-2 fs-sm">
                      <i class="fa fa-trash"></i>
                    </a>
                  </td>
              </tr>
			      @endforeach
		        @else
			        <tr><td colspan="9">لا توجد حلقات </td></tr>
        		@endif
          </x-slot:body>
        </x-table>

        {{ $camps->links('vendor.pagination.bootstrap-5') }}
		
        </div>
      </div>
    </div>

  @include('components.footer')