@include('components.header', ['page_title' => 'الاسر'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center pl-3">
          <h3>الاسر التي يشرف عليها {{ $supervisor->name }}</h3>
        </div>

        <x-alert />

        <x-table>
          <x-slot:head>
            <th>الاسرة</th>
            <th>عدد افراد الاسرة</th>
            <th>الشريحة</th>
            <th>السكن</th>
            <th>ملف الاسرة</th>
          </x-slot:head>

        <x-slot:body>
          @if ($supervisor->families->count() > 0)              
            @foreach ($supervisor->families()->paginate(10) as $family)
              <tr>
                <td> اسر الشهيد {{ $family->martyr->name }}</td>
                <td>{{ $family->familyMembers()->count() }}</td>
                <td>{{ $family->category }}</td>
                <td>{{ $family->address->sector . ' - محلية ' . $family->address->locality  }}</td>
                <td>
                  <a href="{{ route('families.show', $family->id) }}" class="btn btn-primary active p-1 px-2">
                    <i class="fas fa-users ml-2"></i>
                    ملف الاسرة
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
        {{ $supervisor->families()->paginate(10)->links('vendor.pagination.bootstrap-5') }}
      </div>
    </div>

  @include('components.footer')