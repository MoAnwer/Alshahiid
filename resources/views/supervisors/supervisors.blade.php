@include('components.header', ['page_title' => 'مشرفي الاسر'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center pl-3">
          <h3>مشرفي الاسر</h3>
          <a class="btn btn-primary active" href="{{ route('supervisors.create')}}" >
            <i class="fas fa-plus ml-2"></i>
            اضافة مشرف
          </a>
        </div>

        <x-alert />

        <x-table>
          <x-slot:head>
            <th>اسم المشرف</th>
            <th>رقم الهاتف</th>
            <th>عدد الاسر المشرف عليها</th>
            <th>قائمة الاسر</th>
            <th>عمليات</th>
          </x-slot:head>

        <x-slot:body>
          @if ($supervisors->count() > 0)              
            @foreach ($supervisors as $supervisor)
              <tr>
                <td>{{ $supervisor->name }}</td>
                <td>{{ $supervisor->phone }}</td>
                <td>{{ $supervisor->families->count() }}</td>
                <td>
                  @if ($supervisor->families->count() > 0)
                    <a href="{{ route('supervisors.families', $supervisor->id) }}" class="btn btn-primary active p-1 px-2">الاسر</a>
                  @else
                    لا توجد اسر
                  @endif
                </td>
                <td>
                  <a href="{{ route('supervisors.edit', $supervisor->id) }}" class="btn btn-success px-2">
                    <i class="fas fa-edit fa-sm"></i>
                  </a>
                  <a href="{{ route('supervisors.delete', $supervisor->id) }}" class="btn btn-danger px-2">
                    <i class="fas fa-trash fa-sm"></i>
                  </a>
                </td>
              </tr>
            @endforeach
            @else
              <tr>
                <td colspan="5">لايوجد مشرفون بعد</td>
              </tr>
            @endif

          </x-slot:body>
        </x-table>

      {{ $supervisors->links('vendor.pagination.bootstrap-5') }}

      </div>

    </div>



  @include('components.footer')