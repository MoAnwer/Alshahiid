@include('components.header', ['page_title' => "توثيق سير الشهداء"])

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
            <li  class="mr-1 breadcrumb-item active">توثيق سير الشهداء</li>
          </ol>
        </nav>


        <div class="d-flex justify-content-between align-items-center px-3">
          <h4> توثيق سير الشهداء </h4>
        </div>
       <hr>

        <x-table>
          <x-slot:head>
			        <th>#</th>
              <th>الشهيد</th>
              <th>السيرة الذاتية</th>
              <th>الحالة</th>
              <th>التقديري</th>
              <th>من داخل المنظمة</th>
              <th>من خارج المنظمة </th>
			        <th>ملاحظات</th>
			        <th>عمليات</th>
          </x-slot:head>

        <x-slot:body>
		      @if($martyrs->isNotEmpty())
			     @foreach($martyrs as $martyr)
              <tr>
			          <td>{{ $martyr->id }}</td>
                <td>{{ $martyr->name }}</td>
                <td>
                @empty($martyr->martyrDoc)
                  -
                @else
                  <a href="{{ route('tazkiia.martyrDocs.index', $martyr->id) }}" class="btn btn-primary">عرض</a>
                @endempty
                </td>
                <td>{{ $martyr->martyrDoc->status ?? '' }}</td>
				        <td>{{ number_format($martyr->martyrDoc->budget ?? 0) }}</td>
                <td>{{ number_format($martyr->martyrDoc->budget_from_org ?? 0) }}</td>
                <td>{{ number_format( $martyr->martyrDoc->budget_out_of_org ?? 0) }}</td>
                <td>{{ $martyr->martyrDoc->notes ?? '-' }}</td>
				        <td>
                  @empty($martyr->martyrDoc)
                    <a href="{{ route('tazkiia.martyrDocs.create', $martyr->id) }}" class="btn btn-success">اضافة</a>
                  @else
                     <a href="{{ route('tazkiia.martyrDocs.edit', $martyr->martyrDoc->id)}}" class="btn btn-success p-2 fs-sm">
                      <i class="fa fa-edit"></i>
                    </a>
                    <a href="{{ route('tazkiia.martyrDocs.delete', $martyr->martyrDoc->id)}}" class="btn btn-danger p-2 fs-sm">
                      <i class="fa fa-trash"></i>
                    </a>
                  @endempty

                </td>
              </tr>
			      @endforeach
		        @else
			        <tr><td colspan="9">لا توجد سير </td></tr>
        		@endif
          </x-slot:body>
        </x-table>

        {{ $martyrs->links('vendor.pagination.bootstrap-5') }}
		
        </div>
      </div>
    </div>

  @include('components.footer')