@include('components.header', ['page_title' => 'قائمة مصابي العمليات'])

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
          <h4>قائمة مصابي العمليات</h4>
		  <a class="btn btn-primary active" href="{{ route('injureds.create') }}">إضافة مصاب جديد</a>
        </div>

		<hr />
        <x-table>
          <x-slot:head>
            <th>#</th>
            <th>اسم</th>
            <th>نوع الاصابة</th>
            <th>نسبة الاصابة</th>
            <th>رقم التأمين الصحي</th>
            <th>بداية التأمين الصحي</th>
            <th>نهاية التأمين الصحي</th>
            <th>تاريخ الاصابة</th>
            <th>ملاحظات</th>
            <th>عمليات</th>
          </x-slot:head>

        <x-slot:body>
		  @if($injureds->count() > 0)
			@foreach($injureds as $injured)
              <tr>
				<td>{{ $injured->id}} </td>
				<td>{{ $injured->name }}</td>
				<td>{{ $injured->type ?? '-' }}</td>
				<td>{{ round($injured->injured_percentage, 1) . '%' }}</td>
        <td>{{ $injured->health_insurance_number }}</td>
        <td>{{ $injured->health_insurance_start_date }}</td>
        <td>{{ $injured->health_insurance_end_date }}</td>
				<td>{{ $injured->injured_date  ?? '-' }}</td>
				<td>{{ $injured->notes }}</td>
                <td>
                    <a href="{{ route('injureds.edit', $injured->id) }}" class="btn btn-success">
                      <i class="fa fa-edit"></i>
                    </a>
                    <a href="{{ route('injureds.delete', $injured->id) }}" class="btn btn-danger">
                      <i class="fa fa-trash"></i>
                    </a>
					<a href="{{ route('injureds.show', $injured->id) }}" class="btn btn-primary active">
                      <i class="fa fa-user"></i>
                    </a>
                  </td>
              </tr>
			@endforeach
		@else
			<tr>
				<td colspan="7">لا يوجد مصابين</td>
			</tr>
		@endif
          </x-slot:body>
        </x-table>

        </div>
      </div>
    </div>

  @include('components.footer')