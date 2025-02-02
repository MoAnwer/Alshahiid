@include('components.header', ['page_title' => "الحلقات"])

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
            <li  class="mr-1 breadcrumb-item active">الحلقات </li>
          </ol>
        </nav>


        <div class="d-flex justify-content-between align-items-center px-3">
          <h4> الحلقات </h4>
          <a class="btn btn-primary active" href="{{ route('tazkiia.sessions.create') }}">اضافة حلقة جديدة</a>
        </div>
       <hr>

        <x-table>
          <x-slot:head>
			        <th>#</th>
              <th>اسم الحلقة</th>
              <th>التاريخ</th>
              <th>الحالة</th>
              <th>التقديري</th>
              <th>من داخل المنظمة</th>
              <th>من خارج المنظمة </th>
			        <th>ملاحظات</th>
			        <th>عمليات</th>
          </x-slot:head>

        <x-slot:body>
		      @if($sessions->isNotEmpty())
			     @foreach($sessions as $session)
              <tr>
			          <td>{{ $session->id }}</td>
                <td>{{ $session->name }}</td>
                <td>{{ $session->date }}</td>
                <td>{{ $session->status }}</td>
				        <td>{{ number_format($session->budget ?? 0) }}</td>
                <td>{{ number_format($session->budget_from_org ?? 0) }}</td>
                <td>{{ number_format( $session->budget_out_of_org ?? 0) }}</td>
                <td>{{ $session->notes }}</td>
				        <td>
                    <a href="{{ route('tazkiia.sessions.edit', $session->id)}}" class="btn btn-success p-2 fs-sm">
                      <i class="fa fa-edit"></i>
                    </a>
                    <a href="{{ route('tazkiia.sessions.delete', $session->id)}}" class="btn btn-danger p-2 fs-sm">
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

        {{ $sessions->links('vendor.pagination.bootstrap-5') }}
		
        </div>
      </div>
    </div>

  @include('components.footer')