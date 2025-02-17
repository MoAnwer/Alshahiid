@include('components.header', ['page_title' => 'دارة المستخدمين'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">

        <div class="d-flex justify-content-between align-items-center pl-3">
          <h3>
            <i class="fas fa-pepole"></i>
            ادارة المستخدمين
          </h3>
          <a class="btn btn-primary active" href="{{ route('users.create')}}" >
            <i class="fas fa-plus ml-2"></i>
            اضافة مستخدم
          </a>
        </div>

        <x-alert />

        <x-table>
          <x-slot:head>
            <td>#</td>
            <td>الاسم رباعي</td>
            <td>اسم المستخدم</td>
            <td>الوظيفة</td>
            <td>عمليات</td>
          </x-slot:head>

          <x-slot:body>
          @if($users->count() > 1)
            @foreach ($users as $user)
              @continue($user->id == auth()->id())
              <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->full_name }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->role }}</td>
                <td>
                  <a href="{{ route('users.edit', $user->id) }}" class="btn btn-success px-2">
                    <i class="bi bi-pen fa-sm"></i>
                  </a>
                  <a href="{{ route('users.delete', $user->id) }}" class="btn btn-danger px-2">
                    <i class="bi bi-trash-fill" title="حذف""></i>
                  </a>
                  <a href="{{ route('users.userLog', $user->id) }}" class="btn btn-primary active px-2">
                    <i class="bi bi-person-fill" title="ملف المستخدم"></i>
                  </a>
                </td>
              </tr>
            @endforeach
            @else
              <tr>
                <td colspan="4">لا يوجد مستخدمين بعد</td>
              </tr>
            @endif
          </x-slot:body>
        </x-table>

      {{ $users->links('vendor.pagination.bootstrap-5') }}

      </div>

    </div>



  @include('components.footer')