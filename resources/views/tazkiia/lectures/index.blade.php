@include('components.header', ['page_title' => "ندوات و محاضرات"])

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
            <li  class="mr-1 breadcrumb-item active">الندوات و المحاضرات </li>
          </ol>
        </nav>


        <div class="d-flex justify-content-between align-items-center px-3">
          <h4> ندوات و محاضرات </h4>
          <a class="btn btn-primary active" href="{{ route('tazkiia.lectures.create') }}">اضافة محاضرة جديدة</a>
        </div>
       <hr>

        <x-table>
          <x-slot:head>
			        <th>#</th>
              <th>اسم المحاضرة</th>
              <th>تاريخ المحاضرة</th>
              <th>الحالة</th>
              <th>التقديري</th>
              <th>من داخل المنظمة</th>
              <th>من خارج المنظمة </th>
			        <th>ملاحظات</th>
			        <th>عمليات</th>
          </x-slot:head>

        <x-slot:body>
		      @if($lectures->isNotEmpty())
			     @foreach($lectures as $lecture)
              <tr>
			          <td>{{ $lecture->id }}</td>
                <td>{{ $lecture->name }}</td>
                <td>{{ $lecture->date }}</td>
                <td>{{ $lecture->status }}</td>
				        <td>{{ number_format($lecture->budget ?? 0) }}</td>
                <td>{{ number_format($lecture->budget_from_org ?? 0) }}</td>
                <td>{{ number_format( $lecture->budget_out_of_org ?? 0) }}</td>
                <td>{{ $lecture->notes }}</td>
				        <td>
                    <a href="{{ route('tazkiia.lectures.edit', $lecture->id)}}" class="btn btn-success p-2 fs-sm">
                      <i class="fa fa-edit"></i>
                    </a>
                    <a href="{{ route('tazkiia.lectures.delete', $lecture->id)}}" class="btn btn-danger p-2 fs-sm">
                      <i class="fa fa-trash"></i>
                    </a>
                  </td>
              </tr>
			      @endforeach
		        @else
			        <tr><td colspan="9">لا توجد ندوات و محاضرات </td></tr>
        		@endif
          </x-slot:body>
        </x-table>

        {{ $lectures->links('vendor.pagination.bootstrap-5') }}
		
        </div>
      </div>
    </div>

  @include('components.footer')