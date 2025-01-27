@include('components.header', ['page_title' => 'ملف مصاب'])

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
          <h4>ملف مصاب - {{ $injured->name }} </h4>
        </div>

		<hr />
        <x-table>
          <x-slot:head>
            <th>#</th>
            <th>اسم</th>
            <th>نوع الاصابة</th>
            <th>نسبة الاصابة</th>
            <th>تاريخ الاصابة</th>
            <th>ملاحظات</th>
            <th>عمليات</th>
          </x-slot:head>

        <x-slot:body>
              <tr>
				<td>{{ $injured->id}} </td>
				<td>{{ $injured->name }}</td>
				<td>{{ $injured->type }}</td>
				<td>{{ $injured->injured_percentage }}</td>
				<td>{{ $injured->injured_date }}</td>
				<td>{{ $injured->notes }}</td>
                <td>
                    <a href="{{ route('injureds.edit', $injured->id) }}" class="btn btn-success">
                      <i class="fa fa-edit"></i>
                    </a>
                    <a href="{{ route('injureds.delete', $injured->id) }}" class="btn btn-danger">
                      <i class="fa fa-trash"></i>
                    </a>
                  </td>
              </tr>
          </x-slot:body>
        </x-table>
		
		
		<hr />
		<div class="d-flex justify-content-between align-items-center px-3">
          <h4>الخدمات المقدمة للمصاب {{ $injured->name }} </h4>
		  <a class="btn btn-primary active" href="{{ route('injuredServices.create', $injured->id) }}">إضافة خدمة جديد</a>
        </div>
		
		<x-table>
          <x-slot:head>
            <th>#</th>
            <th>اسم الخدمة</th>
            <th>الحالة</th>
            <th>الوصف</th>
            <th>التقديري</th>
            <th>من داخل المنظمة</th>
			<th>من خارج المنظمة</th>
            <th>ملاحظات</th>
            <th>عمليات</th>
          </x-slot:head>

        <x-slot:body>
		@if($injured->injuredServices()->count() > 0)
			@foreach($injured->injuredServices as $injuredService)
			<tr>
				<td>{{ $injuredService->id}} </td>
				<td>{{ $injuredService->type }}</td>
				<td>{{ $injuredService->status }}</td>
				<td>{{ $injuredService->description }}</td>
				<td>{{ $injuredService->budget }}</td>
				<td>{{ $injuredService->budget_from_org }}</td>
				<td>{{ $injuredService->budget_out_of_org }}</td>
				<td>{{ $injuredService->notes }}</td>
				<td>
					<a href="{{ route('injuredServices.edit', $injuredService->id) }}" class="btn btn-success">
						<i class="fa fa-edit"></i>
					</a>
					<a href="{{ route('injuredServices.delete', $injuredService->id) }}" class="btn btn-danger">
						<i class="fa fa-trash"></i>
					</a>
				</td>
			</tr>
			@endforeach
		@else
			<tr>
				<td colspan="9">لا توجد خدمات</td>
			</tr>
		@endif
          </x-slot:body>
        </x-table>

        </div>
      </div>
    </div>

  @include('components.footer')