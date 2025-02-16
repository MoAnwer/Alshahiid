@include('components.header', ['page_title' => ' الاسر التي يشرف عليها' . $supervisorName->name ])

 <div id="wrapper">

  @include('components.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

      @include('components.navbar')

      <div class="container-fluid mt-4">


       <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style">
          <li class="breadcrumb-item">
              <a href="{{route('home') }}">الرئيسية</a>
              /               
            </li>
            <li class="breadcrumb-item mx-1">
              <a href="{{route('supervisors.index') }}">المشرفين</a>
            </li>
            <li class="breadcrumb-item active " >
             الاسر التي يشرف عليها {{ $supervisorName->name }}
            </li>
          </ol>
        </nav>

        <hr />


        <div class="d-flex justify-content-between align-items-center pl-3">
          <h3>الاسر التي يشرف عليها {{ $supervisorName->name }}</h3>

             @if (request()->query('show') == 'true' || empty(request()->query('show')))
              
              {{-- Show btns --}}
                @if (is_null(request()->query('hiddenNotesAndActions')) || request()->query('hiddenNotesAndActions') == 'true')
                  <a class="btn btn-info active  mr-2" href="{{ request()->fullUrlWithQuery(['hiddenNotesAndActions' => 'false']) }}" >
                    <i class="bi bi-eye-slash ml-2"></i>
                    إخفاء زر  الملف
                  </a>
                @else
                  <a class=" mr-2 btn btn-success active " href="{{ request()->fullUrlWithQuery(['hiddenNotesAndActions' => 'true']) }}" >
                    <i class="bi bi-eye ml-2"></i>
                      عرض  زر الملف
                  </a>
                @endif
              {{--/ Show btns --}}

            @endif
        </div>

               
        <div class="search-form">
          <form action="{{ URL::current() }}" method="GET">

            <hr>
            <div class="row px-2 mt-4">
        
          
              <input type="hidden" name="show" value="true">


              <div class="col-3">
                  <label>بحث باستخدام :</label>
                  <div class="form-group">
                      <select name="search" class="form-select">
                        <option value="all"> --- </option>
                        <option value="name" @selected(request('search') == 'name')>اسم الشهيد</option>
                        <option value="militarism_number" @selected(request('search') == 'militarism_number')>النمرة العسكرية للشهيد</option>
                        <option value="force" @selected(request('search') == 'force')>قوة الشهيد</option>
                      </select>
                    </div>
                </div>


              <div class="col-2">
                <label>بحث عن: </label>
                <div class="form-group">
                  <input name="needel" type="text" maxlength="60" class="form-control py-4" value="{{ old('needel') ??  request('needel')}}" />
                </div>
              </div>

               <div class="col-2">
                <label> الشريحة :</label>
                <div class="form-group">
                    <select name="category" class="form-select">
                      <option value="all">الكل</option>
                       @foreach(['أرملة و ابناء','أب و أم و أخوان و أخوات','أخوات','مكتفية'] as $category)
                          <option value="{{ $category }}" @selected(request()->query('category') == $category)>{{ $category }}</option>
                        @endforeach
                    </select>
                  </div>
              </div>

                 <div class="col-2">
                <label>القطاع :</label>
                <div class="form-group">
                    <select name="sector" class="form-select">
                      <option value="all">كل القطاعات</option>
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
                      <option value="all">كل المحليات </option>
                      @foreach(['كسلا','خشم القربة','همشكوريب','تلكوك وتوايت','شمال الدلتا','اروما','ريفي كسلا','غرب كسلا','محلية المصنع محطة ود الحليو','نهر عطبرة','غرب كسلا','حلفا الجديدة'] as $locality)
                        <option value="{{ $locality }}" @selected(request('locality') == $locality)>{{ $locality }}</option>
                        @endforeach
                      </select>
                  </div>
              </div>

            <div class="col-1  d-flex align-items-center">
              <div class="mt-3 d-flex align-items-center flex-column justify-content-center mx-1">
                <button class="btn py-4 btn-primary active form-control " title="بحث ">
                  <i class="bi bi-search ml-2"></i>
                </button>
              </div>

              <div class="mt-3 d-flex align-items-center flex-column justify-content-center">
              <a class="btn py-4 btn-success active form-control " title="الغاء الفلاتر" href="{{ request()->url() }}">
                  <i class="bi bi-menu-button ml-2"></i>
                </a>
              </div>

            </div>
              
        </div>

        <x-table>
          <x-slot:head>
            <th>اسرة الشهيد</th>
            <th>عدد افراد الاسرة</th>
            <th>الشريحة</th>
            @if (request()->query('sector') == 'all' || is_null(request()->query('sector')) )
              <th>القطاع</th>
              @endif
            @if (request()->query('locality') == 'all'|| is_null(request()->query('locality')) )
              <th>المحلية</th>
            @endif
              @if (is_null(request()->query('hiddenNotesAndActions')) || request()->query('hiddenNotesAndActions') == 'true')
                <th>الملف</th>
              @endif

          </x-slot:head>

        <x-slot:body>        
            @forelse ($families as $family)
              <tr>
                <td>{{ $family->martyr_name }}</td>
                <td>{{ $family->family_size }}</td>
                <td>{{ $family->category }}</td>

                @if (request()->query('sector') == 'all' || is_null(request()->query('sector')) )
                  <td>{{ $family->sector }}</td>
                @endif

                @if (request()->query('locality') == 'all'|| is_null(request()->query('locality')) )
                  <td>{{ $family->locality }}</td>
                @endif

                @if (is_null(request()->query('hiddenNotesAndActions')) || request()->query('hiddenNotesAndActions') == 'true')

                <td>
                    <a href="{{ route('families.show', $family->family_id) }}" class="btn btn-primary active  py-1 px-2">
                      <i class="bi bi-person-fill" title="عرض ملف الاسرة" target="_blank" ></i>
                    </a>
                </td>

                @endif

              </tr>
            @empty
              <tr>
                <td colspan="6">لا توجد نتائج</td>
              </tr>
            @endforelse

            <caption>
              الاسر التي يشرف عليها  {{ $supervisorName->name }}
              @if(request()->query('search') == 'martyr_name')
              اسرة الشهيد {{ request()->query('needel') }} 
              @endif

              @if(request()->query('search') == 'force')
                 {{ request()->query('needel') }} 
              @endif
                
               @if(request()->query('category') != 'all')
                  {{ request()->query('category') }}
                @else
                  كل الشرائح
                @endif

              @if(request()->query('sector') == 'all' || empty(request()->query('sector')))
                كل القطاعات
                @else
                  {{ request()->query('sector') }}
                @endif

                @if(request()->query('locality') == 'all' || empty(request()->query('locality')))
                كل المحليات
                @else
                  {{ request()->query('locality') }}
              @endif

            </caption>

          </x-slot:body>
        </x-table>
        {{ $families->links('vendor.pagination.bootstrap-5') }}

        <hr>
        عدد الاسر الكلي  المشرف عليها : <b>{{ $families->total() }}</b>
      </div>
    </div>
  @include('components.footer')