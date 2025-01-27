@include('components.header', ['page_title' => 'الشهداء'])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">

        <div class="d-flex justify-content-between align-items-center pl-3">
          <h3>{{ __('martyrs.martyrs_list') }}</h3>
          <a class="btn btn-primary active" href="{{ route('martyrs.create')}}" >
            <i class="fas fa-plus ml-2"></i>
            {{ __('martyrs.new_martyr') }}
          </a>
        </div>

        <x-alert />

        <x-table>
          <x-slot:head>
            <th>اسم الشهيد</th>
            <th>القوة</th>
            <th>الوحدة</th>
            <th>الرتبة</th>
            <th>النمرة العسكرية</th>
            <th>تاريخ الإستشهاد</th>
            <th>مكان الإستشهاد</th>
            <th>رقم السجل</th>
            <th>تاريخ السجل</th>
            <th>الحالة الاجتماعية</th>
            <th>الاسرة</th>
            <th>عمليات</th>
          </x-slot:head>

          <x-slot:body>
            @foreach ($martyrs as $martyr)
              <tr>
                <td>{{ $martyr->name }}</td>
                <td>{{ $martyr->force }}</td>
                <td>{{ $martyr->unit }}</td>
                <td>{{ $martyr->rank }}</td>
                <td>{{ $martyr->militarism_number }}</td>
                <td>{{ $martyr->martyrdom_date }}</td>
                <td>{{ $martyr->martyrdom_place }}</td>
                <td>{{ $martyr->record_number }}</td>
                <td>{{ $martyr->record_date }}</td>
                <td>{{ $martyr->marital_status }}</td>
                <td>
                @isset($martyr->family->id)
                  <a class="btn btn-primary active p-1" href="{{ route('families.show', $martyr->family->id) }}">الاسرة</a>
                @else 
                  <a class="btn btn-success p-1" href="{{ route('families.create', $martyr->id) }}">
                    اضافة اسرة
                  </a>
                @endisset
                </td>
                <td>
                  <a href="{{ route('martyrs.edit', $martyr->id) }}" class="btn btn-success px-2">
                    <i class="fas fa-edit fa-sm"></i>
                  </a>
                  <a href="{{ route('martyrs.delete', $martyr->id) }}" class="btn btn-danger px-2">
                    <i class="fas fa-trash fa-sm"></i>
                  </a>
                </td>
              </tr>
            @endforeach
          </x-slot:body>
        </x-table>

      {{ $martyrs->links('vendor.pagination.bootstrap-5') }}

      </div>

    </div>



  @include('components.footer')