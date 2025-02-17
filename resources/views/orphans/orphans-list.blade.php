@include('components.header', ['page_title' => "قائمة  الأيتام"])

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
            <li class="breadcrumb-item mx-1">
              <a href="{{ route('orphans.index') }}">قسم الايتام</a>
              /
            </li>
            <li  class="breadcrumb-item active">قائمة الايتام</li>
          </ol>
        </nav>
        
        <hr>
        
      </div>

      <div class="container-fluid mt-4">

        <div class="d-flex justify-content-between align-items-center pl-3">
          <h3>قائمة  الأيتام</h3>

            @if (request()->query('hiddenNotesAndActions') == 'true')
            <a class="btn btn-success active  mr-2" href="{{  request()->fullUrlWithQuery(['hiddenNotesAndActions' => 'false']) }}" >
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
        <hr>



          <div class="search-form mx-3 mt-3">
          <form action="{{ URL::current() }}" method="GET">

            <div class="row">
              
              <div class="col-3">
                <label>بحث باستخدام :</label>
                <div class="form-group">
                    <select name="search" class="form-select">
                      <option value="">بحث باستخدام </option>
                      <option value="name" @selected(request('search') == 'name')>اسم </option>
                      <option value="age" @selected(request('search') == 'age')>العمر</option>
                      <option value="martyr_name" @selected(request('search') == 'martyr_name')>اسم الشهيد</option>
                      <option value="militarism_number" @selected(request('search') == 'militarism_number')>النمرة العسكرية للشهيد</option>
                      <option value="national_number" @selected(request('search') == 'national_number')>الرقم الوطني</option>
                      <option value="force" @selected(request('search') == 'force')>القوة العسكرية للشهيد</option>
                      <option value="stage" @selected(request('search') == 'stage')>المرحلة</option>
                      <option value="class" @selected(request('search') == 'class' )>الصف</option>
                      <option value="school_name" @selected(request('search') == 'school_name')>المدرسة</option>
                    </select>
                  </div>
              </div>



              <div class="col-3">
                <label>بحث عن : </label>
                <div class="form-group">
                  <input name="needel" type="text" maxlength="60" class="form-control py-4" value="{{ old('needel') ??  request('needel')}}" />
                </div>
              </div>

              <div class="col-1">
                <label>النوع :</label>
                <div class="form-group">
                    <select name="gender" class="form-select">
                      <option value="all"  @selected(request('gender') == "all")>الكل</option>
                      <option value="ذكر"  @selected(request('gender') == "ذكر")>ذكر</option>
                      <option value="أنثى"  @selected(request('gender') == "أنثى")>أنثى</option>
                    </select>
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
                <a class="btn py-3 px-2 btn-success active form-control " title="إلغاء الفلاتر" href="{{ request()->url() }}">
                  <i class="bi bi-menu-button"></i>
                </a>
              </div>


              </form>

            </div>
          </div> {{-- search form --}}          
        
        <x-table>
          <x-slot:head>
            <th>#</th>
            <th>الاسم</th>
            <th>العمر</th>
            <th>الشهيد</th>
            <th>القوة العسكرية للشهيد</th>
            <th>الصورة</th>
            <th>الرقم الوطني</th>
            <th>القطاع</th>
            <th>المحلية</th>
            <th>المرحلة</th>
            <th>الصف</th>
            <th>المدرسة</th>
            @if(request()->query('hiddenNotesAndActions') == 'true')
              {{ '' }}
            @else
            <th>الملف</th>
            <th>عمليات</th>
            @endif
          </x-slot:head>

          <x-slot:body>
            @forelse ($orphans as $orphan)
              <tr>
                <td>{{ $orphan->orphan_id }}</td>
                <td>{{ $orphan->name }}</td>
                <td>{{ $orphan->age }}</td>
                <td>{{ @$orphan->martyr_name }}</td>
                <td>{{ @$orphan->force }}</td>
                <td>
                  @empty($orphan->personal_image)
                    -
                  @else
                    <a href="{{ url("uploads/images/{$orphan->personal_image}") }}" target="_blank">
                      <i class="bi bi-person-vcard fs-3"></i>
                    </a>
                  @endempty
                </td>
                <td>{{ $orphan->national_number }}</td>
                <td>{{ $orphan->sector ?? '-' }}</td>
                <td>{{ $orphan->locality ?? '-' }}</td>
                <td>{{ $orphan->stage ?? '-' }}</td>
                <td>{{ $orphan->class ?? '-' }}</td>
                <td>{{ $orphan->school_name ?? '-' }}</td>
                
                @if(request()->query('hiddenNotesAndActions') == 'true')
                  {{ '' }}
                @else
                <td>
                  <a href="{{ route('familyMembers.show', $orphan->orphan_id) }}" class="btn btn-primary active px-2 py-1" target="_blank" title=" ملف اليتيم">
                    <i class="bi bi-person-rolodex mx-1"></i>
                   
                  </a>
                </td>
                <td>
                  <a href="{{ route('familyMembers.edit', $orphan->orphan_id) }}" class="btn btn-success py-1 px-2">
                    <i class="bi bi-pen fa-sm" title="تعديل"></i>
                  </a>
                  <a href="{{ route('familyMembers.delete', $orphan->orphan_id) }}" class="btn btn-danger py-1 px-2">
                    <i class="bi bi-trash-fill" title="حذف"></i>
                  </a>
                </td>

                @endif
              </tr>
            @empty
              <tr><td colspan="13">لا توجد نتائج</td></tr>
            @endforelse

            <caption>
              قائمة الايتام

              @if(request()->query('search') == 'martyr_name')
                اسرة الشهيد {{ request()->query('needel') }}
                @endif

                @if(request()->query('search') == 'force')
                   {{ request()->query('needel') }} 
                @endif


                @if(request()->query('search') == 'militarism_number')
                اسرة الشهيد  صاحب النمرة العسكرية {{ request()->query('needel') }}
                @endif


                @if(request()->query('search') == 'school_name')
                مدرسة {{ request()->query('needel') }}
                @endif
                @if(request()->query('search') == 'class')
                الصف {{ request()->query('needel') }}
                @endif

                
                @if(!is_null(request()->query('relation')) && request()->query('relation') != 'all')
                 - {{ request()->query('relation') }} - 
                @endif

                @if(!is_null(request()->query('gender')) && request()->query('gender') != 'all')
                 {{ request()->query('gender') }} -
                @endif
                
                
                
                @if(!is_null(request()->query('stage')) && request()->query('stage') != 'all')

                  المرحلة {{  request()->query('stage') . 'ة' }} 
                    @if (!is_null(request()->query('search')) && request()->query('search') == 'class')

                    {{ ' ' . request()->query('search') == 'class' ? request()->query('search'). 'ة' : '' }} 

                  @endif
                @endif
                
                @if (request()->query('type') == 'all' && !is_null(request()->query('search')) && request()->query('search') == 'class')

                  المرحلة {{ ' ' . request()->query('search') == 'class' ? request()->query('search'). 'ة' : '' }} 

                @endif

                
                 @if(request()->query('sector') !== 'all' && !is_null(request()->query('sector')))
                  {{ request()->query('sector') }}
                  @else 
                  {{ 'كل القطاعات' }}
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

      {{ $orphans->withQueryString()->appends(['searching' => 1])->links('vendor.pagination.bootstrap-5') }}

      </div>

    </div>

  @include('components.footer')