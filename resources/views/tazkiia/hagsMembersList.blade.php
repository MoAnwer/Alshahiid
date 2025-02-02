@include('components.header', ['page_title' => "حج و عمرة"])

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
            <li  class="mr-1 breadcrumb-item active">حج و عمرة</li>
          </ol>
        </nav>

        <hr>


        <div class="d-flex justify-content-between align-items-center px-3">
          <h4> حج و عمرة </h4>
        </div>
       <hr>

        <x-table>
          <x-slot:head>
			        <th>#</th>
              <th>اسم المستفيد</th>
              <th>نوع الخدمة</th>
              <th>الحالة</th>
              <th>التقديري</th>
              <th>من داخل المنظمة</th>
              <th>من خارج المنظمة </th>
			        <th>عمليات</th>
          </x-slot:head>

        <x-slot:body>
		      @if($hags->isNotEmpty())
			     @foreach($hags as $hag)
              <tr>
			          <td>{{ $hag->id }}</td>
                <td>{{ $hag->familyMember->name  }}</td>
                <td>{{ $hag->type }}</td>
                <td>{{ $hag->status ?? '' }}</td>
				        <td>{{ number_format($hag->budget ?? 0) }}</td>
                <td>{{ number_format($hag->budget_from_org ?? 0) }}</td>
                <td>{{ number_format( $hag->budget_out_of_org ?? 0) }}</td>
				        <td>
                 <a href="{{ route('tazkiia.hagAndOmmrah.edit', $hag->id)}}" class="btn btn-success p-2 fs-sm">
                    <i class="fa fa-edit"></i>
                  </a>
                  <a href="{{ route('tazkiia.hagAndOmmrah.delete', $hag->id)}}" class="btn btn-danger p-2 fs-sm">
                    <i class="fa fa-trash"></i>
                  </a>
                </td>
              </tr>
			      @endforeach
		        @else
			        <tr><td colspan="9">لا توجد سير </td></tr>
        		@endif
          </x-slot:body>
        </x-table>

        {{ $hags->links('vendor.pagination.bootstrap-5') }}
		
        </div>
      </div>
    </div>

  @include('components.footer')