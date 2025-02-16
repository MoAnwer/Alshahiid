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

          @if (request()->query('hiddenNotesAndActions') == 'true')
            <a class="btn btn-success active  mr-2" href="{{ request()->fullUrlWithQuery(['hiddenNotesAndActions' => 'false']) }}" >
              <i class="bi bi-x ml-2"></i>
              عرض ازرار الملف و العمليات
            </a>
          @else
            <a class=" mr-2 btn btn-info active " href="{{ request()->fullUrlWithQuery(['hiddenNotesAndActions' => 'true']) }}" >
              <i class="bi bi-x ml-2"></i>
                إخفاء ازرار الملف و العمليات
            </a>
          @endif

        </div>

        <hr />

        <div class="search-form mx-3 mt-4">
          <form action="{{ URL::current() }}" method="GET">

            <div class="row">
              
              <div class="col-4">
                <label>بحث باستخدام :</label>
                <div class="form-group">
                    <select name="search" class="form-select">
                      <option value="">بحث باستخدام </option>
                      <option value="name" @selected(request('search') == 'name')>اسم </option>
                      <option value="age" @selected(request('search') == 'age')>العمر</option>
                      <option value="national_number" @selected(request('search') == 'national_number')>الرقم الوطني</option>
                      <option value="force" @selected(request('search') == 'force')>القوة العسكرية للشهيد</option>
                    </select>
                  </div>
              </div>

              <div class="col-3">
                <label>بحث عن : </label>
                <div class="form-group">
                  <input name="needel" type="text" maxlength="60" class="form-control py-4" value="{{ old('needel') ??  request('needel')}}" />
                </div>
              </div>

            <div class="col-2">
                <label>القطاع :</label>
                <div class="form-group">
                    <select name="sector" class="form-select">
                      <option value="all"  @selected(request('sector') == "all")>كل القطاعات</option>
                      <option value="القطاع الشرقي"  @selected(request('sector') == 'القطاع الشرقي')>القطاع الشرقي</option>
                      <option value="القطاع الشمالي" @selected(request('sector') == 'القطاع الشمالي')>القطاع الشمالي</option>
                      <option value="القطاع الغربي"  @selected(request('sector') == 'القطاع الغربي')>القطاع الغربي</option>
                    </select>
                  </div>
              </div>

              <div class="col-2">
                  <label>المحلية: </label>
                  <div class="form-group">
                    <select name="locality" class="form-select">
                      <option value="all"  @selected(request('sector') == "all")>كل المحليات</option>
                      @foreach(['كسلا','خشم القربة','همشكوريب','تلكوك وتوايت','شمال الدلتا','اروما','ريفي كسلا','غرب كسلا','محلية المصنع محطة ود الحليو','نهر عطبرة','غرب كسلا','حلفا الجديدة'] as $locality)
                        <option value="{{ $locality }}" @selected(request('locality') == $locality)>{{ $locality }}</option>
                        @endforeach
                      </select>
                  </div>
              </div>

              
              <div class="col-1 mt-3 d-flex align-items-center">
                <button class="btn py-3 px-2 btn-primary active form-control ml-2" title="بحث">
                  <i class="bi bi-search"></i>
                </button>
                <a class="btn py-3 px-2 btn-success active form-control " title="القائمة" href="{{ request()->url() }}">
                  <i class="bi bi-menu-button"></i>
                </a>
              </div>


              </form>

            </div>
          </div> {{-- search form --}}          
        
        <x-table>
          <x-slot:head>
            <th>#</th>
            @if (request()->query('search') != 'name')
              <th>الاسم</th>
            @endif
            <th>العمر</th>
            <th>الشهيد</th>
            @if(request()->query('search') != 'force')  
              <th>القوة العسكرية للشهيد</th>
            @endif
            <th>رقم الهاتف</th>
            <th>الصورة</th>
            @if(request()->query('search') != 'national_number')
              <th>الرقم الوطني</th>
            @endif

            @if (request()->query('sector') == 'all' || is_null(request()->query('sector')))
              <th>القطاع</th>
            @endif

            @if (request()->query('locality') == 'all' || is_null(request()->query('locality')))
              <th>المحلية</th>
            @endif

            @if(request()->query('hiddenNotesAndActions') == 'true')
                  {{ '' }}
            @else
              <th>الملف</th>
              <th>عمليات</th>
            @endif
            
          </x-slot:head>

          <x-slot:body>
            @forelse ($widows as $widow)
              <tr>
                <td>{{ $widow->widow_id }}</td>
                @if (request()->query('search') != 'name')
                  <td>{{ $widow->name }}</td>
                @endif
                <td>{{ $widow->age }}</td>
                <td>{{ $widow->martyr_name }}</td>

                @if(request()->query('search') != 'force')
                  <td>{{ @$widow->force }}</td>
                @endif

                <td>{{ $widow->phone_number ?? '-' }}</td>

                <td>
                  @empty($widow->personal_image)
                    -
                  @else
                    <a href="{{ url("uploads/images/{$widow->personal_image}") }}" target="_blank">
                      <i class="bi bi-person-vcard fs-3"></i>
                    </a>
                  @endempty
                </td>
                @if(request()->query('search') != 'national_number')
                  <td>{{ $widow->national_number }}</td>
                @endif

                @if (request()->query('sector') == 'all'|| is_null(request()->query('sector')))
                  <td>{{ $widow->sector ?? '-' }}</td>
                @endif

                @if (request()->query('locality') == 'all' || is_null(request()->query('locality')))
                  <td>{{ $widow->locality ?? '-' }}</td>
                @endif

                @if(request()->query('hiddenNotesAndActions') == 'true')
                  {{ '' }}
                @else
			          
                <td>
                  <a href="{{ route('familyMembers.show', $widow->widow_id) }}" class="btn btn-primary active px-2 py-1" target="_blank" title=" ملف الأرملة">
                    <i class="bi bi-person-rolodex mx-1"></i>
                  
                  </a>
                </td>
                <td>
                  <a href="{{ route('familyMembers.edit', $widow->widow_id) }}" class="btn btn-success py-1 px-2">
                    <i class="bi bi-pen fa-sm" title="تعديل"></i>
                  </a>
                  <a href="{{ route('familyMembers.delete', $widow->widow_id) }}" class="btn btn-danger py-1 px-2">
                    <i class="bi bi-trash-fill" title="حذف"></i>
                  </a>
                </td>

                @endif
              </tr>
            @empty
              <tr><td colspan="13">لا توجد نتائج</td></tr>
            @endforelse
            <caption class="text-primary">
              قائمة الأرامل

              @if (!empty(request()->query('needel')) && request()->query('search') == 'force')
                - {{ request()->query('needel') }}

              @elseif (request()->query('search') == 'national_number')

                  - رقم وطني {{ request()->query('needel') }}
                  
              @elseif (request()->query('search') == 'name')
                الارملة {{ request()->query('needel') }}
              @elseif (request()->query('search') == 'martyr_name')
                ارملة الشهيد {{ request()->query('needel') }}
              @endif

                @if(request()->query('sector') == 'all' && !is_null(request()->query('sector')))

                  @if (request()->query('locality') != 'all')

                    {{ '' }}
                    
                  @endif
                @else

                  {{ request()->query('sector') ?? 'كل القطاعات'}}
                  
                @endif
  
                @if(request()->query('locality') == 'all' && !is_null(request()->query('locality')))
                  @if (request()->query('locality') != 'all')
                    {{ '' }}
                  @endif
                @else
                {{ request()->query('locality') ?? 'كل المحليات'}}
                @endif
                
              </caption>
          </x-slot:body>
        </x-table>

      {{ $widows->withQueryString()->appends(['searching' => 1])->links('vendor.pagination.bootstrap-5') }}

      </div>

    </div>

  @include('components.footer')