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


          <div class="search-form">
          <form action="{{ URL::current() }}" method="GET">

            <div class="row">
              
              <div class="col-6">
                <label>بحث باستخدام :</label>
                <div class="form-group">
                    <select name="search" class="form-select">
                      <option value="name" @selected(request('search') == 'name')>اسم الشهيد</option>
                      <option value="militarism_number" @selected(request('search') == 'militarism_number')>النمرة العسكرية</option>
                      <option value="record_number" @selected(request('search') == 'record_number')> رقم السجل</option>
                    </select>
                  </div>
              </div>

              <div class="col-5">
                <label>القيمة: </label>
                <div class="form-group">
                  <input name="needel" type="text" maxlength="60" class="form-control py-4" value="{{ old('needel') ??  request('needel')}}" />
                </div>
              </div>

              <div class="col-1 mt-3 d-flex align-items-center flex-column justify-content-center">
                <button class="btn py-4 btn-primary active form-control ">
                  <i class="fas fa-search ml-2"></i>
                  بحث 
                </button>
              </div>

              </form>

            </div>
        </div> {{-- search form --}}


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
            @forelse ($martyrs as $martyr)
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
            @empty
              <tr><td colspan="12"> لا توجد نتائج </td></tr>
            @endforelse
          </x-slot:body>
        </x-table>

      {{ $martyrs->withQueryString()->appends(['search' => 1])->links('vendor.pagination.bootstrap-5') }}

      </div>

    </div>



  @include('components.footer')