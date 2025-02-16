@include('components.header', ['page_title' => "قائمة  الأرامل"])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')
      

      <div class="container-fluid mt-4">

        <div class="d-flex justify-content-between align-items-center pl-3">
          <h3>قائمة  الأرامل</h3>
        </div>


          <div class="search-form mx-3 mt-3">
          <form action="{{ URL::current() }}" method="GET">

            <div class="row">
              
              <div class="col-6">
                <label>بحث باستخدام :</label>
                <div class="form-group">
                    <select name="search" class="form-select">
                      <option value="name" @selected(request('search') == 'name')>اسم </option>
                      <option value="age" @selected(request('search') == 'age')>العمر</option>
                      <option value="national_number" @selected(request('search') == 'national_number')>الرقم الوطني</option>
                      <option value="force" @selected(request('search') == 'force')>القوة العسكرية للشهيد</option>
                    </select>
                  </div>
              </div>

              <div class="col-5">
                <label>القيمة: </label>
                <div class="form-group">
                  <input name="needel" type="text" maxlength="60" class="form-control py-4" value="{{ old('needel') ??  request('needel')}}" />
                </div>
              </div>

              <div class="col-1 mt-3 d-flex align-items-center">
                <button class="btn py-3 px-2 btn-primary active form-control ml-2" title="بحث">
                  <i class="bi bi-search"></i>
                </button>
                <a class="btn py-3 px-2 btn-success active form-control " title="القائمة" href="{{ route('widows.index') }}">
                  <i class="bi bi-menu-button"></i>
                </a>
              </div>

              </form>

            </div>
        </div> {{-- search form --}}

        <x-alert />

        <x-table>
          <x-slot:head>
            <th>#</th>
            <th>الاسم</th>
            <th>العمر</th>
            @if(request()->query('search') != 'force')
            <th>القوة العسكرية للشهيد</th>
            @endif
            <th>الصورة</th>
            <th>الرقم الوطني</th>
            <th>رقم الهاتف</th>
            <th>الملف</th>
            <th>عمليات</th>
          </x-slot:head>

          <x-slot:body>
            @forelse ($widows as $widow)
              <tr>
                <td>{{ $widow->widow_id }}</td>
                <td>{{ $widow->name }}</td>
                <td>{{ $widow->age }}</td>
                @if(request()->query('search') != 'force')
                <td>{{ @$widow->force }}</td>
                @endif
                <td>
                  @empty($widow->personal_image)
                    -
                  @else
                    <a href="{{ url("uploads/images/{$widow->personal_image}") }}" target="_blank">
                      <i class="bi bi-person-vcard fs-3"></i>
                    </a>
                  @endempty
                </td>
                <td>{{ $widow->national_number }}</td>
                <td>{{ $widow->phone_number }}</td>
                {{-- <td>{{ @$widow->family->address->sector ?? '-'}}</td>
                <td>{{ @$widow->family->address->locality ?? '-' }}</td>
                <td>{{ @$widow->family->address->neighborhood ?? '-' }}</td> --}}
                <td>
                  <a href="{{ route('familyMembers.show', $widow->widow_id) }}" class="btn btn-primary active px-2 py-1">
                    <i class="bi bi-person-rolodex mx-1"></i>
                    ملف  الأرملة
                  </a>
                </td>
                <td>
                  <a href="{{ route('familyMembers.edit',  $widow->widow_id) }}" class="btn btn-success py-1 px-2">
                    <i class="bi bi-pen fa-sm" title="تعديل"></i>
                  </a>
                  <a href="{{ route('familyMembers.delete',  $widow->widow_id) }}" class="btn btn-danger py-1 px-2">
                    <i class="bi bi-trash-fill" title="حذف"></i>
                  </a>
                </td>
              </tr>
            @empty
              <tr><td colspan="12">لا توجد نتائج</td></tr>
            @endforelse
          </x-slot:body>
        </x-table>

      {{ $widows->withQueryString()->appends(['searching' => 1])->links('vendor.pagination.bootstrap-5') }}

      </div>


    </div>

  @include('components.footer')